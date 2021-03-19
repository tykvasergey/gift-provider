<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\ResourceModel;

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
        $this->_init('realthanks_provider_gift', 'entity_id');
    }
}
