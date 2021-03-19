<?php
namespace RealThanks\GiftProvider\Ui\Component\Gift\Listing\Column;

class Thumbnail extends \Magento\Ui\Component\Listing\Columns\Column
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
                $item[$fieldName . '_src'] = $item['image_url'];
                $item[$fieldName . '_alt'] = $this->getAlt($item);
                $item[$fieldName . '_orig_src'] = $item['image_url'];
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
