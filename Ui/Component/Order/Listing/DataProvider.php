<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Ui\Component\Order\Listing;

class DataProvider extends \Magento\Framework\View\Element\UiComponent\DataProvider\DataProvider
{
    public function getData(): array
    {
        if ($this->request->getParam('email')) {
            $this->addFilter(
                $this->filterBuilder->setField('email')
                    ->setValue($this->request->getParam('email'))
                    ->create()
            );
            }
        return parent::getData();
    }
}
