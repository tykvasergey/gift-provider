<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Ui\Component\Gift\Form;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use WiserBrand\RealThanks\Helper\Config;

class GiftSelect extends \Magento\Ui\Component\Form\Element\Select
{
    /**
     * @inheritDoc
     */
    public function prepare()
    {
        parent::prepare();

        $this->_data['config']['componentDisabled'] = true;

    }
}
