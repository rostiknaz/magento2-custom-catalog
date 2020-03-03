<?php

namespace Rnazy\CustomCatalog\Model\Product;

use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\Data\ProductRequestInterface;

class Request implements ProductRequestInterface
{
    public $storeId;
    public $product;

    /**
     * Object attributes
     *
     * @var array
     */
    protected $_data = [];

    /**
     * Constructor
     *
     * By default is looking for first argument as array and assigns it as object attributes
     * This behavior may change in child classes
     *
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        $this->_data = $data;
    }

    /**
     * {@inheritdoc}
     */
    public function getStoreId(): int
    {
        return $this->storeId;
    }

    /**
     * {@inheritdoc}
     */
    public function setStoreId(int $storeId): ProductRequestInterface
    {
        $this->storeId = $storeId;

        return $this;
    }

    /**
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface
     */
    public function getProduct(): \Rnazy\CustomCatalog\Api\Data\ProductInterface
    {
        return $this->product;
    }

    /**
     * @param \Rnazy\CustomCatalog\Api\Data\ProductInterface $product
     *
     * @return ProductRequestInterface
     */
    public function setProduct(\Rnazy\CustomCatalog\Api\Data\ProductInterface $product): ProductRequestInterface
    {
        $this->product = $product;

        return $this;
    }

    /**
     * Get value from _data array without parse key
     *
     * @return  array
     */
    public function getData()
    {
        return $this->_data;
    }

    /**
     * If $key is empty, checks whether there's any data in the object
     *
     * Otherwise checks if the specified attribute is set.
     *
     * @param string $key
     * @return bool
     */
    public function hasData($key = '')
    {
        if (empty($key) || !is_string($key)) {
            return !empty($this->_data);
        }
        return array_key_exists($key, $this->_data);
    }

    /**
     * Checks whether the object is empty
     *
     * @return bool
     */
    public function isEmpty()
    {
        if (empty($this->_data)) {
            return true;
        }
        return false;
    }
}
