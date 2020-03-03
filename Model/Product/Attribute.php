<?php

namespace Rnazy\CustomCatalog\Model\Product;

use Magento\Eav\Model\Entity\Attribute as EavAttribute;
use Magento\Eav\Model\Entity\Attribute\ScopedAttributeInterface;
use Magento\Eav\Model\Entity\Attribute\Source\AbstractSource;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Model\AbstractModel;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;


class Attribute extends EavAttribute implements ScopedAttributeInterface
{
    /**
     * Constants
     */
    const MODULE_NAME = 'Rnazy_CustomCatalog';
    const KEY_IS_GLOBAL = 'is_global';
    const KEY_IS_STATIC = 'static';

    /**
     * Event object name
     *
     * @var string
     */
    protected $_eventObject = 'attribute';

    /**
     * Event prefix
     *
     * @var string
     */
    protected $_eventPrefix = ProductInterface::ENTITY_CODE . '_attribute';

    /**
     * @return void
     */
    protected function _construct()
    {

        $this->_init(\Rnazy\CustomCatalog\Model\ResourceModel\Product\Attribute::class);
    }

    /**
     * Processing object before save data
     *
     * @return AbstractModel
     *
     * @throws LocalizedException
     */
    public function beforeSave()
    {
        $this->setData('modulePrefix', self::MODULE_NAME);
        if (isset($this->_origData[self::KEY_IS_GLOBAL]) && !isset($this->_data[self::KEY_IS_GLOBAL])) {
            $this->_data[self::KEY_IS_GLOBAL] = self::SCOPE_GLOBAL;
        }

        return parent::beforeSave();
    }

    /**
     * Processing object after save data
     *
     * @return AbstractModel
     *
     * @throws LocalizedException
     */
    public function afterSave()
    {
        /**
         * Fix saving attribute in admin
         */
        $this->_eavConfig->clear();

        return parent::afterSave();
    }

    /**
     * Return is attribute global
     *
     * @return integer
     */
    public function getIsGlobal(): int
    {
        if ($this->getBackendType() === self::KEY_IS_STATIC) {
            return self::SCOPE_GLOBAL;
        }
        return $this->_getData(self::KEY_IS_GLOBAL);
    }

    /**
     * Retrieve attribute is global scope flag
     *
     * @return bool
     */
    public function isScopeGlobal(): bool
    {
        return $this->getIsGlobal() === self::SCOPE_GLOBAL;
    }

    /**
     * Retrieve attribute is website scope website
     *
     * @return bool
     */
    public function isScopeWebsite(): bool
    {
        return $this->getIsGlobal() === self::SCOPE_WEBSITE;
    }

    /**
     * Retrieve attribute is store scope flag
     *
     * @return bool
     */
    public function isScopeStore(): bool
    {
        return $this->getIsGlobal() === self::SCOPE_STORE;
    }

    /**
     * Retrieve store id
     *
     * @return int
     */
    public function getStoreId(): int
    {
        $dataObject = $this->getDataObject();
        if ($dataObject) {
            return (int) $dataObject->getStoreId();
        }

        return (int) $this->getData('store_id');
    }

    /**
     * Retrieve source model
     *
     * @return AbstractSource
     */
    public function getSourceModel()
    {
        $model = $this->getData('source_model');
        if (empty($model) && $this->getBackendType() === 'int' && $this->getFrontendInput() === 'select') {
            return $this->_getDefaultSourceModel();
        }

        return $model;
    }

    /**
     * Get default attribute source model
     *
     * @return string
     */
    public function _getDefaultSourceModel()
    {
        return \Magento\Eav\Model\Entity\Attribute\Source\Table::class;
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete()
    {
        $this->_eavConfig->clear();

        return parent::afterDelete();
    }
}
