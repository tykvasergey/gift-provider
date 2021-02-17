<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Ui\DataProvider\SendGift;

use Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider as ElementDataProvider;

class DataProvider extends ElementDataProvider
{
    public function getData(): array
    {
        $data = [];
        if ($email = $this->request->getParam('email')) {
            $data['email'] = $email;
        }
        if ($id = $this->request->getParam('gift_id')) {
            $data['gift_id'] = $id;
        }

        return [$data];
    }
}
