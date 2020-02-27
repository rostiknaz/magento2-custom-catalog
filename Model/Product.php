<?php

namespace Rnazy\CustomCatalog\Model;

use Magento\Framework\Model\AbstractExtensibleModel;
use Magento\Tests\NamingConvention\true\string;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;

class Product extends AbstractExtensibleModel implements ProductInterface
{
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
        $this->_init(\Rnazy\CustomCatalog\Model\ResourceModel\Product::class);
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
}