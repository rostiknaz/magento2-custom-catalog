<?php

namespace Rnazy\CustomCatalog\Api\Data;

use Magento\Framework\Api\SearchResultsInterface;

interface ProductSearchResultInterface extends SearchResultsInterface
{
    /**
     * @return ProductInterface[]
     */
    public function getItems();

    /**
     * @param ProductInterface[] $items
     * @return void
     */
    public function setItems(array $items);
}
