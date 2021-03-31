<?php

namespace RealThanks\GiftProvider\Model\ResourceModel\RtOrder;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RealThanks\GiftProvider\Model\RtOrder as Model;
use RealThanks\GiftProvider\Model\ResourceModel\RtOrder as ResourceModel;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
