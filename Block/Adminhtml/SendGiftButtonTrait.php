<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Block\Adminhtml;

trait SendGiftButtonTrait
{
    public function getBtnData($email)
    {
        //@todo removed if not used
        if ($email) {

            $onclickJs = 'jQuery(\'#send_gift\').triggerSendGiftModal({email: \''
                . $email . '\'}).triggerSendGiftModal(\'showModal\');';

            return
                [
                    'label' => __('Send Gift'),
                    'class' => 'invoice',
                    'onclick' => $onclickJs,
                    'id' => 'send_gift',
                    'sort_order' => 1000,
                    'data_attribute' => [
                        'mage-init' => '{"triggerSendGiftModal":{}}',
                    ]
                ];
        }
    }
}
