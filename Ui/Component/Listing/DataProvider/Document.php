<?php

namespace Rnazy\CustomCatalog\Ui\Component\Listing\DataProvider;

class Document extends \Magento\Framework\View\Element\UiComponent\DataProvider\Document
{
    protected $_idFieldName = 'entity_id';

    public function getIdFieldName()
    {
        return $this->_idFieldName;
    }
}
