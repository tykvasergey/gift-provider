<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Connection;

use Magento\Framework\HTTP\Client\Curl;
use RealThanks\GiftProvider\Exception\RtApiException;
use RealThanks\GiftProvider\Helper\Config;
use RealThanks\GiftProvider\Logger\Logger;
use RealThanks\GiftProvider\Model\RtGiftRepository;
use RealThanks\GiftProvider\Model\RtOrderRepository;

class Adapter
{
    const ORDER_COMPLETE_STATUS = 'Completed';

    //@todo change to live URL after testing
    const BASE_API_URL = 'https://api.iced.me/v1/client/';

    const ORDER_ERROR_STATUSES = [
        422 => 'please check your RealThanks limit',
        442 => 'your balance is not enough for sending this order',
        444 => 'please synchronize gifts, your data (price) is outdated',
        445 => 'you tried to send gift that is out-of-stock',
        446 => 'RealThanks payment processing is temporarily unavailable. Please try again later'
    ];

    /**
     * @var Curl
     */
    private $curl;

    /**
     * @var Config
     */
    private $configHelper;

    /**
     * @var RtGiftRepository
     */
    private $giftRepo;

    /**
     * @var RtOrderRepository
     */
    private $giftOrderRepo;

    /**
     * @var Logger
     */
    private $logger;

    /**
     * @param Curl $curl
     * @param Config $configHelper
     * @param RtGiftRepository $giftRepo
     * @param RtOrderRepository $giftOrderRepo
     * @param Logger $logger
     */
    public function __construct(
        Curl $curl,
        Config $configHelper,
        RtGiftRepository $giftRepo,
        RtOrderRepository $giftOrderRepo,
        Logger $logger
    ) {
        $this->curl = $curl;
        $this->configHelper = $configHelper;
        $this->giftRepo = $giftRepo;
        $this->giftOrderRepo = $giftOrderRepo;
        $this->logger = $logger;
    }

    private function init()
    {
        if (!$this->configHelper->isApiEnabled()) {
            throw new RtApiException(
                __('RealThanks module API disabled in configuration.
                Please check the config node - "rt_gift_provider/api/enabled"')
            );
        }
        $this->curl->addHeader("Content-Type", "application/json");
        $this->curl->addHeader("Authorization", "Bearer {$this->configHelper->getApiKey()}");
    }

    public function getGifts() : array
    {
        $this->init();
        $this->curl->get(self::BASE_API_URL . 'product');
        if ($this->curl->getStatus() === 200) {
            $response = json_decode($this->curl->getBody(), true);
            if ($response && is_array($response) && key_exists('data', $response)) {
                $result = $response['data'];
            } else {
                $strResponse = implode(' ,', $response);
                throw new RtApiException(__('Incorrect response - %1', $strResponse));
            }
        } else {
            throw new RtApiException(
                __('Unknown API error. The response status - %1. Please check your API credentials', $this->curl->getStatus())
            );
        }

        return $result;
    }

    public function getOrderStatus(int $orderId) : string
    {
        $this->init();
        $this->curl->get(self::BASE_API_URL . "order/{$orderId}");
        if ($this->curl->getStatus() === 200) {
            $response = json_decode($this->curl->getBody(), true);
            if ($response && is_array($response)
                && key_exists('data', $response)
                && key_exists('status', $response['data'])) {
                $result = $response['data']['status'];
            } else {
                $strResponse = implode(' ,', $response);
                throw new RtApiException(__('Incorrect response - %1', $strResponse));
            }
        } else {
            throw new RtApiException(__('Unknown API error. The response status - %1', $this->curl->getStatus()));
        }

        return $result;
    }

    public function getBalance() : float
    {
        $this->init();
        $this->curl->get(self::BASE_API_URL . 'balance');
        if ($this->curl->getStatus() === 200) {
            $response = json_decode($this->curl->getBody(), true);
            if ($response && is_array($response)
                && key_exists('data', $response)
                && key_exists('balance', $response['data'])) {
                $result = $response['data']['balance'];
            } else {
                $strResponse = implode(' ,', $response);
                throw new RtApiException(__('Incorrect response - %1', $strResponse));
            }
        } else {
            throw new RtApiException(__('Unknown API error. The response status - %1', $this->curl->getStatus()));
        }

        return (float) $result;
    }

    public function sendGift(int $giftOrderId) : int
    {
        $this->init();
        $orderModel = $this->giftOrderRepo->getById($giftOrderId);
        $giftModel = $this->giftRepo->getById((int)$orderModel->getGiftId());
        $data['email'] = $orderModel->getEmail();
        $data['subject'] = $orderModel->getSubject();
        $data['message'] = $orderModel->getMessage();
        $data['product_id'] = $giftModel->getRtId();
        $data['price'] = $giftModel->getCost();
        $data['payment_type'] = 'balance';
        $data['source'] = 'magento';

        $this->curl->post(self::BASE_API_URL . 'order', json_encode($data));
        if ($this->curl->getStatus() === 200) {
            $response = json_decode($this->curl->getBody(), true);
            if ($response && is_array($response)
                && key_exists('data', $response)
                && key_exists('order_id', $response['data'])) {
                $originalRtOrderId = $response['data']['order_id'];
            } else {
                $strResponse = implode(' ,', $response);
                $this->logger->error("RealThanks sendGift method. Incorrect response - {$strResponse}");
                throw new RtApiException(
                    __('RealThanks return incorrect response. Please check logs for the details.')
                );
            }
        } else {
            $this->handleSendGiftErrorResponse();
        }

        return $originalRtOrderId;
    }

    private function handleSendGiftErrorResponse() : void
    {
        if (key_exists($this->curl->getStatus(), self::ORDER_ERROR_STATUSES)) {
            $message = self::ORDER_ERROR_STATUSES[$this->curl->getStatus()];
            throw new RtApiException(__($message));
        }

        $status = $this->curl->getStatus();
        $this->logger->error("RealThanks sendGift method. Incorrect response status - {$status}");

        throw new RtApiException(__('Unknown API error! Please check logs for the details.'));
    }
}
