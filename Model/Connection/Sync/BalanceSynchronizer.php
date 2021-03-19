<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Connection\Sync;

use RealThanks\GiftProvider\Model\Connection\Adapter;
use RealThanks\GiftProvider\Model\SyncLog;
use RealThanks\GiftProvider\Model\SyncLogManagement;

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
