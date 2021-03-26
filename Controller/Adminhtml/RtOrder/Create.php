<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Controller\Adminhtml\RtOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use RealThanks\GiftProvider\Logger\Logger;
use RealThanks\GiftProvider\Model\RtOrderFactory;
use RealThanks\GiftProvider\Model\RtOrderRepository;
use RealThanks\GiftProvider\Model\Validation\GiftSendFormValidatorFactory;

class Create extends Action implements HttpPostActionInterface
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'RealThanks_GiftProvider::rt_admin';

    /**
     * @var GiftSendFormValidatorFactory
     */
    private $giftSendFormValidatorFactory;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @var RtOrderFactory
     */
    private $rtOrderFactory;

    /**
     * @var RtOrderRepository
     */
    private $rtOrderRepo;

    /**
     * @var ForwardFactory
     */
    private $forwardFactory;

    /**
     * @var RequestInterface
     */
    private $request;

    public function __construct(
        GiftSendFormValidatorFactory $giftSendFormValidatorFactory,
        Logger $logger,
        RtOrderFactory $rtOrderFactory,
        RtOrderRepository $rtOrderRepo,
        ForwardFactory $forwardFactory,
        RequestInterface $request,
        Context $context
    ) {
        $this->giftSendFormValidatorFactory = $giftSendFormValidatorFactory;
        $this->logger = $logger;
        $this->rtOrderFactory = $rtOrderFactory;
        $this->rtOrderRepo = $rtOrderRepo;
        $this->forwardFactory = $forwardFactory;
        $this->request = $request;
        parent::__construct($context);
    }

    /**
     * @inheritDoc
     */
    public function execute()
    {
        $orderModel = null;
        try {
            $data = $this->getRequest()->getPostValue();
            $validator = $this->giftSendFormValidatorFactory->create(['data' => $data]);
            if ($validator->validate()) {
                $validator->validateGiftIdField();
                $orderModel = $this->rtOrderFactory->create();
                $orderModel->setData($data);
                $orderModel->setStatus('new');
                $this->rtOrderRepo->save($orderModel);
            } else {
                $this->messageManager->addErrorMessage($validator->getErrors());
            }
        } catch (\Exception $e) {
            $this->messageManager->addErrorMessage(__("Internal error. Please check the log for details"));
            $this->logger->error($e->getMessage());
        }

        /** @var Forward $forward */
        $forward = $this->forwardFactory->create();

        if ($orderModel->getId()) {
            $this->request->setParams(['order_id' => $orderModel->getId()]);
            $forward->forward('send');

            return $forward;
        }

        $forward->setController('gift');
        return $forward->forward('index');
    }
}
