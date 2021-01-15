<?php
declare(strict_types=1);

namespace WiserBrand\RealThanks\Model\RealThanks\Sync;

use Magento\Tests\NamingConvention\true\bool;
use WiserBrand\RealThanks\Model\RealThanks\Adapter;
use WiserBrand\RealThanks\Model\RtGiftRepository;

class GiftSynchronizer implements SynchronizerInterface
{
    /**
     * @var RtGiftRepository
     */
    private $giftRepo;

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var array
     */
    private $idsGiftToUpdate = [];

    /**
     * @var array
     */
    private $rtData = [];

    private function init(): void
    {
        $this->idsGiftToUpdate = $this->giftRepo->getActiveGiftRtIds();
        $this->rtData = $this->adapter->getGifts(); // call RT to get all available gifts
    }

    public function synchronize(): bool
    {
        $this->init();

        return $this->updateCreateGifts() && $this->deleteGifts();
    }

    private function updateCreateGifts() : bool
    {
        // search for each id from ids in rtData
        // if find - update if not create new Gift.
        // Delete each synchronized id from ids
        return true;
    }

    private function deleteGifts() : bool
    {
        // disable all Gifts (setIsActive(false)), that left in ids
        return true;
    }
}
