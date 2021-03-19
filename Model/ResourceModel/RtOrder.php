<?php

namespace RealThanks\GiftProvider\Model\ResourceModel;

use \Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RtOrder extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wb_rt_order_resource_model';

    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init('realthanks_provider_order', 'entity_id');
    }
}
