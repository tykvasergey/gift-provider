<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use RealThanks\GiftProvider\Model\Connection\Sync\BalanceSynchronizer;
use RealThanks\GiftProvider\Helper\Config;

class AfterSendGiftObserver implements ObserverInterface
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
