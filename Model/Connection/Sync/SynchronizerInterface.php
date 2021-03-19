<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Connection\Sync;

interface SynchronizerInterface
{
    public function synchronize() : bool;
}
