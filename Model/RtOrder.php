<?php

namespace RealThanks\GiftProvider\Model;

use \Magento\Framework\Model\AbstractModel;
use RealThanks\GiftProvider\Api\Data\RtOrderInterface;
use RealThanks\GiftProvider\Model\ResourceModel\RtOrder as ResourceModel;

class RtOrder extends AbstractModel implements RtOrderInterface
{
    const COMPLETE_STATUS = "Complete";

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
        return $this->getData(self::STATUS);
    }

    /**
     * @inheritdoc
     */
    public function getEmail(): string
    {
        return $this->getData(self::EMAIL);
    }

    /**
     * @inheritdoc
     */
    public function getSubject(): string
    {
        return $this->getData(self::SUBJECT);
    }

    public function getRtId(): ?int
    {
        return $this->getData(self::RT_ID);
    }

    public function getGiftId(): int
    {
        return $this->getData(self::GIFT_ID);
    }

    public function getMessage(): string
    {
        return $this->getData(self::MSG);
    }

    /**
     * Is active
     *
     * @return bool
     */
    public function isComplete():bool
    {
        return (bool)$this->getData(self::COMPLETE);
    }

    /**
     * Set ID
     *
     * @param int $id
     * @return $this
     */
    public function setId($id)
    {
        return $this->setData(self::ENTITY_ID, $id);
    }

    public function setStatus(string $status)
    {
        if ($status == self::COMPLETE_STATUS) {
            $this->setIsComplete(true);
        }
        return $this->setData(self::STATUS, $status);
    }

    public function setRtId($rtId)
    {
        return $this->setData(self::RT_ID, $rtId);
    }

    public function setSubject(string $subject)
    {
        return $this->setData(self::SUBJECT, $subject);
    }

    public function setMessage(string $message)
    {
        return $this->setData(self::MSG, $message);
    }

    public function setIsComplete(bool $flag)
    {
        return $this->setData(self::COMPLETE, $flag);
    }

    public function setEmail(string $email)
    {
        return $this->setData(self::EMAIL, $email);
    }

    public function setGiftIdt(int $giftId)
    {
        return $this->setData(self::GIFT_ID, $giftId);
    }
}
