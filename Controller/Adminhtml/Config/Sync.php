<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Controller\Adminhtml\Config;

use Magento\Framework\App\ResponseInterface;
use WiserBrand\RealThanks\Model\RealThanks\Sync\SynchronizerInterface;
use WiserBrand\RealThanks\Model\RealThanks\Sync\SynchronizerListInterface;

class Sync extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{
    /**
     * @var SynchronizerListInterface
     */
    private $syncList;

    /**
     * @inheritDoc
     * will use on config panel for manual sync run
     */
    public function execute()
    {
        /** @var SynchronizerInterface $synchronizer */
        foreach ($this->syncList as $synchronizer) {
            $synchronizer->synchronize();
        }

        // needs to show success/fail message
    }
}
