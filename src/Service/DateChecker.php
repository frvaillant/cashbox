<?php


namespace App\Service;


class DateChecker
{

    public static function checkDate(string $date)
    {
        $pattern = '([0-9]{2}/[0-9]{2}/[0-9]{4})';
        if (preg_match($pattern, $date) === 1) {
            list($day, $month, $year) = explode('/', $date);
            if(checkdate ($month, $day , $year)) {
                return $year . '-' . $month . '-' . $day;
            }
        }
        return false;
    }
}
