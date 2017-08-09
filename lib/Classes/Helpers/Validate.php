<?php
/** 
 * Validation class 
 * @version 0.1.0
 * @author Andreas Hansson <3941133@rts-365.dk>
 */

namespace Helpers;

class Validate{

    public $phoneFormatted;

    /**
     * Validates name and checks that it is characters only
     *
     * @param string $char
     * @param int $min (default = 2) 
     * @param int $max (default = 25)
     * @return bool
     */
    public function characters($char, $min = 2, $max = 25){
        return (
            isset($char) && 
            strlen((string)$char) >= (int)$min && 
            strlen((string)$char) <= (int)$max && 
            preg_match("/[a-zæøåäüö]+$/i", $char)
        ) ? true : false;
    }
    /**
     * Birthdate check if the date is valid (Not all datformats supported)
     *
     * @param string $date
     * @return bool
     */
    public function birthdate($date){
        return
        (
            isset($date) &&
            (preg_match("~^\d{2}-\d{2}-\d{4}$~", (string)$date) ||
            preg_match("~^\d{2}/\d{2}/\d{4}$~", (string)$date) ||
            preg_match("~^\d{4}-\d{2}-\d{2}$~", (string)$date) ||
            preg_match("~^\d{4}/\d{2}/\d{2}$~", (string)$date))
        ) ? true : false;
    }
    
    /**
     * stringBetween checks string with both aplhanumeric & charcters on specific length
     *
     * @param string $str
     * @param int $min (default = 2)
     * @param int $max (default = 68)
     * @return bool
     */
    public function stringBetween($str, $min = 2, $max = 68){
        return (
            isset($str) &&
            strlen((string)$str) >= (int)$min && 
            strlen((string)$str) <= (int)$max && 
            preg_match("/[a-zæøåäüö\s0-9,.]+$/i", $str)
        ) ? true : false;
    }

    public function currency($currency){
        return (
            isset($currency) && !empty($currency) &&
            preg_match("/^[0-9]+(?:\.[,0-9]{1,3})?$/im", $currency)
        ) ? true: false;
    }

    /**
     * intBetween check for int only and the min, max given
     *
     * @param string $int
     * @param int $min (default = 4)
     * @param int $max (default = 5)
     * @return bool
     */
    public function intBetween($int, $min = 4, $max = 5){
        return (
            isset($int) &&
            is_numeric($int) &&
            strlen((string)$int) >= (int)$min && 
            strlen((string)$int) <= (int)$max
        ) ? true : false;
    }

    /**
     * Check if phonenumber is valid with country code included
     *
     * @param string $num
     * @return bool
     */
    public function phone($num){
        try{
            if(isset($num) && strlen($num) >= 8 ){
                $num = str_replace(' ', '', $num);
                $num = (int)preg_replace("/(^[+]\d{2} | ^00\d{2})/x", "", $num);
                if(is_numeric($num)){
                    $this->phoneFormatted = $num;
                    return true;
                }
            }
        }catch(Exception $err){
            return $err->getMessage();
        }
         return false;
    }

    /**
     * E-mail validation with PHP filter_var
     *
     * @param string $email
     * @return bool
     */
    public function email($email){
        return (
            isset($email) &&
            filter_var($email, FILTER_VALIDATE_EMAIL)
        ) ? true : false;
    }

    /**
     * check if the 2 parameters if the same dataypte
     *
     * @param mixed $x
     * @param mixed $y
     * @return bool
     */
    public function match($x, $y){
        return $x === $y ? true : false;
    }

    /**
     * Checks if $var is set and greater or equals to $min
     *
     * @param mixed $var
     * @param int $min
     * @param int $max
     * @return bool
     */
    public function mixedBetween($var, $min, $max = 255){
        return (
            isset($var) &&
            strlen($var) >= (int)$min && 
            strlen($var) <= (int)$max
        ) ? true : false;
    }
    
}