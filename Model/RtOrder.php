<?php

namespace WiserBrand\RealThanks\Model;

use \Magento\Framework\Model\AbstractModel;
use WiserBrand\RealThanks\Api\Data\RtOrderInterface;
use WiserBrand\RealThanks\Model\ResourceModel\RtOrder as ResourceModel;

class RtOrder extends AbstractModel implements RtOrderInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wb_rt_order_model';

    /**
     * @inheritdoc
     */
    public function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getStatus(): string
    {
        // TODO: Implement getStatus() method.
    }

    /**
     * @inheritdoc
     */
    public function getEmail(): string
    {
        // TODO: Implement getEmail() method.
    }

    /**
     * @inheritdoc
     */
    public function getSubject(): string
    {
        // TODO: Implement getSubject() method.
    }
}
