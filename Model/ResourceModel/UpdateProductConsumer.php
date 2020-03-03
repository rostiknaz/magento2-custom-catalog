<?php

namespace Rnazy\CustomCatalog\Model\ResourceModel;

use Rnazy\CustomCatalog\Api\Data\ProductRequestInterface;
use Rnazy\CustomCatalog\Model\ProductRepository;

class UpdateProductConsumer
{
    /**
     * @var ProductRepository
     */
    private $productRepository;

    /**
     * @param ProductRepository $productRepository
     */
    public function __construct(
        ProductRepository $productRepository
    ) {
        $this->productRepository = $productRepository;
    }

    /**
     * @param ProductRequestInterface $productRequest
     *
     * @return void
     */
    public function processMessage(ProductRequestInterface $productRequest)
    {
        $product = $productRequest->getProduct();
        $product->setData('store_id', $productRequest->getStoreId());
        $this->productRepository->save($product);
    }
}
