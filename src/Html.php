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

    /**
     * Renders an icon button.
     * 
     * @param string $icon
     * @param array $options
     * @return string
     */
    public static function iconButton($icon, array $options = []) {
        if (isset($options['class'])) {
            $options['class'] = 'icon ' . $options['class'];
        } else {
            $options['class'] = 'icon';
        }
        return static::tag('button', static::font($icon), $options);
    }

    /**
     * Renders an incon anchor.
     * 
     * @param string $icon
     * @param array $options
     * @return string
     */
    public static function iconA($icon, $url, array $options = []) {
        if (isset($options['class'])) {
            $options['class'] = 'icon ' . $options['class'];
        } else {
            $options['class'] = 'icon';
        }
        return static::a(static::font($icon), $url, $options);
    }

}
