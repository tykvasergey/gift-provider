<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Connection\Sync;

use RealThanks\GiftProvider\Model\Connection\Adapter;
use RealThanks\GiftProvider\Model\RtOrder;
use RealThanks\GiftProvider\Model\RtOrderRepository;
use RealThanks\GiftProvider\Model\SyncLog;
use RealThanks\GiftProvider\Model\SyncLogManagement;

class OrderSynchronizer implements SynchronizerInterface
{
    /**
     * @var RtOrderRepository
     */
    private $rtOrderRepository;

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var SyncLogManagement
     */
    private $syncLogManagement;

    /**
     * @var array
     */
    private $rtOrdersToUpdate = [];

    /**
     * @param RtOrderRepository $rtOrderRepository
     * @param Adapter $adapter
     */
    public function __construct(
        RtOrderRepository $rtOrderRepository,
        Adapter $adapter,
        SyncLogManagement $syncLogManagement
    ) {
        $this->rtOrderRepository = $rtOrderRepository;
        $this->syncLogManagement = $syncLogManagement;
        $this->adapter = $adapter;
    }

    private function init(): void
    {
        $this->rtOrdersToUpdate = $this->rtOrderRepository->getActiveOrders();
    }

    public function synchronize(): bool
    {
        $result = true;
        $logData = [
            'success' => false,
            'type' => SyncLog::ORDER_LOG_TYPE
        ];

        try {
            $this->init();
            /** @var RtOrder $rtOrder */
            foreach ($this->rtOrdersToUpdate as $rtOrder) {
                $orderStatus = $this->adapter->getOrderStatus($rtOrder->getRtId());
                $rtOrder->setStatus($orderStatus);
                if ($orderStatus == Adapter::ORDER_COMPLETE_STATUS) {
                    $rtOrder->setIsComplete(true);
                }
                $this->rtOrderRepository->save($rtOrder);
            }
            $logData['success'] = true;
            $this->syncLogManagement->addSyncLog($logData);
        } catch (\Exception $exception) {
            $logData['message'] = $exception->getMessage();
            $this->syncLogManagement->addSyncLog($logData);
            $result = false;
        }

        return $result;
    }
}
