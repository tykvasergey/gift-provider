<?php

namespace RealThanks\GiftProvider\Api;

use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;
use RealThanks\GiftProvider\Api\Data\RtGiftInterface;

/**
 * @api
 */
interface RtGiftRepositoryInterface
{
    /**
     * Retrieve results matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\Search\SearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria);

    /**
     * Retrieve RT Gift.
     *
     * @param int $giftId
     * @return \RealThanks\RealThanks\Api\Data\RtGiftInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $giftId): RtGiftInterface;
}
