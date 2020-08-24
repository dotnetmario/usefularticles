<?php

namespace App;

class Helper {
    protected $obj;

    public function __construct($obj = null){
        $this->obj = $obj;
    }

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


    /**
     * casts the value of a string to it's original form
     * ex : [string]"21" => [int]21
     * 
     */
    public static function getRealVariableValue($val){
        /* FUNCTION FLOW */
        // *1. Remove unused spaces
        // *2. Check if it is empty, if yes, return blank string
        // *3. Check if it is numeric
        // *4. If numeric, this may be a integer or double, must compare this values.
        // *5. If string, try parse to bool.
        // *6. If not, this is string.

        $val = trim($val);

        if(empty($val))
            return "";

        if(!preg_match("/[^0-9.]+/", $val)){
            if(preg_match("/[.]+/", $val)){
                return (double)$val;
            }else{
                return (int)$val;
            }
        }

        if($val == "true") 
            return true;

        if($val == "false")
            return false;

        return (string)$val;
    }
}