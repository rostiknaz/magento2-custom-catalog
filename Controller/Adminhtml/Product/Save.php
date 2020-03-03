<?php

namespace Rnazy\CustomCatalog\Controller\Adminhtml\Product;

use Magento\Backend\App\Action as BackendAction;
use Magento\Backend\App\Action\Context;
use Rnazy\CustomCatalog\Api\ProductRepositoryInterface;
use Rnazy\CustomCatalog\Model\ProductFactory;

class Save extends BackendAction
{
    /**
     * Authorization level of a basic admin session
     *
     * @see _isAllowed()
     */
    public const ADMIN_RESOURCE = 'Rnazy_CustomCatalog::edit_product';
    /**
     * @var ProductRepositoryInterface
     */
    private $productRepository;
    /**
     * @var ProductFactory
     */
    private $productFactory;


    /**
     * @param Context $context
     * @param ProductRepositoryInterface $productRepository
     * @param ProductFactory $productFactory
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        ProductFactory $productFactory
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->productFactory = $productFactory;
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $storeId = (int)$this->getRequest()->getParam('store_id');
        $resultRedirect = $this->resultRedirectFactory->create();
        $data = $this->getRequest()->getPostValue();

        if ($data) {
            $product = $this->productFactory->create()->addData($data);

            try {
                $this->productRepository->save($product);
                $this->messageManager->addSuccessMessage(__('Product has been saved!'));
            } catch (\Exception $e) {
                $this->messageManager->addErrorMessage($e->getMessage());
            }
        }

        return $resultRedirect->setPath('*/*/', ['store' => $storeId]);
    }
}
