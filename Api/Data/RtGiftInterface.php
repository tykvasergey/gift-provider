<?php

namespace WiserBrand\RealThanks\Api\Data;
/**
 * @package WiserBrand\RealThanks\Api\Data
 */
interface RtGiftInterface
{
    const ENTITY_ID     = 'entity_id';
    const NAME          = 'name';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const COST          = 'cost';
    const ACTIVE        = 'is_active';
    const IMAGE_URL     = 'image_url';
    const RT_ID         = 'rt_gift_id';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return float
     */
    public function getCost() : float;

}
