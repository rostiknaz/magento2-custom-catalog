<?php

namespace Rnazy\CustomCatalog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface[]
     */
    public function getItems();

    /**
     * @param \Rnazy\CustomCatalog\Api\Data\ProductInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
