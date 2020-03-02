<?php

namespace Rnazy\CustomCatalog\Model\ResourceModel;

use Magento\Eav\Model\Entity;
use Magento\Eav\Model\Entity\AbstractEntity;
use Magento\Eav\Model\Entity\Attribute\AbstractAttribute;
use Magento\Eav\Model\Entity\Context;
use Magento\Eav\Model\Entity\Type;
use Magento\Framework\DataObject;
use Magento\Framework\EntityManager\EntityManager;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Magento\Store\Model\Store;
use Magento\Store\Model\StoreManagerInterface;
use RH\HelloWorld\Setup\HelloWorldSetup;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;

class Product extends AbstractEntity
{
    /**
     * Store id
     *
     * @var int
     */
    protected $_storeId = null;

    /**
     * @var StoreManagerInterface
     */
    protected $_storeManager;

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @param Context $context
     * @param StoreManagerInterface $storeManager
     * @param array $data
     */
    public function __construct(
        Context $context,
        StoreManagerInterface $storeManager,
        array $data = []
    ) {
        parent::__construct($context, $data);
        $this->setType(ProductInterface::ENTITY_CODE);
        $this->setConnection(ProductInterface::ENTITY_CODE . '_read', ProductInterface::ENTITY_CODE . '_write');
        $this->_storeManager = $storeManager;
    }

    /**
     * Set attribute set id and entity type id value
     *
     * @param DataObject $customer
     *
     * @return $this
     */
    protected function _beforeSave(DataObject $object)
    {
        $object->setAttributeSetId($object->getAttributeSetId() ?: $this->getEntityType()->getDefaultAttributeSetId());
        $object->setEntityTypeId($object->getEntityTypeId() ?: $this->getEntityType()->getEntityTypeId());

        return parent::_beforeSave($object);
    }

    /**
     * Return Entity Type instance
     *
     * @return Type
     *
     * @throws LocalizedException
     */
    public function getEntityType()
    {
        if (empty($this->_type)) {
            $this->setType(ProductInterface::ENTITY_CODE);
        }

        return parent::getEntityType();
    }

    /**
     * Retrieve Product entity default attributes
     *
     * @return string[]
     */
    protected function _getDefaultAttributes()
    {
        return [
            'attribute_set_id',
            'entity_type_id',
            'created_at',
            'updated_at',
        ];
    }

    /**
     * Set store Id
     *
     * @param integer $storeId
     *
     * @return $this
     */
    public function setStoreId($storeId): self
    {
        $this->_storeId = $storeId;

        return $this;
    }

    /**
     * Return store id
     *
     * @return integer
     *
     * @throws NoSuchEntityException
     */
    public function getStoreId(): int
    {
        if ($this->_storeId === null) {
            return $this->_storeManager->getStore()->getId();
        }

        return $this->_storeId;
    }

    /**
     * Set Attribute values to be saved
     *
     * @param AbstractModel $object
     * @param AbstractAttribute $attribute
     * @param mixed $value
     *
     * @return $this
     *
     * @throws LocalizedException
     */
    protected function _saveAttribute($object, $attribute, $value)
    {
        $table = $attribute->getBackend()->getTable();

        if (!isset($this->_attributeValuesToSave[$table])) {
            $this->_attributeValuesToSave[$table] = [];
        }

        $entityIdField = $attribute->getBackend()->getEntityIdField();
        $storeId = $object->getStoreId() ?: Store::DEFAULT_STORE_ID;
        $data = [
            $entityIdField => $object->getId(),
            'attribute_id' => $attribute->getId(),
            'value' => $this->_prepareValueForSave($value, $attribute),
            'store_id' => $storeId,
        ];

        if (!$this->getEntityTable() || $this->getEntityTable() === Entity::DEFAULT_ENTITY_TABLE) {
            $data['entity_type_id'] = $object->getEntityTypeId();
        }

        if ($attribute->isScopeStore()) {
            /**
             * Update attribute value for store
             */
            $this->_attributeValuesToSave[$table][] = $data;
        } elseif ($attribute->isScopeWebsite() && $storeId != Store::DEFAULT_STORE_ID) {
            /**
             * Update attribute value for website
             */
            $storeIds = $this->_storeManager->getStore($storeId)->getWebsite()->getStoreIds(true);
            foreach ($storeIds as $storeId) {
                $data['store_id'] = (int) $storeId;
                $this->_attributeValuesToSave[$table][] = $data;
            }
        } else {
            /**
             * Update global attribute value
             */
            $data['store_id'] = Store::DEFAULT_STORE_ID;
            $this->_attributeValuesToSave[$table][] = $data;
        }

        return $this;
    }
}
