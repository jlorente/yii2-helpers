<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\helpers;

use InvalidArgumentException;

class LoremIpsum {

    const TYPE_PARAGRAPH = 1;
    const TYPE_WORDS = 2;
    const TYPE_BYTES = 3;
    const TYPE_LISTS = 4;

    /**
     *
     * @var int 
     */
    public $length;

    /**
     *
     * @var int 
     */
    public $type;

    /**
     *
     * @var type 
     */
    public $start;
    protected static $types = [
        self::TYPE_PARAGRAPH => 'paras',
        self::TYPE_WORDS => 'words',
        self::TYPE_BYTES => 'bytes',
        self::TYPE_LISTS => 'lists'
    ];

    public function __construct($length = 1, $type = self::TYPE_WORDS, $start = true) {
        $this->setLength($length);
        $this->setType($type);
        $this->setStart($start);
    }

    public function setLength($l) {
        if (is_numeric($l) === false) {
            throw new InvalidArgumentException('Length must be an integer value. ' . gettype($l) . ' given.');
        }
        $this->length = (int) $l;
    }

    public function setType($t) {
        if (is_numeric($t) === false) {
            throw new InvalidArgumentException('Type must be an integer value. ' . gettype($t) . ' given.');
        }
        if (isset(static::$types[$t]) === false) {
            throw new InvalidArgumentException('Type must be one of the valid values [' . implode(', ', array_flip($this->getTypesMap())) . ']. ' . $t . ' given.');
        }
        $this->type = $t;
    }

    public function setStart($s) {
        if (is_bool($s) === false) {
            throw new InvalidArgumentException('Start must be a boolean value. ' . gettype($s) . ' given.');
        }
        $this->start = $s;
    }

    public function getTypes() {
        return array_values(static::$types);
    }

    public function getTypesMap() {
        return static::$types;
    }

    public function get() {
        $t = static::$types[$this->type];
        $s = $this->start === true ? 'true' : 'false';
        $url = "http://www.lipsum.com/feed/json?amount={$this->length}&what=$t&start=$s";
        $json = json_decode(file_get_contents($url));
        return $json->feed->lipsum;
    }

    public function __toString() {
        return $this->get();
    }

    public static function generate($length = 1, $type = self::TYPE_WORDS, $start = true) {
        return (new static($length, $type, $start))->get();
    }

    public static function random($min, $max, $type = self::TYPE_WORDS, $start = true) {
        if (is_numeric($min) === false || is_numeric($max) === false || $min > $max) {
            throw new InvalidArgumentException();
        }

        return static::generate(mt_rand($min, $max), $type, $start);
    }

}
