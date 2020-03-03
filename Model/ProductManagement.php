<?php

namespace Rnazy\CustomCatalog\Model;

use Magento\Framework\Exception\NoSuchEntityException;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\Data\ProductRequestInterface;
use Rnazy\CustomCatalog\Api\ProductManagementInterface;
use Rnazy\CustomCatalog\Model\Product\RequestFactory;
use Magento\Framework\MessageQueue\PublisherInterface as Publisher;
use Magento\Store\Model\StoreManagerInterface;
use Rnazy\CustomCatalog\Model\ResourceModel\Product\Collection;
use Rnazy\CustomCatalog\Model\ResourceModel\Product\CollectionFactory;

class ProductManagement implements ProductManagementInterface
{
    const TOPIC_NAME = 'rnazy.product.update';

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
     * @var CollectionFactory
     */
    private $collectionFactory;


    /**
     * @param Publisher             $publisher
     * @param ProductRepository     $productRepository
     * @param StoreManagerInterface $storeManager
     * @param RequestFactory        $productRequestFactory
     * @param CollectionFactory     $collectionFactory
     *
     * @internal param ProductRequestInterface $productRequest
     */
    public function __construct(
        Publisher $publisher,
        ProductRepository $productRepository,
        StoreManagerInterface $storeManager,
        RequestFactory $productRequestFactory,
        CollectionFactory $collectionFactory
    ) {
        $this->publisher = $publisher;
        $this->productRepository = $productRepository;
        $this->storeManager = $storeManager;
        $this->productRequestFactory = $productRequestFactory;
        $this->collectionFactory = $collectionFactory;
    }

    /**
     * @param int $entityId
     * @param string $copywriteInfo
     * @param string $vpn
     *
     * @return ProductInterface
     * @throws NoSuchEntityException
     */
    public function asyncUpdate(int $entityId, string $copywriteInfo = '', string $vpn = '')
    {
        $product = $this->productRepository->getById($entityId);
        $product
            ->setCopywriteInfo(!empty($copywriteInfo) ? $copywriteInfo : $product->getCopywriteInfo())
            ->setVpn(!empty($vpn) ? $vpn : $product->getVpn());
        /** @var ProductRequestInterface $data */
        $data = $this->productRequestFactory->create();
        $data
            ->setStoreId($this->storeManager->getStore()->getId())
            ->setProduct($product);
        $this->publisher->publish(self::TOPIC_NAME, $data);
    }

    /**
     * @param string $vpn
     *
     * @return \Rnazy\CustomCatalog\Api\Data\ProductInterface[]
     */
    public function getByVpn(string $vpn)
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();

        return $collection
            ->setStoreId($this->storeManager->getStore()->getId())
            ->addAttributeToSelect('*')
            ->addFieldToFilter(ProductInterface::VPN, ['eq' => $vpn])
            ->getItems();
    }
}
