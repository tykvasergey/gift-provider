<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\Source;

use Magento\Framework\Api\SearchCriteriaBuilder;
use Magento\Framework\Data\OptionSourceInterface;
use WiserBrand\RealThanks\Api\Data\RtGiftInterface;
use WiserBrand\RealThanks\Model\RtGiftRepository;

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
        /** @var RtGiftInterface $item */
        foreach ($this->getGifts() as $item) {
            // @todo get currency from config + cost format
            $res[] = ['value' => $item->getId(), 'label' => $item->getName() . ', ' . $item->getCost() . '$'];
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
