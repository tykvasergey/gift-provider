<?php

namespace WiserBrand\RealThanks\Model\ResourceModel\RtOrder;

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
        $this->_init('WiserBrand\RealThanks\Model\RtOrder', 'WiserBrand\RealThanks\Model\ResourceModel\RtOrder');
    }
}
