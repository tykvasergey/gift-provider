<?php
namespace WiserBrand\RealThanks\Ui\Component\Customer\Listing\Action;

use WiserBrand\RealThanks\Ui\Component\SendGiftActionColumn;

class SendGift extends SendGiftActionColumn
{
    /**
     * @inheritDoc
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        foreach ($dataSource['data']['items'] as & $item) {
            $item[$this->getData('name')]['details'] = [
                'callback' => [
                    [
                        'provider' => 'customer_listing.customer_listing.modalContainer'
                            . '.send_gift_modal.send_gift_form_loader',
                        'target' => 'destroyInserted',
                    ],
                    [
                        'provider' => 'customer_listing.customer_listing.modalContainer'
                            . '.send_gift_modal.send_gift_form_loader',
                        'target' => 'updateData',
                        'params' => [
                            'email' => $item['email']
                        ]
                    ],
                    [
                        'provider' => 'customer_listing.customer_listing.modalContainer.send_gift_modal',
                        'target' => 'openModal'
                    ]
                ],
                'href' => '#',
                'label' => __('Send gift')
            ];
        }

        return $dataSource;
    }
}
