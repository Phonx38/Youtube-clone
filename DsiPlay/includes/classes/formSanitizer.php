<?php


class formSanitizer {
    public static function sanitizeString($string)
    {
        $string = strip_tags($string);
        $string = str_replace(" ","",$string);
        $string = strtolower($string);
        $string = ucfirst($string);

        return $string;
    }

    public static function sanitizeUsername($string)
    {
        $string = strip_tags($string);
        $string = str_replace(" ","",$string);
        
        return $string;
    }

    public static function sanitizeEmail($string)
    {
        $string = strip_tags($string);
        $string = str_replace(" ","",$string);
        

        return $string;
    }

    public static function sanitizePassword($string)
    {
        $string = strip_tags($string);
         

        return $string;
    }

}

?>