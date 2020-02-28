<?php

namespace Rnazy\CustomCatalog\Controller\Adminhtml\Product;

class NewAction extends Action
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Rnazy_CustomCatalog::new_product';

    /**
     * @return string
     */
    protected function getPageTitle(): string
    {
        return 'Add New Product';
    }

}
