<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks\Sync;

use WiserBrand\RealThanks\Model\RealThanks\Adapter;
use WiserBrand\RealThanks\Helper\Config;
use WiserBrand\RealThanks\Model\RtOrderRepository;
use WiserBrand\RealThanks\Model\SyncLog;
use WiserBrand\RealThanks\Model\SyncLogManagement;

class BalanceSynchronizer implements SynchronizerInterface
{
    /**
     * @var SyncLogManagement
     */
    private $syncLogManagement;

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @param SyncLogManagement $syncLogManagement
     * @param Adapter $adapter
     */
    public function __construct(SyncLogManagement $syncLogManagement, Adapter $adapter)
    {
        $this->syncLogManagement = $syncLogManagement;
        $this->adapter = $adapter;
    }

    public function synchronize(): bool
    {
        $result = true;
        $logData = [
            'success' => false,
            'type' => SyncLog::BALANCE_LOG_TYPE
        ];

        try {
            $balance = $this->adapter->getBalance();
            $logData['success'] = true;
            $logData['balance'] = $balance;
            $this->syncLogManagement->addSyncLog($logData);
        } catch (\Exception $exception) {
            $logData['message'] = $exception->getMessage();
            $this->syncLogManagement->addSyncLog($logData);
            $result = false;
        }

        return $result;
    }
}
