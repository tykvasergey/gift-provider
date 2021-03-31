<?php

namespace RealThanks\GiftProvider\Model\ResourceModel;

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
        $this->_init('realthanks_provider_sync_log', 'sync_id');
    }
}
