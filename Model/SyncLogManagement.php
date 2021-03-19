<?php
namespace RealThanks\GiftProvider\Model;

use Magento\Framework\DataObject;
use RealThanks\GiftProvider\Model\ResourceModel\SyncLog as SyncLogResourceModel;
use RealThanks\GiftProvider\Model\ResourceModel\SyncLog\Collection;
use RealThanks\GiftProvider\Model\ResourceModel\SyncLog\CollectionFactory;

class SyncLogManagement
{
    /**
     * @var CollectionFactory
     */
    private $collectionFactory;

    /**
     * @var SyncLogFactory
     */
    private $syncLogFactory;

    /**
     * @var SyncLogResourceModel
     */
    private $syncLogResource;

    /**
     * SyncLogManagement constructor.
     * @param CollectionFactory $collectionFactory
     * @param SyncLogFactory $syncLogFactory
     * @param SyncLogResourceModel $syncLogResource
     */
    public function __construct(CollectionFactory $collectionFactory, \RealThanks\GiftProvider\Model\SyncLogFactory $syncLogFactory, SyncLogResourceModel $syncLogResource)
    {
        $this->collectionFactory = $collectionFactory;
        $this->syncLogFactory = $syncLogFactory;
        $this->syncLogResource = $syncLogResource;
    }

    /**
     * @return DataObject | bool
     */
    public function getLatestSync()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addOrder('creation_time', Collection::SORT_ORDER_DESC);
        $collection->setPageSize(1);

        return count($collection) ? $collection->getFirstItem() : false;
    }

    /**
     * @return DataObject | bool
     */
    public function getLatestErrorSync()
    {
        $syncTypes = [SyncLog::GIFT_LOG_TYPE, SyncLog::BALANCE_LOG_TYPE, SyncLog::ORDER_LOG_TYPE];
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        foreach ($syncTypes as $syncType) {
            $collection->clear();
            $collection->addFieldToFilter('type', $syncType);
            $collection->addOrder('creation_time', Collection::SORT_ORDER_DESC);
            $collection->setPageSize(1);

            if (count($collection)) {
                $syncLog = $collection->getFirstItem();
                if (!$syncLog->IsSuccessful()) {
                    return $syncLog;
                }
            }
        }

        return false;
    }

    public function getBalance()
    {
        /** @var Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addFieldToFilter('success', true);
        $collection->addFieldToFilter('type', SyncLog::BALANCE_LOG_TYPE);
        $collection->addOrder('creation_time', Collection::SORT_ORDER_DESC);
        $collection->setPageSize(1);

        return count($collection) ? $collection->getFirstItem()->getBalance() : 0;
    }

    public function addSyncLog(array $data)
    {
        /** @var SyncLog $syncLogModel */
        $syncLogModel = $this->syncLogFactory->create(['data' => $data]);
        // @todo add try
        $syncLogModel->setDataChanges(true);
        $this->syncLogResource->save($syncLogModel);
    }

    /**
     * Clean old syncLog records
     * @todo  add this function to full updater
     * @param int|null $numberOfRecords
     */
    public function clean(int $numberOfRecords = null)
    {
        /** @var ResourceModel\SyncLog\Collection $collection */
        $collection = $this->collectionFactory->create();
        $collection->addOrder('creation_time', Collection::SORT_ORDER_ASC);
        $collection->setPageSize($numberOfRecords ? $numberOfRecords : 10);
        $itemsToRemove = $collection->getItems();

        foreach ($itemsToRemove as $item) {
            $this->syncLogResource->delete($item);
        }
    }
}
