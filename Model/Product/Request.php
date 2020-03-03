<?php

namespace Rnazy\CustomCatalog\Model\Product;

use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\Data\ProductRequestInterface;

class Request implements ProductRequestInterface
{
    public $storeId;
    public $product;

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
     * @return ProductInterface
     */
    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    /**
     * @param ProductInterface $product
     *
     * @return ProductRequestInterface
     */
    public function setProduct(ProductInterface $product): ProductRequestInterface
    {
        $this->product = $product;

        return $this;
    }
}
