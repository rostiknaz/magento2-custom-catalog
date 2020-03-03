<?php

namespace Rnazy\CustomCatalog\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\Data\ProductRequestInterface;
use Rnazy\CustomCatalog\Api\ProductManagementInterface;
use Rnazy\CustomCatalog\Model\Product\RequestFactory;
use Rnazy\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;
use Magento\Framework\MessageQueue\PublisherInterface as Publisher;
use Magento\Store\Model\StoreManagerInterface;

class ProductManagement implements ProductManagementInterface
{
    const TOPIC_NAME = 'rnazy.product.update';

    /**
     * @var ProductResourceModel
     */
    protected $productResource;

    /**
     * @var ProductFactory
     */
    protected $productFactory;
    /**
     * @var Publisher
     */
    private $publisher;
    /**
     * @var ProductRepository
     */
    private $productRepository;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var RequestFactory
     */
    private $productRequestFactory;


    /**
     * ProductManagement constructor.
     *
     * @param ProductResourceModel $productResource
     * @param ProductFactory $productFactory
     * @param Publisher $publisher
     * @param ProductRepository $productRepository
     * @param StoreManagerInterface $storeManager
     * @param ProductRequestInterface $productRequest
     */
    public function __construct(
        ProductResourceModel $productResource,
        ProductFactory $productFactory,
        Publisher $publisher,
        ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        RequestFactory $productRequestFactory
    ) {
        $this->productResource = $productResource;
        $this->productFactory = $productFactory;
        $this->publisher = $publisher;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->productRequestFactory = $productRequestFactory;
    }

    /**
     * @param int $entityId
     * @param string $copywriteInfo
     * @param string $vpn
     *
     * @return ProductInterface|void
     * @throws NoSuchEntityException
     */
    public function asyncUpdate(int $entityId, string $copywriteInfo = '', string $vpn = '')
    {
        $product = $this->productRepository->getById($entityId);
        $product
            ->setCopywriteInfo($copywriteInfo ?? $product->getCopywriteInfo())
            ->setVpn($vpn ?? $product->getVpn());
        /** @var ProductRequestInterface $data */
        $data = $this->productRequestFactory->create();
        $data
            ->setStoreId($this->storeManager->getStore()->getId())
            ->setProduct($product);
        $this->publisher->publish(self::TOPIC_NAME, $data);
    }

    public function getByVpn(string $vpn)
    {
        // TODO: Implement getByVpn() method.
    }
}
