<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model;

use Magento\Framework\Api\Search\SearchResult;
use Magento\Framework\Api\SearchCriteriaInterface;
use WiserBrand\RealThanks\Api\Data\RtOrderInterface;

class RtOrderRepository implements \WiserBrand\RealThanks\Api\RtOrderRepositoryInterface
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
    public function getById(int $giftId): RtOrderInterface
    {
        // TODO: Implement getById() method.
    }

    public function save(RtOrderInterface $giftOrder)
    {
        return;
    }

    public function delete(RtOrderInterface $giftOrder)
    {
        return;
    }

    /**
     * returns non-complete orders that has rt_order_id (it means that they are were sent to RT)
     * will use in the order sync
     * @return RtOrderInterface[]
     */
    public function getActiveOrders():array
    {
        return [];
    }
}
