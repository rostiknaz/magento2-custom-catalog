<?php

namespace Rnazy\CustomCatalog\Api\Data;

use Magento\Framework\Api\CustomAttributesDataInterface;

interface ProductRequestInterface
{
    const STORE_ID = 'store_id';
    const PRODUCT = 'product';

    /**
     * @return int
     */
    public function getStoreId(): int;

    /**
     * @param int $storeId
     *
     * @return $this
     */
    public function setStoreId(int $storeId): self;

    /**
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface
     */
    public function getProduct(): \Rnazy\CustomCatalog\Api\Data\ProductInterface;

    /**
     * @param \Rnazy\CustomCatalog\Api\Data\ProductInterface $product
     *
     * @return $this
     */
    public function setProduct(\Rnazy\CustomCatalog\Api\Data\ProductInterface $product): self;
}
