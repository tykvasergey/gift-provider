<?php

namespace WiserBrand\RealThanks\Api\Data;

/**
 * @package WiserBrand\RealThanks\Api\Data
 */
interface RtOrderInterface
{
    const ENTITY_ID     = 'entity_id';
    const STATUS        = 'status';
    const EMAIL         = 'email';
    const SUBJECT       = 'subject';
    const CREATION_TIME = 'creation_time';
    const UPDATE_TIME   = 'update_time';
    const RT_ID         = 'rt_order_id';
    const GIFT_ID       = 'gift_id';
    const MSG           = 'message';
    const COMPLETE        = 'is_complete';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getStatus() : string;

    /**
     * @return string
     */
    public function getEmail() : string;

    /**
     * @return string
     */
    public function getSubject() : string;

    /**
     * @return string
     */
    public function getMessage() : string;
}
