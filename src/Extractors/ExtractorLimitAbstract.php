<?php

/*
 * This file is part of YaEtl.
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/YaEtl
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\YaEtl\Extractors;

/**
 * Class ExtractorLimitAbstract
 */
abstract class ExtractorLimitAbstract extends ExtractorAbstract implements ExtractorLimitInterface
{
    /**
     * Total number of records to fetch
     *
     * @var int
     */
    protected $limit;

    /**
     * Number of records
     *
     * @var int
     */
    protected $numRecords = 0;

    /**
     * Set extract limit
     *
     * @param int $limit
     *
     * @return $this
     */
    public function setLimit($limit)
    {
        $this->limit = max(0, (int) $limit);

        return $this;
    }

    /**
     * Get current limit
     *
     * @return int
     */
    public function getLimit()
    {
        return $this->limit;
    }

    /**
     * Get number of records (at the end of the Flow's execution)
     *
     * @return int
     */
    public function getNumRecords()
    {
        return $this->numRecords;
    }

    /**
     * Tells if limit is reached already
     *
     * @return bool true if limit is reached
     */
    public function isLimitReached()
    {
        return $this->limit && ($this->numRecords >= $this->limit);
    }
}
