<?php

namespace RealThanks\GiftProvider\Api;

use Magento\Framework\Api\SearchCriteriaInterface;
use RealThanks\GiftProvider\Api\Data\RtOrderInterface;

/**
 * @api
 */
interface RtOrderRepositoryInterface
{
    /**
     * Retrieve results matching the specified criteria.
     *
     * @param \Magento\Framework\Api\SearchCriteriaInterface $searchCriteria
     * @return \Magento\Framework\Api\Search\SearchResultInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getList(SearchCriteriaInterface $searchCriteria):
    \Magento\Framework\Api\Search\SearchResultInterface;

    /**
     * Retrieve RT Order.
     *
     * @param int $giftOrderId
     * @return \RealThanks\GiftProvider\Api\Data\RtOrderInterface
     * @throws \Magento\Framework\Exception\LocalizedException
     */
    public function getById(int $giftOrderId): RtOrderInterface;
}
