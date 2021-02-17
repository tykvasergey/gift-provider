<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Ui\Component\Order\Listing;

use Magento\Framework\App\RequestInterface;
use Magento\Ui\DataProvider\AbstractDataProvider;
use WiserBrand\RealThanks\Model\ResourceModel\RtOrder\Collection as GridCollection;
use WiserBrand\RealThanks\Model\ResourceModel\RtOrder\CollectionFactory;

class DataProvider extends AbstractDataProvider
{
    /**
     * @var RequestInterface $request,
     */
    private $request;

    /**
     * @param $name
     * @param $primaryFieldName
     * @param $requestFieldName
     * @param CollectionFactory $collectionFactory
     * @param RequestInterface $request
     * @param array $meta
     * @param array $data
     */
    public function __construct(
        $name,
        $primaryFieldName,
        $requestFieldName,
        CollectionFactory $collectionFactory,
        RequestInterface $request,
        array $meta = [],
        array $data = []
    ) {
        parent::__construct($name, $primaryFieldName, $requestFieldName, $meta, $data);
        $this->collection = $collectionFactory->create();
        $this->request = $request;
    }

    public function getData(): array
    {
        /** @var GridCollection $collection */
        $collection = $this->getCollection();
        if ($this->request->getParam('email')) {
            $collection->addFieldToFilter('email', $this->request->getParam('email'));
        }

        return $collection->toArray();
    }
}
