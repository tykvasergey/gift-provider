<?php

namespace RealThanks\GiftProvider\Model;

use \Magento\Framework\Model\AbstractModel;

class SyncLog extends AbstractModel
{
    const BALANCE_LOG_TYPE = 'balance';
    const GIFT_LOG_TYPE = 'gifts';
    const ORDER_LOG_TYPE = 'order';

    /**
     * Initialize resource model
     * @return void
     */
    public function _construct()
    {
        $this->_init(\RealThanks\GiftProvider\Model\ResourceModel\SyncLog::class);
    }

    /**
     * Get SyncLog status
     *
     * @return bool
     */
    public function isSuccessful()
    {
        return $this->getData('success');
    }

    /**
     * Set SyncLog status
     *
     * @param bool $value
     */
    public function setSuccessful(bool $value)
    {
        $this->setData('success', $value);
    }

    /**
     * Get SyncLog type
     *
     * @return string
     */
    public function getType()
    {
        return $this->getData('type');
    }

    /**
     * Set SyncLog type
     *
     * @param string $value
     */
    public function setType(string $value)
    {
        $this->setData('type', $value);
    }

    /**
     * Get sync message
     *
     * @return string
     */
    public function getMessage()
    {
        return $this->getData('message');
    }

    /**
     * Set sync message
     *
     * @param string $value
     */
    public function setMessage(string $value)
    {
        $this->setData('message', $value);
    }

    /**
     * Get balance
     *
     * @return float
     */
    public function getBalance()
    {
        return $this->getData('balance');
    }

    /**
     * Set SyncLog type
     *
     * @param float $value
     */
    public function setBalance(float $value)
    {
        $this->setData('balance', $value);
    }
    /**
     * Get sync creation date
     *
     * @return string
     */
    public function getCreatedAt()
    {
        return $this->getData('creation_time');
    }

    /**
     * Set sync creation date
     *
     * @param string $value
     */
    public function setCreatedAt(string $value)
    {
        $this->setData('creation_time', $value);
    }
}
