<?php

namespace WiserBrand\RealThanks\Api;

use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use WiserBrand\RealThanks\Api\Data\RtOrderInterface;

/**
 * @api
 */
interface RtOrderRepositoryInterface
{
    /**
     * Retrieve results matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\Search\SearchResult
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria): SearchResult;

    /**
     * Retrieve RT Order.
     *
     * @param int $giftId
     * @return \WiserBrand\RealThanks\Api\Data\RtOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $giftId): RtOrderInterface;
}
