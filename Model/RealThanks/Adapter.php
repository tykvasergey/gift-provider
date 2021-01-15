<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks;

use Magento\Framework\App\Config\ScopeConfigInterface;
use WiserBrand\RealThanks\Model\RtGiftRepository;

class Adapter
{
    const ORDER_RESPONSE_STATUS_KEY = 'status';

    /**
     * @var ScopeConfigInterface
     */
    protected $scopeConfig;

    /**
     * @var RtGiftRepository
     */
    protected $giftRepo;

    public function getGifts() : array
    {
        // needs to return all gift attr array(id, cost, name, url)
        return [];
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
        return (float) 0;
    }

    public function sendGift(int $giftId) : bool
    {
        $giftModel = $this->giftRepo->getById($giftId);
        // prepare data for RT from $giftModel

        return true;
    }
}
