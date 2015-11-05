<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\helpers;

use yii\helpers\Html as BaseHtml;

/**
 * 
 */
class Html extends BaseHtml {
    
    /**
     * 
     * @param string $class
     * @return string
     */
    public static function font($class) {
        return static::tag('i', '', ['class' => $class]);
    }
}