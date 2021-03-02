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

    public function getMeta()
    {
        $meta = parent::getMeta();
        // disabled gift select for cases where this field pre-defined
        if ($this->request->getParam('gift_id')) {
            $meta['general'] = [
                'children' => [
                    'gift_id' => [
                        'arguments' => [
                            'data' => [
                                'config' => [
                                    'visible' => false
                                ],
                            ],
                        ],
                    ],
                ],
            ];
        }

        return $meta;
    }
}
