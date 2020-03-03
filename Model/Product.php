<?php

namespace Rnazy\CustomCatalog\Model;

use Magento\Framework\DataObject\IdentityInterface;
use Magento\Framework\Model\AbstractExtensibleModel;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;

class Product extends AbstractExtensibleModel implements ProductInterface, IdentityInterface
{
    /**
     * Product cache tag
     */
    const CACHE_TAG = 'rnazy_p';

    /**
     * @var string
     */
    protected $_cacheTag = self::CACHE_TAG;

    /**
     * @var string
     */
    protected $_eventPrefix = 'rnazy_custom_product';

    /**
     * @var string
     */
    protected $_eventObject = 'rnazy_product';

    /**
     * Name of object id field
     *
     * @var string
     */
    protected $_idFieldName = self::ID;

    /**
     * Initialize resources
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init(ProductResourceModel::class);
    }

    /**
     * @return array
     */
    public function getIdentities()
    {
        return [self::CACHE_TAG . '_' . $this->getId()];
    }

    /**
     * @return string
     */
    public function getSku(): string
    {
        return (string) $this->getData(self::SKU);
    }

    /**
     * @param string $sku
     *
     * @return ProductInterface
     */
    public function setSku(string $sku): ProductInterface
    {
        return $this->setData(self::SKU, $sku);
    }

    /**
     * @return string
     */
    public function getCopywriteInfo(): string
    {
        return (string) $this->getData(self::COPYWRITE_INFO);
    }

    /**
     * @param string $info
     *
     * @return ProductInterface
     */
    public function setCopywriteInfo(string $info): ProductInterface
    {
        return $this->setData(self::COPYWRITE_INFO, $info);
    }

    /**
     * @return string
     */
    public function getVpn(): string
    {
        return (string) $this->getData(self::VPN);
    }

    /**
     * @param string $vpn
     *
     * @return ProductInterface
     */
    public function setVpn(string $vpn): ProductInterface
    {
        return $this->setData(self::VPN, $vpn);
    }

    /**
     * Set attribute set entity type id
     *
     * @param int $entityTypeId
     *
     * @return $this
     */
    public function setEntityTypeId($entityTypeId)
    {
        return $this->setData(self::KEY_ENTITY_TYPE_ID, $entityTypeId);
    }

    /**
     * {@inheritdoc}
     */
    public function getEntityTypeId()
    {
        return $this->getData(self::KEY_ENTITY_TYPE_ID);
    }

    /**
     * Set attribute set id
     *
     * @param int $attrSetId
     *
     * @return $this
     */
    public function setAttributeSetId($attrSetId): self
    {
        return $this->setData(self::KEY_ATTR_TYPE_ID, $attrSetId);
    }

    /**
     * {@inheritdoc}
     */
    public function getAttributeSetId()
    {
        return $this->getData(self::KEY_ATTR_TYPE_ID);
    }
}
