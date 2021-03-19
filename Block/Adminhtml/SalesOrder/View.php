<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Block\Adminhtml\SalesOrder;

use Magento\Sales\Block\Adminhtml\Order\View as OrderView;

class View extends OrderView
{
    /**
     * @inheritDoc
     */
    protected function _construct()
    {
        parent::_construct();

        $order = $this->getOrder();

        if (!$order || !$order->getCustomerEmail()) {
            return;
        }

        $onclickJs = 'jQuery(\'#send_gift\').triggerSendGiftModal({email: \''
                . $order->getCustomerEmail() . '\'}).triggerSendGiftModal(\'showModal\');';

        $this->addButton(
            'send_gift',
            [
                'label' => __('Send Gift'),
                'class' => 'invoice',
                'onclick' => $onclickJs,
                'id' => 'send_gift',
                'sort_order' => 1000,
                'data_attribute' => [
                    'mage-init' => '{"triggerSendGiftModal":{}}',
                ]
            ]
        );
    }
}
