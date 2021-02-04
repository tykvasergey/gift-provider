<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Cron;

use WiserBrand\RealThanks\Model\RealThanks\Sync\SynchronizerInterface;
use WiserBrand\RealThanks\Model\RealThanks\Sync\SynchronizerListInterface;

class DataSynchronization
{
    /**
     * @var SynchronizerListInterface
     */
    private $syncList;

    /**
     * @param SynchronizerListInterface $syncList
     */
    public function __construct(SynchronizerListInterface $syncList)
    {
        $this->syncList = $syncList;
    }

    public function execute()
    {
        /** @var SynchronizerInterface $synchronizer */
        foreach ($this->syncList as $synchronizer) {
            $synchronizer->synchronize();
        }
    }
}
