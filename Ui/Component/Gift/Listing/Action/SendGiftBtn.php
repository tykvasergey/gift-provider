<?php
namespace WiserBrand\RealThanks\Ui\Component\Gift\Listing\Action;

use Magento\Framework\Data\Form\FormKey;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class SendGiftBtn extends Column
{
    /**
     * @var UrlInterface
     */
    private $urlBuilder;
    /**
     * @var FormKey
     */
    private $formKey;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        UrlInterface $urlBuilder,
        FormKey $formKey,
        array $components = [],
        array $data = []
    ) {
        $this->urlBuilder = $urlBuilder;
        $this->formKey = $formKey;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare Data Source
     *
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        $dataSource = parent::prepareDataSource($dataSource);

        if (empty($dataSource['data']['items'])) {
            return $dataSource;
        }

        $fieldName = $this->getData('name');
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
                'label' => __('Send gift'),
            ];
        }

        return $dataSource;
    }
}
