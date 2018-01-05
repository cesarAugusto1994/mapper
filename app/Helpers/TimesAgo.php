<?php

namespace App\Helpers;

/**
 *
 */
class TimesAgo
{
    const TIMEBEFORE_NOW = 'now';
    const TIMEBEFORE_MINUTE = '{num} minute ago';
    const TIMEBEFORE_MINUTES = '{num} minutes ago';
    const TIMEBEFORE_HOUR = '{num} hour ago';
    const TIMEBEFORE_HOURS = '{num} hours ago';
    const TIMEBEFORE_YESTERDAY = 'yesterday';
    const TIMEBEFORE_FORMAT = '%e %b';
    const TIMEBEFORE_FORMAT_YEAR = '%e %b, %Y';

    public static function render($time)
    {
         $out    = '';
         $now    = time(); // current time
         $diff   = $now - date_timestamp_get(new \DateTime($time)); // difference between the current and the provided dates

         if( $diff < 60 ) {
             return self::TIMEBEFORE_NOW;
         } elseif( $diff < 3600 ) {
            return str_replace( '{num}', ( $out = round( $diff / 60 ) ), $out == 1 ? self::TIMEBEFORE_MINUTE : self::TIMEBEFORE_MINUTES );
         } elseif( $diff < 3600 * 24 ) {
            return str_replace( '{num}', ( $out = round( $diff / 3600 ) ), $out == 1 ? self::TIMEBEFORE_HOUR : self::TIMEBEFORE_HOURS );
         } elseif( $diff < 3600 * 24 * 2 ) {
            return self::TIMEBEFORE_YESTERDAY;
         } else {
            return strftime( date( 'Y', $time ) == date( 'Y' ) ? self::TIMEBEFORE_FORMAT : self::TIMEBEFORE_FORMAT_YEAR, $time );
         }
     }

}
