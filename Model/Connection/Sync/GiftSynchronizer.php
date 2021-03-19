<?php
declare(strict_types=1);

namespace RealThanks\GiftProvider\Model\Connection\Sync;

use RealThanks\GiftProvider\Model\Connection\Adapter;
use RealThanks\GiftProvider\Model\RtGift;
use RealThanks\GiftProvider\Model\RtGiftFactory;
use RealThanks\GiftProvider\Model\RtGiftRepository;
use RealThanks\GiftProvider\Model\SyncLogManagement;

class GiftSynchronizer implements SynchronizerInterface
{
    const SYNC_LOG_TYPE = 'gifts';

    /**
     * @var RtGiftRepository
     */
    private $giftRepo;

    /**
     * @var RtGiftFactory
     */
    private $giftFactory;

    /**
     * @var SyncLogManagement
     */
    private $syncLogManagement;

    /**
     * @var Adapter
     */
    private $adapter;

    /**
     * @var array
     */
    private $giftToUpdateIds = [];

    /**
     * @var array
     */
    private $rtData = [];

    /**
     * @param RtGiftRepository $giftRepo
     * @param SyncLogManagement $syncLogManagement
     * @param Adapter $adapter
     * @param RtGiftFactory $giftFactory
     */
    public function __construct(
        RtGiftRepository $giftRepo,
        SyncLogManagement $syncLogManagement,
        Adapter $adapter,
        RtGiftFactory $giftFactory
    ) {
        $this->giftRepo = $giftRepo;
        $this->syncLogManagement = $syncLogManagement;
        $this->adapter = $adapter;
        $this->giftFactory = $giftFactory;
    }

    private function init(): void
    {
        $this->giftToUpdateIds = $this->giftRepo->getRelationArrayIds();
        $this->rtData = $this->adapter->getGifts();
    }

    public function synchronize(): bool
    {
        $result = true;
        $logData = [
            'success' => false,
            'type' => self::SYNC_LOG_TYPE
        ];

        try {
            $this->init();
            $this->updateCreateGifts();
            $this->deleteGifts();
            $logData['success'] = true;
            $this->syncLogManagement->addSyncLog($logData);
        } catch (\Exception $exception) {
            $logData['message'] = $exception->getMessage();
            $this->syncLogManagement->addSyncLog($logData);
            $result = false;
        }

        return $result;
    }

    public function updateCreateGifts() : void
    {
        $giftRtIds = array_column($this->giftToUpdateIds, 'rtId');
        foreach ($this->rtData as $giftResponse) {
            $giftModel = $this->convertResponseToGiftModel($giftRtIds, $giftResponse);
            $this->giftRepo->save($giftModel);
        }
    }

    public function deleteGifts() : void
    {
        foreach ($this->giftToUpdateIds as $ids) {
            $gift = $this->giftRepo->getById($ids['id']);
            $gift->setActive(false);
            $this->giftRepo->save($gift);
        }
    }

    public function convertResponseToGiftModel(array $giftRtIds, array $giftResponse) : RtGift
    {
        $id = null;
        if (($key = array_search($giftResponse['id'], $giftRtIds)) !== false) {
            $id = $this->giftToUpdateIds[$key]['id'];
            unset($this->giftToUpdateIds[$key]);
        }
        /** @var RtGift $giftModel */
        $giftModel = $this->giftFactory->create();
        if ($id) {
            $giftModel->setId($id);
        }
        $giftModel->setRtId($giftResponse['id'])->setName($giftResponse['title'])
                ->setDescription($giftResponse['description'] ? strip_tags($giftResponse['description']) : '')
                ->setCost($giftResponse['price'])
                ->setImageUrl($giftResponse['images']['small_thumbnail']);

        return $giftModel;
    }
}
