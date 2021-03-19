<?php
namespace RealThanks\GiftProvider\Ui\Component\Order\Listing\Columns;

use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use RealThanks\GiftProvider\Model\RtOrderRepository;

class Price extends \Magento\Ui\Component\Listing\Columns\Column
{
    /**
     * @var RtOrderRepository
     */
    private $giftOrderRepo;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        RtOrderRepository $giftOrderRepo,
        array $components = [],
        array $data = []
    ) {
        $this->giftOrderRepo = $giftOrderRepo;
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
                $item[$fieldName] = $this->giftOrderRepo->getGiftAttributeById($fieldName, $item["entity_id"]);
            }
        }

        return $dataSource;
    }
}
