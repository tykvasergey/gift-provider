<?php

namespace WiserBrand\RealThanks\Model\ResourceModel\SyncLog;

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
        $this->_init('WiserBrand\RealThanks\Model\SyncLog', 'WiserBrand\RealThanks\Model\ResourceModel\SyncLog');
    }
}
