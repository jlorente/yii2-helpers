<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @license     The MIT License (MIT)
 * @copyright   José Lorente
 * @version     1.0
 */

namespace jlorente\helpers;

/**
 * Formatter to convert seconds into time representations.
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class SecondsFormatter {

    const FORMAT_HOUR = 1;
    const FORMAT_MINUTE = 2;
    const FORMAT_SECOND = 3;

    /**
     * Gets the timestring formatted with the specified format.
     * 
     * @param int $seconds
     * @param int $format
     * @return string
     */
    public static function getTimestring($seconds, $format = self::FORMAT_HOUR) {
        $s = '';
        switch ($format) {
            case self::FORMAT_HOUR:
                $aux = $seconds % 3600;
                $s .= str_pad(($seconds - $aux) / 3600, 2, '0', STR_PAD_LEFT) . ':';
                $seconds = $aux;
            case self::FORMAT_MINUTE:
                $aux = $seconds % 60;
                $s .= str_pad(($seconds - $aux) / 60, 2, '0', STR_PAD_LEFT) . ':';
                $seconds = $aux;
            default:
                $s .= str_pad($seconds, 2, '0', STR_PAD_LEFT);
        }
        return $s;
    }

}
