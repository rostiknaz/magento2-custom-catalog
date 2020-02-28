<?php

namespace Rnazy\CustomCatalog\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class Product extends AbstractDb
{
    protected function _construct()
    {
        $this->_init('rnazy_custom_catalog', \Rnazy\CustomCatalog\Model\Product::ID);
    }
}