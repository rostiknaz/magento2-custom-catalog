<?php

namespace Rnazy\CustomCatalog\Model;

use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use Magento\Framework\Exception\ValidatorException;
use Magento\Framework\Model\AbstractModel;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Api\ProductRepositoryInterface;
use Rnazy\CustomCatalog\Model\ResourceModel\Product as ProductResourceModel;

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


    public function __construct(
        ProductResourceModel $productResource,
        ProductFactory $productFactory
    ) {
        $this->productResource = $productResource;
        $this->productFactory = $productFactory;
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
//    public function getList(SearchCriteriaInterface $searchCriteria)
//    {
//        $collection = $this->collectionFactory->create();
//        $this->collectionProcessor->process($searchCriteria, $collection);
//
//        $searchResult = $this->searchResultFactory->create();
//        $searchResult->setSearchCriteria($searchCriteria);
//        $searchResult->setItems($collection->getItems());
//        return $searchResult;
//    }
//
//
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
