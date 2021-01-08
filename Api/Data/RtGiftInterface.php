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
    const COST          = 'cost';
    const ACTIVE        = 'is_active';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getName() : string;

    /**
     * @return string
     */
    public function getCost() : string;

}
