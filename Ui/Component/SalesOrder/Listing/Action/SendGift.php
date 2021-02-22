<?php
namespace WiserBrand\RealThanks\Ui\Component\SalesOrder\Listing\Action;

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
            $item[$this->getData('name')]['rt'] = [
                'callback' => [
                    [
                        'provider' => 'sales_order_grid.sales_order_grid.modalContainer'
                            . '.send_gift_modal.send_gift_form_loader',
                        'target' => 'destroyInserted',
                    ],
                    [
                        'provider' => 'sales_order_grid.sales_order_grid.modalContainer'
                            . '.send_gift_modal.send_gift_form_loader',
                        'target' => 'updateData',
                        'params' => [
                            'email' => $item['customer_email']
                        ]
                    ],
                    [
                        'provider' => 'sales_order_grid.sales_order_grid.modalContainer.send_gift_modal',
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
