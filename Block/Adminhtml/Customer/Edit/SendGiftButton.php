<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Block\Adminhtml\Customer\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
use RealThanks\GiftProvider\Block\Adminhtml\SendGiftButtonTrait;
use RealThanks\GiftProvider\Helper\Config;

class SendGiftButton extends GenericButton implements ButtonProviderInterface
{
    /**
     * @var CustomerRepositoryInterface
     */
    private $customerRepository;

    /**
     * @var Config
     */
    private $config;

    /**
     * @param Context $context
     * @param Config $config
     * @param Registry $registry
     * @param CustomerRepositoryInterface $customerRepository
     */
    public function __construct(
        Context $context,
        Config $config,
        Registry $registry,
        CustomerRepositoryInterface $customerRepository
    ) {
        parent::__construct($context, $registry);
        $this->config = $config;
        $this->customerRepository = $customerRepository;
    }

    /**
     * @inheritDoc
     */
    public function getButtonData()
    {
        $data = [];
        if (!$this->config->isApiEnabled()) {
            return $data;
        }
        //@todo inspect why email dosent set up to the form
        // and removes unused
        $customerId = $this->getCustomerId();

        if ($customerId && $customerData = $this->customerRepository->getById($customerId)) {
//            $data =
//                  [
//                     'label' => __('Send Gift'),
//                     'on_click' => '',
//                     'data_attribute' => [
//                         'mage-init' => [
//                             'Magento_Ui/js/form/button-adapter' => [
//                                 'actions' => [
//                                     [
//                                         'targetName' => 'modal_gift_form.modal_gift_form.send_gift_modal',
//                                         'actionName' => 'destroyInserted',
//                                     ],
//                                     [
//                                         'targetName' => 'modal_gift_form.modal_gift_form.send_gift_modal.send_gift_form_loader',
//
//                                         'actionName' => 'updateData',
//                                         'params' => [
//                                             'email' => $customerData->getEmail()
//                                         ]
//                                     ],
//                                     [
//                                         'targetName' => 'modal_gift_form.modal_gift_form.send_gift_modal',
//                                         'actionName' => 'openModal'
//                                     ]
//                                 ],
//                             ],
//                         ],
//                     ],
//                     'sort_order' => 200
//                 ];
            $onClick = 'jQuery(\'#send_gift\').triggerSendGiftModal({email: \''
                . $customerData->getEmail() . '\'}).triggerSendGiftModal(\'showModal\');';

            $data =
                [
                    'label' => __('Send Gift'),
                    'on_click' => $onClick,
                    'id' => 'send_gift',
                    'sort_order' => 500,
                    'data_attribute' => [
                        'mage-init' => ["triggerSendGiftModal" => []],
                    ]
                ];
        }

        return $data;
    }
}
