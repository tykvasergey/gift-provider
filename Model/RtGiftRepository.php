<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model;

use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use WiserBrand\RealThanks\Api\Data\RtGiftInterface;

class RtGiftRepository implements \WiserBrand\RealThanks\Api\RtGiftRepositoryInterface
{
    /**
     * @inheritDoc
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResult
    {
        // TODO: Implement getList() method.
    }

    /**
     * @inheritDoc
     */
    public function getById(int $giftId): RtGiftInterface
    {
        // TODO: Implement getById() method.
    }

    public function save(RtGiftInterface $gift)
    {
        return;
    }

    public function delete(RtGiftInterface $gift)
    {
        return;
    }
    /**
     * returns model by origin RT_id
     */
    public function getByRtId(int $giftRtId): RtGiftInterface
    {

    }

    /**
     * returns RT_id[] of all active gifts
     */
    public function getActiveGiftRtIds(): array
    {
        return [];
    }


}
