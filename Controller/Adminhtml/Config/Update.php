<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Controller\Adminhtml\Config;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\Response\Http;
use Psr\Log\LoggerInterface;
use RealThanks\GiftProvider\Model\Connection\Sync\SynchronizerInterface;
use RealThanks\GiftProvider\Model\Connection\Sync\SynchronizerListInterface;

class Update extends Action implements HttpGetActionInterface
{
    /**
     * @var SynchronizerListInterface
     */
    private $syncList;

    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * @param Context $context
     * @param SynchronizerListInterface $syncList
     * @param LoggerInterface $logger
     */
    public function __construct(
        SynchronizerListInterface $syncList,
        LoggerInterface $logger,
        Context $context
    ) {
        $this->syncList = $syncList;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $result = new \stdClass();
        try {
            /** @var SynchronizerInterface $synchronizer */
            foreach ($this->syncList as $synchronizer) {
                $synchronizer->synchronize();
            }
            $result->success = true;
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
            $this->getResponse()->setStatusHeader(500, null, __('Cannot update data'));
            $result->error = __('Cannot update data');
        }

        /** @var Http $response */
        $response = $this->getResponse();
        return $response->representJson(json_encode($result));
    }
}
