<?php

namespace Rnazy\CustomCatalog\Block\Adminhtml\Product\Edit\Button;

class Delete extends Generic
{
    /**
     * @return array
     */
    public function getButtonData()
    {
        return [
            'label' => __('Delete'),
            'on_click' => 'deleteConfirm(\'' . __('Are you sure you want to delete this product ?') . '\', \'' . $this->getDeleteUrl() . '\')',
            'class' => 'delete',
            'sort_order' => 20
        ];
    }

    /**
     * @return string
     */
    public function getDeleteUrl()
    {
        $url = $this->url->getCurrentUrl();
        $parts = explode('/', parse_url($url, PHP_URL_PATH));
        $id = $parts[6];

        return $this->getUrl('*/*/delete', ['id' => $id]);
    }
}
