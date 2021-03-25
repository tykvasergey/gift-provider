<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Block\Adminhtml\Customer\Edit;

use Magento\Backend\Block\Widget\Context;
use Magento\Customer\Api\CustomerRepositoryInterface;
use Magento\Customer\Block\Adminhtml\Edit\GenericButton;
use Magento\Framework\Registry;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
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
        $customerId = $this->getCustomerId();

        if ($customerId && $customerData = $this->customerRepository->getById($customerId)) {
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
