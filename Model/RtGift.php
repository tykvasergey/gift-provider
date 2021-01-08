<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model;

use Magento\Framework\Model\AbstractModel;
use WiserBrand\RealThanks\Api\Data\RtGiftInterface;
use WiserBrand\RealThanks\Model\ResourceModel\RtGift as ResourceModel;

class RtGift extends AbstractModel implements RtGiftInterface
{
    /**
     * @var string
     */
    protected $_eventPrefix = 'wb_rt_gift_model';

    /**
     * @inheritdoc
     */
    protected function _construct()
    {
        $this->_init(ResourceModel::class);
    }

    /**
     * @inheritdoc
     */
    public function getName(): string
    {
        // TODO: Implement getName() method.
    }

    /**
     * @inheritdoc
     */
    public function getCost(): string
    {
        // TODO: Implement getCost() method.
    }
}
