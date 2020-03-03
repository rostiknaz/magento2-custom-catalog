<?php

namespace Rnazy\CustomCatalog\Block\Adminhtml\Product\Edit\Button;

class Delete extends Generic
{
    /**
     * @return array
     */
    public function getButtonData(): array
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
    public function getDeleteUrl(): string
    {
        $id = $this->request->getParam('entity_id');

        return $this->getUrl('*/*/delete', ['entity_id' => $id]);
    }
}
