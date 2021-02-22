<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Cron;

use WiserBrand\RealThanks\Helper\Config;
use WiserBrand\RealThanks\Model\RealThanks\Sync\SynchronizerInterface;
use WiserBrand\RealThanks\Model\RealThanks\Sync\SynchronizerListInterface;

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
