<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\ResourceModel;

use Magento\Framework\Model\ResourceModel\Db\AbstractDb;

class RtGift extends AbstractDb
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wb_rt_gift_resource_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init('wiser_brund_rt_gift', 'entity_id');
    }
}
