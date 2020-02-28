<?php
namespace Rnazy\CustomCatalog\Model\ResourceModel\Product;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Model\Product as ProductModel;
use Rnazy\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;

class Collection extends AbstractCollection
{
    protected $_idFieldName = ProductInterface::ID;

    protected function _construct()
    {
        $this->_init(ProductModel::class, ProductResourceModel::class);
    }
}