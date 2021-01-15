<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    /**
     * @var \Magento\Config\Model\ResourceModel\Config
     */
    private $resourceConfig;

    const XML_PATH_RT_API_ENABLED = 'realthanks/api/enabled';
    const XML_PATH_RT_API_KEY = 'realthanks/api/key';
    const XML_PATH_RT_BALANCE = 'realthanks/general/balance';

    /**
     * @return string
     */
    public function getApiKey(): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RT_API_KEY
        );
    }

    /**
     * @return bool
     */
    public function isApiEnabled(): bool
    {
        return $this->scopeConfig->isSetFlag(
            self::XML_PATH_RT_API_ENABLED
        );
    }

    /**
     * @return string
     */
    public function getRtBalance(): string
    {
        return $this->scopeConfig->getValue(
            self::XML_PATH_RT_BALANCE
        );
    }

    public function setRtBalance($balance)
    {
        $this->resourceConfig->saveConfig(
            self::XML_PATH_RT_BALANCE,
            $balance
        );
    }
}
