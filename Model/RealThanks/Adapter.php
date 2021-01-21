<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks;

use Magento\Framework\HTTP\Client\Curl;
use WiserBrand\RealThanks\Helper\Config;
use WiserBrand\RealThanks\Model\RtGiftRepository;

class Adapter
{
    const ORDER_RESPONSE_STATUS_KEY = 'status';
    //@todo change to live after testing
    const BASE_API_URL = 'https://api.iced.me/v1/client/';
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
     * @param Curl $curl
     * @param Config $configHelper
     * @param RtGiftRepository $giftRepo
     */
    public function __construct(Curl $curl, Config $configHelper, RtGiftRepository $giftRepo)
    {
        $this->curl = $curl;
        $this->configHelper = $configHelper;
        $this->giftRepo = $giftRepo;
    }

    private function init()
    {
        $this->curl->addHeader("Content-Type", "application/json");
        $this->curl->addHeader("Authorization", "Bearer {$this->configHelper->getApiKey()}");
    }

    public function getGifts() : array
    {
        //@todo add own exceptions?
        //@todo add checkup on status
        $result = [];
        $this->init();
        $this->curl->get(self::BASE_API_URL . 'product');
        $response = json_decode($this->curl->getBody(), true);
        if ($response && is_array($response) && key_exists('data', $response)) {
            $result = $response['data'];
        }

        return $result;
    }

    public function getOrderStatus(int $orderId) : array
    {
        return [
        "id" =>  1,
        self::ORDER_RESPONSE_STATUS_KEY => "Created",
        "details_status" => "Created"
        ];
    }

    public function getBalance() : float
    {
        $result = 0;
        $this->init();
        $this->curl->get(self::BASE_API_URL . 'balance');
        $response = json_decode($this->curl->getBody(), true);
        if ($response && is_array($response)
            && key_exists('data', $response)
            && key_exists('balance', $response['data'])) {
            $result = $response['data']['balance'];
        }

        return (float) $result;
    }

    public function sendGift(int $giftId) : bool
    {
        $giftModel = $this->giftRepo->getById($giftId);
        // prepare data for RT from $giftModel

        return true;
    }
}
