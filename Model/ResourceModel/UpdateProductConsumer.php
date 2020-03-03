<?php

namespace Rnazy\CustomCatalog\Model\ResourceModel;

use Psr\Log\LoggerInterface;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\Data\ProductRequestInterface;
use Rnazy\CustomCatalog\Model\ProductRepository;
use Magento\Store\Model\StoreManagerInterface;

class UpdateProductConsumer
{

    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * UpdateProductConsumer constructor.
     *
     * @param ProductRepository $productRepository
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     */
    public function __construct(
        ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        LoggerInterface $logger
    ) {
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->logger = $logger;
    }

    /**
     * @var string
     */
    private $logFileName = 'product-update-consumer.log';

    /**
     * @param ProductInterface $product
     * @throws \Magento\Framework\Exception\LocalizedException
     * @return void
     */
    public function processMessage(ProductRequestInterface $productRequest)
    {
//        $this->logger->debug($productRequest->getProduct()->getData());
        $product = $productRequest->getProduct();
        $product->setData('store_id', $productRequest->getStoreId());
        $this->productRepository->save($product);
    }
}
