<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model;

use Magento\Framework\Api\FilterBuilder;
use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\Search\SearchResultFactory;
use Magento\Framework\Api\SearchCriteria\CollectionProcessorInterface;
use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Api\SearchCriteriaInterfaceFactory;
use Magento\Framework\Api\SortOrderBuilder;
use Magento\Framework\Exception\CouldNotDeleteException;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\NoSuchEntityException;
use WiserBrand\RealThanks\Model\ResourceModel\RtGift as GiftResource;
use WiserBrand\RealThanks\Api\Data\RtGiftInterface;
use WiserBrand\RealThanks\Model\ResourceModel\RtGift\Collection;
use WiserBrand\RealThanks\Model\ResourceModel\RtGift\CollectionFactory;
use WiserBrand\RealThanks\Model\RtGift;
use WiserBrand\RealThanks\Model\RtGiftFactory;

class RtGiftRepository implements \WiserBrand\RealThanks\Api\RtGiftRepositoryInterface
{
    /**
     * @var GiftResource
     */
    private $resource;

    /**
     * @var RtGiftFactory
     */
    private $giftFactory;

    /**
     * @var CollectionFactory
     */
    private $resultCollectionFactory;

    /**
     * @var SearchCriteriaInterfaceFactory
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
     * RtGiftRepository constructor.
     * @param GiftResource $resource
     * @param RtGiftFactory $giftFactory
     * @param CollectionFactory $resultCollectionFactory
     * @param SearchCriteriaInterfaceFactory $searchCriteriaInterfaceFactory
     * @param CollectionProcessorInterface $collectionProcessor
     * @param SearchCriteriaBuilder $searchCriteriaBuilder
     * @param FilterBuilder $filterBuilder
     * @param SortOrderBuilder $sortOrderBuilder
     * @param SearchResultFactory $searchResultsFactory
     */
    public function __construct(GiftResource $resource, \WiserBrand\RealThanks\Model\RtGiftFactory $giftFactory, CollectionFactory $resultCollectionFactory, SearchCriteriaInterfaceFactory $searchCriteriaInterfaceFactory, CollectionProcessorInterface $collectionProcessor, SearchCriteriaBuilder $searchCriteriaBuilder, FilterBuilder $filterBuilder, SortOrderBuilder $sortOrderBuilder, SearchResultFactory $searchResultsFactory)
    {
        $this->resource = $resource;
        $this->giftFactory = $giftFactory;
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
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResult
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
    public function getById(int $giftId): RtGiftInterface
    {
        $gift = $this->giftFactory->create();
        $this->resource->load($gift, $giftId);
        if (!$gift->getId()) {
            throw new NoSuchEntityException(__('The RealThanks gift with the "%1" ID doesn\'t exist.', $giftId));
        }

        return $gift;
    }

    public function save(RtGiftInterface $gift)
    {
        try {
            $this->resource->save($gift);
        } catch (\Exception $exception) {
            throw new CouldNotSaveException(
                __('Could not save the RealThanks gift: %1', $exception->getMessage()),
                $exception
            );
        }

        return $gift;
    }

    public function delete(RtGiftInterface $gift)
    {
        try {
            $this->resource->delete($gift);
        } catch (\Exception $exception) {
            throw new CouldNotDeleteException(__($exception->getMessage()));
        }

        return true;
    }

    /**
     * returns model by origin RT_id
     * @param int $giftRtId
     * @return RtGiftInterface
     * @throws NoSuchEntityException
     */
    public function getByRtId(int $giftRtId): RtGiftInterface
    {
        $gift = $this->giftFactory->create();
        $this->resource->load($gift, $giftRtId, 'rt_id');
        if (!$gift->getId()) {
            throw new NoSuchEntityException(__('The RealThanks gift with the "%1" RT_ID doesn\'t exist.', $giftRtId));
        }

        return $gift;
    }

    /**
     */
    public function getRelationArrayIds(): array
    {
        /** @var Collection $collection */
        $collection = $this->resultCollectionFactory->create();
        //$collection->addFieldToFilter('active', true);
        $collection->addFieldToSelect('entity_id', 'id');
        $collection->addFieldToSelect('rt_gift_id', 'rtId');

        return $collection->getData();
    }
}
