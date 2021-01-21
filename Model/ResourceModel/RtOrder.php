<?php

namespace WiserBrand\RealThanks\Model\ResourceModel;

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
        $this->_init('wiser_brand_rt_order', 'entity_id');
    }
}
