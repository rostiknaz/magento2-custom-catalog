<?php

namespace Rnazy\CustomCatalog\Controller\Adminhtml\Product;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Rnazy\CustomCatalog\Api\ProductRepositoryInterface;

class Delete extends BackendAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Rnazy_CustomCatalog::delete_product';

    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;


    /**
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $entityId = (int)$this->getRequest()->getParam('entity_id');
        $resultRedirect = $this->resultRedirectFactory->create();

        if ($entityId) {
            try {
                $product = $this->productRepository->getById($entityId);
                $this->productRepository->delete($product);
                $this->messageManager->addSuccessMessage(__('Product has been deleted!'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/');
    }
}
