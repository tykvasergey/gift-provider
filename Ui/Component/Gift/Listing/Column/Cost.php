<?php
namespace RealThanks\GiftProvider\Ui\Component\Gift\Listing\Column;

use RealThanks\GiftProvider\Helper\PriceFormatter;

class Cost extends \Magento\Ui\Component\Listing\Columns\Column
{
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
                    $item[$fieldName] = PriceFormatter::format($item[$fieldName]);
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
