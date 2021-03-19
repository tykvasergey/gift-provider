<?php
namespace RealThanks\GiftProvider\Ui\Component\Gift\Listing\Action;

use Magento\Ui\Component\Listing\Columns\Column;

class SendGift extends Column
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
                        'provider' => 'index = send_gift_form_loader',
                        'target' => 'destroyInserted',
                    ],
                    [
                        'provider' => 'index = send_gift_form_loader',
                        'target' => 'updateData',
                        'params' => [
                            'gift_id' => $item['entity_id']
                        ]
                    ],
                    [
                        'provider' => 'index = send_gift_modal',
                        'target' => 'openModal'
                    ]
                ],
                'href' => '#',
                'label' => __('Send gift'),
            ];
        }

        return $dataSource;
    }
}
