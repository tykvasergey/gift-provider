<?php

namespace RealThanks\GiftProvider\Api\Data;

/**
 * @package RealThanks\RealThanks\Api\Data
 */
interface RtGiftInterface
{
    const ENTITY_ID     = 'entity_id';
    const NAME          = 'name';
    const DESCRIPTION   = 'description';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const COST          = 'cost';
    const ACTIVE        = 'active';
    const IMAGE_URL     = 'image_url';
    const RT_ID         = 'rt_gift_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return mixed
     */
    public function getRtId();

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return string|null
     */
    public function getDescription(): ?string;

    /**
     * @return float
     */
    public function getCost() : float;
}
