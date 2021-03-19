<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\ResourceModel\RtGift;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use RealThanks\GiftProvider\Model\ResourceModel\RtGift as ResourceModel;
use RealThanks\GiftProvider\Model\RtGift as Model;

class Collection extends AbstractCollection
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'rt_gift_collection';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(Model::class, ResourceModel::class);
    }
}
