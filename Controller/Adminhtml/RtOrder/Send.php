<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Controller\Adminhtml\RtOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\ResultFactory;
use Psr\Log\LoggerInterface;
use WiserBrand\RealThanks\Exception\RtApiException;
use WiserBrand\RealThanks\Model\RealThanks\Adapter;

class Send extends Action implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'WiserBrand_RealThanks::rt_admin';

    const RT_ORDER_GRID_URL = 'realthanks/rtorder/index';

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Adapter $adapter,
        LoggerInterface $logger,
        Context $context
    ) {
        $this->adapter = $adapter;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     * will also use by resend button from rt_order grid
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);

        $orderId = (int) $this->getRequest()->getParam('order_id');
        try {
            $this->adapter->sendGift($orderId);
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            $this->messageManager->addSuccessMessage(__("Your gift was successfully sent. Your order id is - %1", $orderId));
        } catch (RtApiException $e) {
            $this->messageManager->addErrorMessage(__("The gift can`t be send now! Your order id is - %1. Api error is - %2", $orderId, $e->getMessage()));

            $resultRedirect->setUrl(self::RT_ORDER_GRID_URL);
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("The gift can`t be send now! Your order id is - %1, please check the order status", $orderId));
            $this->messageManager->addErrorMessage(__("RealThanks API error. Please check the log for the details"));
            $this->logger->error($e->getMessage());

            $resultRedirect->setUrl(self::RT_ORDER_GRID_URL);
        }

        return $resultRedirect;
    }
}
