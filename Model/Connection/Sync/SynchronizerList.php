<?php

namespace RealThanks\GiftProvider\Model\Connection\Sync;

class SynchronizerList implements SynchronizerListInterface
{
    /**
     * @var SynchronizerInterface[]
     */
    protected $synchronizerList;

    /**
     * @param SynchronizerInterface[] $synchronizerList
     */
    public function __construct(array $synchronizerList)
    {
        $this->synchronizerList = $synchronizerList;
    }

    /**
     * @return SynchronizerInterface
     */
    public function current()
    {
        return $this->synchronizerList[$this->key()];
    }

    /**
     * @return void
     */
    public function next()
    {
        next($this->synchronizerList);
    }

    /**
     * @return string|int|null
     */
    public function key()
    {
        return key($this->synchronizerList);
    }

    /**
     * @return boolean
     */
    public function valid()
    {
        return !!current($this->synchronizerList);
    }

    /**
     * @return void
     */
    public function rewind()
    {
        reset($this->synchronizerList);
    }
}
