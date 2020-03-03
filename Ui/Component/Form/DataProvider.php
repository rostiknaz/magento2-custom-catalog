<?php

namespace Rnazy\CustomCatalog\Ui\Component\Form;

use Magento\Framework\App\RequestInterface;
use Rnazy\CustomCatalog\Api\Data\ProductInterface;
use Rnazy\CustomCatalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Ui\DataProvider\AbstractDataProvider;

/**
 * DataProvider for product edit form
 */
class DataProvider extends AbstractDataProvider
{
    /**
     * @var array
     */
    protected $loadedData;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        $this->collection = $collectionFactory->create();
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->request = $request;
    }

    /**
     * @return array
     */
    public function getData(): array
    {
        if (!empty($this->loadedData)) {
            return $this->loadedData;
        }
        $storeId = (int) $this->request->getParam('store', 0);
        $items = $this->collection->setStoreId($storeId)->addAttributeToSelect('*')->getItems();
        $this->loadedData = [];

        /** @var ProductInterface $item */
        foreach ($items as $item) {
            $this->loadedData[$item->getId()] = $item->getData();
            $this->loadedData[$item->getId()]['store_id'] = $storeId;
        }

        return $this->loadedData;
    }

}
