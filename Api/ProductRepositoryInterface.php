<?php

namespace Rnazy\CustomCatalog\Api;

use Rnazy\CustomCatalog\Api\Data\ProductInterface;

interface ProductRepositoryInterface
{
    /**
     * @param \Rnazy\CustomCatalog\Api\Data\ProductInterface $product
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\CouldNotSaveException
     */
    public function save(ProductInterface $product);

    /**
     * @param int $ruleId
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function getById($entityId);

    /**
     * @param \Rnazy\CustomCatalog\Api\Data\ProductInterface $product
     *
     * @throws \Magento\Framework\Exception\CouldNotDeleteException
     */
    public function delete(ProductInterface $product);
}
