<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks\Sync;

use WiserBrand\RealThanks\Model\RealThanks\Adapter;
use WiserBrand\RealThanks\Model\RtGiftRepository;
use WiserBrand\RealThanks\Model\RtOrder;
use WiserBrand\RealThanks\Model\RtOrderRepository;

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
     * @var array
     */
    private $rtOrdersToUpdate = [];

    private function init(): void
    {
        $this->rtOrdersToUpdate = $this->rtOrderRepository->getActiveOrders();
    }

    public function synchronize(): bool
    {
        $this->init();

        /** @var RtOrder $rtOrder */
        foreach ($this->rtOrdersToUpdate as $rtOrder) {
            $orderStatusArr = $this->adapter->getOrderStatus($rtOrder->getRtId());
            $rtOrder->setStatus($orderStatusArr[Adapter::ORDER_RESPONSE_STATUS_KEY]);

            $this->rtOrderRepository->save($rtOrder);
        }

        return true;
    }
}
