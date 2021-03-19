<?php

namespace RealThanks\GiftProvider\Model\ResourceModel\SyncLog;

use \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;

class Collection extends AbstractCollection
{
    /**
     * Initialize resource collection
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('RealThanks\GiftProvider\Model\SyncLog', 'RealThanks\GiftProvider\Model\ResourceModel\SyncLog');
    }
}
