<?php

namespace Rnazy\CustomCatalog\Model\ResourceModel\Product;

use Magento\Catalog\Api\Data\ProductInterface;
use Magento\Catalog\Model\Attribute\LockValidatorInterface;
use Magento\Eav\Model\Config;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\ResourceModel\Entity\Type;
use Magento\Framework\EntityManager\MetadataPool;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Magento\Framework\Model\ResourceModel\Db\Context;
use Magento\Store\Model\StoreManagerInterface;

class Attribute extends \Magento\Eav\Model\ResourceModel\Entity\Attribute
{
    /**
     * Eav config
     *
     * @var Config
     */
    protected $_eavConfig;

    /**
     * @var LockValidatorInterface
     */
    protected $attrLockValidator;

    /**
     * @var MetadataPool
     */
    protected $metadataPool;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param Type $eavEntityType
     * @param Config $eavConfig
     * @param LockValidatorInterface $lockValidator
     * @param string $connectionName
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        Type $eavEntityType,
        Config $eavConfig,
        LockValidatorInterface $lockValidator,
        $connectionName = null
    ) {
        $this->attrLockValidator = $lockValidator;
        $this->_eavConfig = $eavConfig;
        parent::__construct($context, $storeManager, $eavEntityType, $connectionName);
    }

    /**
     * Perform actions before object save
     *
     * @param AbstractModel $object
     *
     * @return \Magento\Eav\Model\ResourceModel\Entity\Attribute
     *
     * @throws LocalizedException
     */
    protected function _beforeSave(AbstractModel $object)
    {
        $applyTo = $object->getApplyTo();
        if (is_array($applyTo)) {
            $object->setApplyTo(implode(',', $applyTo));
        }
        return parent::_beforeSave($object);
    }

    /**
     * Perform actions after object save
     *
     * @param AbstractModel $object
     *
     * @return \Magento\Eav\Model\ResourceModel\Entity\Attribute
     */
    protected function _afterSave(AbstractModel $object)
    {
        $this->clearUselessAttributeValues($object);

        return parent::_afterSave($object);
    }

    /**
     * Clear useless attribute values
     *
     * @param AbstractModel $object
     *
     * @return $this
     */
    protected function clearUselessAttributeValues(AbstractModel $object): self
    {
        $origData = $object->getOrigData();

        if ($object->isScopeGlobal()
            && isset($origData['is_global'])
            && ScopedAttributeInterface::SCOPE_GLOBAL !== $origData['is_global']
        ) {
            $attributeStoreIds = array_keys($this->_storeManager->getStores());

            if (!empty($attributeStoreIds)) {
                $delCondition = ['attribute_id = ?' => $object->getId(), 'store_id IN(?)' => $attributeStoreIds,];
                $this->getConnection()->delete($object->getBackendTable(), $delCondition);
            }
        }

        return $this;
    }

    /**
     * Delete entity
     *
     * @param AbstractModel $object
     *
     * @return $this
     *
     * @throws LocalizedException
     */
    public function deleteEntity(AbstractModel $object)
    {
        if (!$object->getEntityAttributeId()) {
            return $this;
        }

        $result = $this->getEntityAttribute($object->getEntityAttributeId());
        if ($result) {
            $attribute = $this->_eavConfig->getAttribute($object->getEntityTypeId(), $result['attribute_id']);

            try {
                $this->attrLockValidator->validate($attribute, $result['attribute_set_id']);
            } catch (LocalizedException $exception) {
                throw new LocalizedException(__('Attribute \'%1\' is locked. %2', $attribute->getAttributeCode(), $exception->getMessage()));
            }

            $backendTable = $attribute->getBackend()->getTable();
            if ($backendTable) {
                $linkField = $this->getMetadataPool()->getMetadata(ProductInterface::class)->getLinkField();

                $backendLinkField = $attribute->getBackend()->getEntityIdField();

                $select =
                    $this->getConnection()
                        ->select()
                        ->from(['b' => $backendTable])
                        ->join(['e' => $attribute->getEntity()->getEntityTable()], "b.$backendLinkField = e.$linkField")
                        ->where('b.attribute_id = ?', $attribute->getId())
                        ->where('e.attribute_set_id = ?', $result['attribute_set_id']);

                $this->getConnection()->query($select->deleteFromSelect('b'));
            }
        }

        $condition = ['entity_attribute_id = ?' => $object->getEntityAttributeId()];
        $this->getConnection()->delete($this->getTable('eav_entity_attribute'), $condition);

        return $this;
    }

    /**
     * @return MetadataPool
     */
    private function getMetadataPool(): MetadataPool
    {
        if (null === $this->metadataPool) {
            $this->metadataPool = \Magento\Framework\App\ObjectManager::getInstance()->get(MetadataPool::class);
        }

        return $this->metadataPool;
    }
}
