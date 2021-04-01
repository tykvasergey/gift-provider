<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Source;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;
use RealThanks\GiftProvider\Helper\PriceFormatter;
use RealThanks\GiftProvider\Model\RtGift;
use RealThanks\GiftProvider\Model\RtGiftRepository;

class RtGiftSource implements OptionSourceInterface
{
    /**
     * @var RtGiftRepository
     */
    private $giftRepo;

    /**
     * @var SearchCriteriaBuilder
     */
    private $searchCriteria;

    /**
     * @param RtGiftRepository $giftRepo
     * @param SearchCriteriaBuilder $searchCriteria
     */
    public function __construct(RtGiftRepository $giftRepo, SearchCriteriaBuilder $searchCriteria)
    {
        $this->giftRepo = $giftRepo;
        $this->searchCriteria = $searchCriteria;
    }

    /**
     * @return array
     */
    private function getOptions() : array
    {
        $res = [];
        /** @var RtGift $item */
        foreach ($this->getGifts() as $item) {
            $res[] = [
                'value' => $item->getId(),
                'label' => $item->getName() . ', ' . PriceFormatter::format($item->getCost()),
                'image' => $item->getImageUrl()
            ];
        }

        return $res;
    }

    /**
     * {@inheritdoc}
     */
    public function toOptionArray() : array
    {
        return $this->getOptions();
    }

    public function getGifts() : array
    {
        $this->searchCriteria->addFilter('active', true);

        return $this->giftRepo->getList($this->searchCriteria->create())->getItems();
    }
}
