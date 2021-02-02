<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Controller\Adminhtml\RtOrder;

use Magento\Backend\App\Action;
use Magento\Backend\App\Action\Context;
use Magento\Framework\App\Action\HttpPostActionInterface;
use Magento\Framework\App\RequestInterface;
use Magento\Framework\Controller\Result\Forward;
use Magento\Framework\Controller\Result\ForwardFactory;
use Psr\Log\LoggerInterface;
use WiserBrand\RealThanks\Model\RtOrderFactory;
use WiserBrand\RealThanks\Model\RtOrderRepository;
use WiserBrand\RealThanks\Model\Validation\GiftSendFormValidatorFactory;

class Create extends Action implements HttpPostActionInterface
{
    /**
     * @inheritdoc
     */
    const ADMIN_RESOURCE = 'WiserBrand_RealThanks::rt_admin';

    /**
     * @var GiftSendFormValidatorFactory
     */
    private $giftSendFormValidatorFactory;

    /**
     * @var LoggerInterface
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
        LoggerInterface $logger,
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
        // 1. Get form data from request
        // 2. Validate data
        // 3. Create order
        // 4. Forward to send controller with order id param
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
