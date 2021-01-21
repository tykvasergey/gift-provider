<?php

namespace WiserBrand\RealThanks\Model\RealThanks\Sync;

class SynchronizerList implements SynchronizerListInterface
{
    /**
     * List of routers
     *
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
     * @return void Any returned value is ignored.
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
     * @return boolean The return value will be casted to boolean and then evaluated.
     * Returns true on success or false on failure.
     */
    public function valid()
    {
        return !!current($this->synchronizerList);
    }

    /**
     * @return void Any returned value is ignored.
     */
    public function rewind()
    {
        reset($this->synchronizerList);
    }
}
