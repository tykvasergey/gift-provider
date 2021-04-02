<?php
namespace RealThanks\GiftProvider\Ui\Component\Gift\Listing\Column;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use RealThanks\GiftProvider\Helper\PriceFormatter;

class Cost extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var PriceFormatter
     */
    private $formatter;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        PriceFormatter $formatter,
        array $components = [],
        array $data = []
    ) {
        $this->formatter = $formatter;
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
        if (isset($dataSource['data']['items'])) {
            $fieldName = $this->getData('name');
            foreach ($dataSource['data']['items'] as & $item) {
                if ($fieldName === 'cost' && $item[$fieldName]) {
                    $item[$fieldName] = $this->formatter->format($item[$fieldName]);
                }
            }
        }

        return $dataSource;
    }

    /**
     * @param array $row
     *
     * @return null|string
     */
    protected function getAlt($row)
    {
        $altField = $this->getData('config/altField') ?: 'name';
        return $row[$altField] ?? null;
    }
}
