<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Observer;

use Magento\Framework\Event\Observer;
use WiserBrand\RealThanks\Model\RealThanks\Sync\BalanceSynchronizer;
use WiserBrand\RealThanks\Helper\Config;

class AfterSendGiftObserver implements \Magento\Framework\Event\ObserverInterface
{
    /**
     * @var BalanceSynchronizer
     */
    private $balanceSynchronizer;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param BalanceSynchronizer $balanceSynchronizer
     * @param Config $config
     */
    public function __construct(BalanceSynchronizer $balanceSynchronizer, Config $config)
    {
        $this->balanceSynchronizer = $balanceSynchronizer;
        $this->config = $config;
    }

    /**
     * @inheritDoc
     */
    public function execute(Observer $observer)
    {
        if ($this->config->isApiEnabled()) {
            $this->balanceSynchronizer->synchronize();
        }
    }
}
