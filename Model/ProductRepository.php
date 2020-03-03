<?php

namespace Rnazy\CustomCatalog\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Model\AbstractModel;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\Data\ProductSearchResultInterface;
use Rnazy\CustomCatalog\Api\ProductRepositoryInterface;
use Rnazy\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Rnazy\CustomCatalog\Model\Product\SearchResultFactory;

class ProductRepository implements ProductRepositoryInterface
{
    /**
     * @var ProductResourceModel
     */
    protected $productResource;

    /**
     * @var ProductFactory
     */
    protected $productFactory;
    /**
     * @var StoreManagerInterface
     */
    private $storeManager;
    /**
     * @var ProductResourceModel\CollectionFactory
     */
    private $collectionFactory;
    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;
    /**
     * @var SearchResultFactory
     */
    private $searchResultFactory;


    /**
     * ProductRepository constructor.
     *
     * @param ProductResourceModel $productResource
     * @param ProductFactory $productFactory
     * @param StoreManagerInterface $storeManager
     * @param ProductResourceModel\CollectionFactory $collectionFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchResultFactory $searchResultFactory
     */
    public function __construct(
        ProductResourceModel $productResource,
        ProductFactory $productFactory,
        StoreManagerInterface $storeManager,
        ProductResourceModel\CollectionFactory $collectionFactory,
        CollectionProcessorInterface $collectionProcessor,
        SearchResultFactory $searchResultFactory
    ) {
        $this->productResource = $productResource;
        $this->productFactory = $productFactory;
        $this->storeManager = $storeManager;
        $this->collectionFactory = $collectionFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchResultFactory = $searchResultFactory;
    }

    /**
     * {@inheritdoc}
     */
    public function save(ProductInterface $product)
    {
        try {
            $this->productResource->save($product);
        } catch (\Exception $e) {
            throw new CouldNotSaveException(
                __('Could not save product: %1', $e->getMessage())
            );
        }
        return $product;
    }

    /**
     * {@inheritdoc}
     */
    public function getById($entityId)
    {
        /** @var ProductInterface|AbstractModel $product */
        $product = $this->productFactory->create();

        $this->productResource->load($product, $entityId);

        if (!$product->getId()) {
            throw new NoSuchEntityException(
                __('Product with ID "%1" wasn\'t found.', $entityId)
            );
        }

        return $product;
    }

    /**
     * @inheritdoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria)
    {
        /** @var ProductResourceModel\Collection $collection */
        $collection = $this->collectionFactory->create();
        $this->collectionProcessor->process($searchCriteria, $collection);

        /** @var ProductSearchResultInterface $searchResult */
        $searchResult = $this->searchResultFactory->create();
        $searchResult->setSearchCriteria($searchCriteria);
        $searchResult->setItems($collection->getItems());
        $searchResult->setTotalCount($collection->getSize());

        return $searchResult;
    }


    /**
     * {@inheritdoc}
     */
    public function delete(ProductInterface $product)
    {
        try {
            $this->productResource->delete($product);
        } catch (\Exception $e) {
            throw new CouldNotDeleteException(__('Could not delete product : %1', $e->getMessage()));
        }
    }
}
