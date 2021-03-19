<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Cron;

use RealThanks\GiftProvider\Helper\Config;
use RealThanks\GiftProvider\Model\Connection\Sync\SynchronizerInterface;
use RealThanks\GiftProvider\Model\Connection\Sync\SynchronizerListInterface;

class DataSynchronization
{
    /**
     * @var SynchronizerListInterface
     */
    private $syncList;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param SynchronizerListInterface $syncList
     * @param Config $config
     */
    public function __construct(SynchronizerListInterface $syncList, Config $config)
    {
        $this->syncList = $syncList;
        $this->config = $config;
    }

    public function execute()
    {
        if (!$this->config->isApiEnabled()) {
            return;
        }
        /** @var SynchronizerInterface $synchronizer */
        foreach ($this->syncList as $synchronizer) {
            $synchronizer->synchronize();
        }
    }
}
