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

    const XML_PATH_RT_BALANCE = 'real_thanks/general/balance';

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
