<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Controller\Adminhtml\RtOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Exception\LocalizedException;
use Psr\Log\LoggerInterface;
use WiserBrand\RealThanks\Exception\RtApiException;
use WiserBrand\RealThanks\Model\RealThanks\Adapter;
use WiserBrand\RealThanks\Model\RtOrder;
use WiserBrand\RealThanks\Model\RtOrderRepository;

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
     * @var RtOrderRepository
     */
    private $giftOrderRepo;

    /**
     * @var LoggerInterface
     */
    private $logger;

    public function __construct(
        Adapter $adapter,
        RtOrderRepository $giftOrderRepo,
        LoggerInterface $logger,
        Context $context
    ) {
        $this->adapter = $adapter;
        $this->giftOrderRepo = $giftOrderRepo;
        $this->logger = $logger;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $resultRedirect = $this->resultFactory->create(ResultFactory::TYPE_REDIRECT);
        $orderId = (int) $this->getRequest()->getParam('order_id');
        try {
            $orderModel = $this->giftOrderRepo->getById($orderId);
            $this->validateOrder($orderModel);
            $originalRtOrderId = $this->adapter->sendGift($orderId);
            $orderModel->setRtId($originalRtOrderId);
            $orderModel->setStatus('Sent');
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            $this->messageManager->addSuccessMessage(__("Your gift was successfully sent. Your order id is - %1", $orderId));
            $this->_eventManager->dispatch(
                'wiser_brand_rt_after_gift_send',
                ['order_model' => $orderModel]
            );
        } catch (RtApiException $e) {
            $this->messageManager->addErrorMessage(__("The gift can`t be send now! Your order id is - %1. RealThanks API error is - %2", $orderId, $e->getMessage()));
            $orderModel->setStatus('Error');
            $resultRedirect->setUrl($this->getUrl(self::RT_ORDER_GRID_URL));
        } catch (LocalizedException $e) {
            $this->messageManager->addErrorMessage($e->getMessage());
            $orderModel->setStatus('Error');
            $resultRedirect->setUrl($this->getUrl(self::RT_ORDER_GRID_URL));
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("The gift can`t be send now! Your order id is - %1, please check the order status", $orderId));
            $this->messageManager->addErrorMessage(__("RealThanks API error. Please check the log for the details"));
            $this->logger->error($e->getMessage());
            $orderModel->setStatus('Error');
            $resultRedirect->setUrl($this->getUrl(self::RT_ORDER_GRID_URL));
        }

        $this->giftOrderRepo->save($orderModel);

        if ($this->getRequest()->isAjax()) {
            /** @var Json $resultJson */
            $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
            $resultJson->setData(['status' => $orderModel->getStatus()]);
            return $resultJson;
        }

        return $resultRedirect;
    }

    private function validateOrder(RtOrder $orderModel): void
    {
        if ($orderModel->getRtId()) {
            throw new LocalizedException(__("Order (id = %1) was already send. It can`t be send again.", $orderModel->getId()));
        }
    }
}
