<?php

namespace WiserBrand\RealThanks\Api;

use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use Magento\Framework\Data\SearchResultInterface;
use WiserBrand\RealThanks\Api\Data\RtGiftInterface;

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
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResultInterface;

    /**
     * Retrieve RT Gift.
     *
     * @param int $giftId
     * @return \WiserBrand\RealThanks\Api\Data\RtGiftInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $giftId): RtGiftInterface;
}
