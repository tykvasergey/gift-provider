<?php

namespace RealThanks\GiftProvider\Model\ResourceModel\SyncLog;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RealThanks\GiftProvider\Model\SyncLog as Model;
use RealThanks\GiftProvider\Model\ResourceModel\SyncLog as ResourceModel;

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
