<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Logger;

use Magento\Framework\Logger\Handler\Base;
use Monolog\Logger;

class Handler extends Base
{
    /**
     * @var int
     */
    protected $loggerType = Logger::NOTICE;

    /**
     * @var string
     */
    protected $fileName = '/var/log/rt_gift_provider.log';
}
