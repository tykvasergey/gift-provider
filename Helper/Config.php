<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Config extends AbstractHelper
{
    const XML_PATH_RT_API_ENABLED = 'rt_gift_provider/api/enabled';
    const XML_PATH_RT_API_KEY = 'rt_gift_provider/api/key';

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
}
