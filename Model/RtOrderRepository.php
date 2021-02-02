<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Data\SearchResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use WiserBrand\RealThanks\Api\Data\RtOrderInterface;
use WiserBrand\RealThanks\Model\ResourceModel\RtOrder as GiftOrderResource;
use WiserBrand\RealThanks\Model\ResourceModel\RtOrder\Collection;
use WiserBrand\RealThanks\Model\ResourceModel\RtOrder\CollectionFactory;

class RtOrderRepository implements \WiserBrand\RealThanks\Api\RtOrderRepositoryInterface
{
    const RT_GIFT_TABLE_NAME = 'wiser_brand_rt_gift';
    /**
     * @var GiftOrderResource
     */
    private $resource;

    /**
     * @var RtOrderFactory
     */
    private $giftOrderFactory;
    /**
     * @var CollectionFactory
     */
    private $resultCollectionFactory;

    /**
     * @var SearchCriteriaInterface
     */
    private $searchCriteriaInterfaceFactory;

    /**
     * @var CollectionProcessorInterface
     */
    private $collectionProcessor;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteriaBuilder;

    /**
     * @var FilterBuilder
     */
    private $filterBuilder;

    /**
     * @var SortOrderBuilder
     */
    private $sortOrderBuilder;

    /**
     * @var SearchResultFactory
     */
    private $searchResultsFactory;

    /**
     * RtOrderRepository constructor.
     * @param GiftOrderResource $resource
     * @param RtOrderFactory $giftOrderFactory
     * @param CollectionFactory $resultCollectionFactory
     * @param SearchCriteriaInterfaceFactory $searchCriteriaInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchResultFactory $searchResultsFactory
     */
    public function __construct(GiftOrderResource $resource, RtOrderFactory $giftOrderFactory, CollectionFactory $resultCollectionFactory, SearchCriteriaInterfaceFactory $searchCriteriaInterfaceFactory, CollectionProcessorInterface $collectionProcessor, SearchCriteriaBuilder $searchCriteriaBuilder, FilterBuilder $filterBuilder, SortOrderBuilder $sortOrderBuilder, SearchResultFactory $searchResultsFactory)
    {
        $this->resource = $resource;
        $this->giftOrderFactory = $giftOrderFactory;
        $this->resultCollectionFactory = $resultCollectionFactory;
        $this->searchCriteriaInterfaceFactory = $searchCriteriaInterfaceFactory;
        $this->collectionProcessor = $collectionProcessor;
        $this->searchCriteriaBuilder = $searchCriteriaBuilder;
        $this->filterBuilder = $filterBuilder;
        $this->sortOrderBuilder = $sortOrderBuilder;
        $this->searchResultsFactory = $searchResultsFactory;
    }

    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface
    {
        /** @var Collection $collection */
        $collection = $this->resultCollectionFactory->create();

        $this->collectionProcessor->process($searchCriteria, $collection);

        $searchResults = $this->searchResultsFactory->create();
        $searchResults->setSearchCriteria($searchCriteria);
        $searchResults->setItems($collection->getItems());
        $searchResults->setTotalCount($collection->getSize());

        return $searchResults;
    }

    /**
     * @inheritDoc
     */
    public function getById(int $giftOrderId): RtOrderInterface
    {
        $giftOrder = $this->giftOrderFactory->create();
        $this->resource->load($giftOrder, $giftOrderId);
        if (!$giftOrder->getId()) {
            throw new NoSuchEntityException(__('The RealThanks gift with the "%1" ID doesn\'t exist.', $giftOrderId));
        }

        return $giftOrder;
    }

    public function save(RtOrderInterface $giftOrder)
    {
        try {
            $this->resource->save($giftOrder);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the RealThanks order: %1', $exception->getMessage()),
                $exception
            );
        }

        return $giftOrder;
    }

    public function delete(RtOrderInterface $giftOrder)
    {
        //@todo
        return;
    }

    /**
     * returns non-complete orders that has rt_order_id (it means that they are were sent to RT)
     * will use in the order sync
     * @return RtOrderInterface[]
     */
    public function getActiveOrders():array
    {
        //@todo
        return [];
    }

    public function getGiftAttributeById(string $attribute, $orderId)
    {
        /** @var Collection $collection */
        $collection = $this->resultCollectionFactory->create();
        $giftTable = $collection->getTable(self::RT_GIFT_TABLE_NAME);
        $collection->addFieldToFilter('main_table.entity_id', $orderId);
        $collection->addFieldToSelect('entity_id', 'order_id');
        $collection->join(
            $giftTable,
            "main_table.gift_id={$giftTable}.entity_id",
            $attribute,
        );
        $data = $collection->getData();

        if (key_exists($attribute, $data[0])) {
            return $data[0][$attribute];
        }

        throw new NoSuchEntityException(
            __(
                'The RealThanks gift Attribute - %1 for the order ID = %2 doesn\'t exist.',
                $attribute,
                $orderId
            )
        );
    }
}
