<?php

namespace WiserBrand\RealThanks\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class SyncLog extends AbstractDb
{
    /**
     * Initialize resource
     *
     * @return void
     */
    public function _construct()
    {
        $this->_init('wiser_brand_rt_sync_log', 'sync_id');
    }
}

