<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Controller\Adminhtml\RtOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpGetActionInterface;
use Magento\Framework\Controller\Result\Json;
use Magento\Framework\Controller\ResultFactory;
use Magento\Framework\Controller\ResultInterface;
use Magento\Framework\Exception\CouldNotSaveException;
use Magento\Framework\Exception\LocalizedException;
use RealThanks\GiftProvider\Api\Data\RtOrderInterface;
use RealThanks\GiftProvider\Logger\Logger;
use RealThanks\GiftProvider\Model\Connection\Adapter;
use RealThanks\GiftProvider\Model\RtOrderRepository;

class Send extends Action implements HttpGetActionInterface
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'RealThanks_GiftProvider::rt_admin';

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
     * @var Logger
     */
    private $logger;

    /**
     * @param Adapter $adapter
     * @param RtOrderRepository $giftOrderRepo
     * @param Logger $logger
     * @param Context $context
     */
    public function __construct(
        Adapter $adapter,
        RtOrderRepository $giftOrderRepo,
        Logger $logger,
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
            $this->giftOrderRepo->save($orderModel);
            $this->_eventManager->dispatch(
                'realthanks_provider_after_gift_send',
                ['order_model' => $orderModel]
            );
            $resultRedirect->setUrl($this->_redirect->getRefererUrl());
            $this->messageManager->addSuccessMessage(__("Your gift was successfully sent. Your order id is - %1", $orderId));
        } catch (\Exception $e) {
            $this->errorNotification($e->getMessage(), $resultRedirect, $orderModel);
            try {
                $this->giftOrderRepo->save($orderModel);
            } catch (CouldNotSaveException $e) {
                $this->logger->error($e->getMessage());
            }
        }

        if ($this->getRequest()->isAjax()) {
            return $this->getAjaxResponse($orderModel);
        }

        return $resultRedirect;
    }

    /**
     * @param string $errorMsg
     * @param ResultInterface $resultRedirect
     * @param RtOrderInterface|null $orderModel
     */
    private function errorNotification(string $errorMsg, ResultInterface $resultRedirect, RtOrderInterface $orderModel = null)
    {
        $this->messageManager->addErrorMessage(__('RealThanks API error. Please check the log for the details'));
        $this->logger->error($errorMsg);
        if ($orderModel) {
            $orderModel->setStatus('Error');
        }
        $resultRedirect->setUrl($this->getUrl(self::RT_ORDER_GRID_URL));
    }

    /**
     * @param RtOrderInterface $orderModel
     * @return Json
     */
    private function getAjaxResponse(RtOrderInterface $orderModel): Json
    {
        $type = 'success';
        if ($orderModel->getStatus() === 'Error') {
            $type = 'error';
        }
        $messages = $this->messageManager->getMessages(true)->getItemsByType($type);
        $resultMsg = '';
        foreach ($messages as $message) {
            $resultMsg .= $message->getText();
        }
        /** @var Json $resultJson */
        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData(['status' => $orderModel->getStatus(), 'message' => $resultMsg]);

        return $resultJson;
    }

    /**
     * @param RtOrderInterface $orderModel
     * @throws LocalizedException
     */
    private function validateOrder(RtOrderInterface $orderModel): void
    {
        if ($orderModel->getRtId()) {
            throw new LocalizedException(__("Order (id = %1) was already send. It can`t be send again.", $orderModel->getId()));
        }
    }
}
