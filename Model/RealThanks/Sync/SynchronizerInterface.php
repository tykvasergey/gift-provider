<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks\Sync;


interface SynchronizerInterface
{
    public function synchronize() : bool;
}
