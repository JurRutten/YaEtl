<?php

/*
 * This file is part of YaEtl.
 *     (c) Fabrice de Stefanis / https://github.com/fab2s/YaEtl
 * This source file is licensed under the MIT license which you will
 * find in the LICENSE file or at https://opensource.org/licenses/MIT
 */

namespace fab2s\YaEtl\Laravel\Extractors;

use fab2s\YaEtl\Extractors\PdoExtractor;
use Illuminate\Database\Query\Builder;

/**
 * Class DbExtractor
 */
class DbExtractor extends PdoExtractor
{
    /**
     * @var \SplDoublyLinkedList
     */
    protected $extracted;

    /**
     * query object
     *
     * @var Builder
     */
    protected $extractQuery;

    /**
     * @param Builder|null $extractQuery
     */
    public function __construct(Builder $extractQuery = null)
    {
        $this->configurePdo($extractQuery->getConnection()->getPdo());

        if ($extractQuery !== null) {
            $this->setExtractQuery($extractQuery);
        }
    }

    /**
     * @param $extractQuery
     *
     * @throws \Exception
     *
     * @return $this
     */
    public function setExtractQuery($extractQuery)
    {
        if (!($extractQuery instanceof Builder)) {
            throw new \ErrorException('Argument 1 passed to ' . __METHOD__ . ' must be an instance of ' . Builder::class . ', ' . \gettype($extractQuery) . ' given');
        }

        parent::setExtractQuery($extractQuery);

        return $this;
    }

    /**
     * This method sets offset and limit in the query
     *
     * @return string the paginated query with current offset and limit
     */
    protected function getPaginatedQuery()
    {
        $extractQuery = $this->extractQuery
            ->skip($this->offset)
            ->take($this->batchSize);
        $this->queryBindings = $extractQuery->getRawBindings();
        $this->queryBindings = $this->queryBindings['where'];

        return $extractQuery->toSql();
    }
}
