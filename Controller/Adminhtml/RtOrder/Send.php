<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Controller\Adminhtml\RtOrder;

use Magento\Framework\App\ResponseInterface;

class Send extends \Magento\Backend\App\Action implements \Magento\Framework\App\Action\HttpGetActionInterface
{

    /**
     * @inheritDoc
     * will also use by resend button from rt_order grid
     */
    public function execute()
    {
        // 1. Get order_id from request
        // 2. Call Adapter::sendGift(id) method
        // 3. Returns success msg or redirect to rt order grid with error msg
    }
}
