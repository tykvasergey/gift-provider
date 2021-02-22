<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Ui\Component\Customer\Form\Tab;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Ui\Component\Form\Fieldset;
use WiserBrand\RealThanks\Helper\Config;

class AssociatedRtGifts extends Fieldset
{
    /**
     * @var Config
     */
    private $config;

    public function __construct(
        ContextInterface $context,
        array $components,
        array $data,
        Config $config
    ) {
        $this->config = $config;
        parent::__construct($context, $components, $data);
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
