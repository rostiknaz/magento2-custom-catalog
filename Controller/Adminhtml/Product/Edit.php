<?php

namespace Rnazy\CustomCatalog\Controller\Adminhtml\Product;

class Edit extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Rnazy_CustomCatalog::edit_product';

    /**
     * @return string
     */
    protected function getPageTitle(): string
    {
        return 'Edit Product';
    }
}
