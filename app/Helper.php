<?php

class Helper {
    // protected $obj;

    // public function __construct($obj){
    //     $this->obj = $obj;
    // }

    /**
     * check if a date is valid against a format
     * 
     * @param string date
     * @param string format
     * 
     * @return bool
     */
    public static function validateDate($date, $format = 'Y-m-d')
    {
        $d = DateTime::createFromFormat($format, $date);
        return $d && $d->format($format) === $date;
    }
}