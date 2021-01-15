<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks\Sync;

use WiserBrand\RealThanks\Model\RealThanks\Adapter;
use WiserBrand\RealThanks\Helper\Config;
use WiserBrand\RealThanks\Model\RtOrderRepository;

class BalanceSynchronizer implements SynchronizerInterface
{
    /**
     * @var Config
     */
    private $configHelper;

    /**
     * @var Adapter
     */
    private $adapter;

    public function synchronize(): bool
    {
        $balance = $this->adapter->getBalance();
        $this->configHelper->setRtBalance($balance);

        return true;
    }
}
