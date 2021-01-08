<?php

namespace WiserBrand\RealThanks\Api\Data;
/**
 * @package WiserBrand\RealThanks\Api\Data
 */
interface RtOrderInterface
{
    const ENTITY_ID = 'entity_id';
    const STATUS    = 'status';
    const EMAIL     = 'email';
    const SUBJECT   = 'subject';

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

}
