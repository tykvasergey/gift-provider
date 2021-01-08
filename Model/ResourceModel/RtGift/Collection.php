<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\ResourceModel\RtGift;

use Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection;
use WiserBrand\RealThanks\Model\ResourceModel\RtGift as ResourceModel;
use WiserBrand\RealThanks\Model\RtGift as Model;

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
