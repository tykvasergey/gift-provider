<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Ui\Component;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use RealThanks\GiftProvider\Helper\Config;

class SendGiftActionColumn extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        array $components,
        array $data,
        Config $config
    ) {
        $this->config = $config;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * @inheritDoc
     */
    public function prepare()
    {
        parent::prepare();
        if (!$this->config->isApiEnabled()) {
            $this->_data['config']['componentDisabled'] = true;
        }
    }
}
