<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\helpers;

use Countable;
use Iterator;
use yii\base\Object;
use yii\base\InvalidConfigException;
use yii\base\InvalidParamException;
use yii\db\QueryInterface;

/**
 * QueryStreamIterator provides an Iterator for large query resultsets that 
 * are likely to spend a large amount of memory. 
 * By setting the dataStreamSize property, the Iterator will only fetch this 
 * number of results at the same time.
 * It can be used in a foreach statment.
 * i.e.:
 * ```php
 * $cities = new QueryStreamIterator([
 *     'query' => City::find(),
 *     'dataStreamSize' => 500
 * ]);
 * foreach ($cities as $city) {
 *     echo $city->name . PHP_EOL;
 * }
 * ```
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class QueryStreamIterator extends Object implements Countable, Iterator {

    //Configurable vars
    /**
     * The query whose results will be iterated.
     * 
     * @var QueryInterface 
     */
    protected $query;

    /**
     * The number of results to fetch at the same time. 
     * You have to consider that the higher the number is, the higher the 
     * Iteration speed, but the memory comsumption will be also higher.
     * 
     * @var int 
     */
    protected $dataStreamSize = 500;

    //Internal vars

    /**
     * Number of the current dataStream internal counter.
     * 
     * @var int 
     */
    protected $i = 0;

    /**
     * Number of the whole resultset internal counter.
     * 
     * @var int 
     */
    protected $p = 0;

    /**
     * Total number of results of the query.
     * 
     * @var int 
     */
    protected $n;

    /**
     * Number of elements in the current dataStream.
     * 
     * @var int 
     */
    protected $nDataStream;

    /**
     * Current fetched dataStream.
     * 
     * @var mixed[] 
     */
    protected $dataStream;

    /**
     * @inheritdoc
     * 
     * @throws InvalidConfigException If the QueryInterface isn't provided.
     */
    public function init() {
        if ($this->query === null) {
            throw new InvalidConfigException('query property must be provided');
        }
        parent::init();
        $this->count();
    }

    /**
     * Sets the query property.
     * 
     * @param QueryInterface $query
     */
    public function setQuery(QueryInterface $query) {
        $this->query = $query;
    }

    /**
     * Sets the dataStreamSize property.
     * 
     * @param int $n
     * @throws InvalidParamException
     */
    public function setDataStreamSize($n) {
        if ($n !== null && is_numeric($n) === false) {
            throw new InvalidParamException('dataStreamSize must be null or a numeric value');
        }
        $this->dataStreamSize = (int) $n;
    }

    /**
     * Returns the number of results found by the query.
     * 
     * @return int
     */
    public function count() {
        if ($this->n === null) {
            $this->n = $this->getQuery()->count();
        }
        return $this->n;
    }

    /**
     * Returns the current result of the Iterator.
     * 
     * @return int
     */
    public function current() {
        if (isset($this->dataStream[$this->i]) === false) {
            $this->loadDataStream();
        }
        return $this->dataStream[$this->i];
    }

    /**
     * Increments the internal counters of the Iterator.
     */
    public function next() {
        ++$this->i;
        ++$this->p;
    }

    /**
     * Returns the number of the current internal counter of the whole resultset.
     * 
     * @return int
     */
    public function key() {
        return $this->p;
    }

    /**
     * Checks whether the internal counter has reached the end of the Iterator 
     * or not.
     * 
     * @return boolean
     */
    public function valid() {
        return $this->p < $this->n;
    }

    /**
     * Sets the internal counters of the iterators to 0.
     */
    public function rewind() {
        $this->i = $this->p = 0;
        $this->dataStream = null;
    }

    /**
     * Returns a cloned copy of the query.
     * 
     * @return QueryInterface
     */
    protected function getQuery() {
        return clone $this->query;
    }

    /**
     * Fetches a dataStream using the internal counter of the resultset as 
     * offset and the dataStreamSize property as limit.
     */
    protected function loadDataStream() {
        $query = $this->getQuery()->offset($this->p);
        if ($this->dataStreamSize > 0) {
            $query->limit($this->dataStreamSize);
        }
        $this->dataStream = $query->all();
        $this->nDataStream = count($this->dataStream);
        $this->i = 0;
    }

}
