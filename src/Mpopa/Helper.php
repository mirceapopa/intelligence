<?php
namespace Mpopa;

/**
 * This class handles general operations
 * like validating json data and checking types
 */
class Helper{
    public static function isIntegerAndPositive($value) : bool{
        return filter_var($value, FILTER_VALIDATE_INT) !== false &&  ($value > 0);
    }

    public static function isFloatAndPositive($value) : bool{
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false && ($value > 0);
    }

    public static function isFloat($value) : bool{
        return filter_var($value, FILTER_VALIDATE_FLOAT) !== false;
    }

    public static function isJSON($data, $file_url = "") : bool{
        json_decode($data);
        if (json_last_error() == JSON_ERROR_NONE) {
            return true;
        } else {
            if($file_url != ""){
                throw new ExpException($file_url . " not a valid json file.");
            } else {                
                throw new ExpException("Not a valid json.");
            }
        }
    }
    
    public static function fileExists($file_url) : bool{
        if (@file_get_contents($file_url, 0, null, 0, 1)) {
            return true;
        } else {
            throw new ExpException($file_url . " not found.");
        }
    }

    public static function compareFloats($a, $b){
        return abs(($a-$b)/$b) < 0.0000001;
    }

    /**
     * It looks for input for the API
     * it checks against:
     *      - $_GET["order"] key (must contain link to the order json file)
     *      - $argv[1] command line argument (must contain link or path to the order json file)
     *      - $_POST - if the order json was sent in the body of the POST request
     * Returns null if it can't find it anywhere
     */
    public static function getRequestOrder($get, $argv, $post) : ?string{
        // check for $_GET["order]
        $file = $get["order"] ?? $argv[1] ?? null;
        if($file !== null && @file_get_contents($file, 0, null, 0, 1)){
            return file_get_contents($file);
        }

        // check for order passed in $_POST
        return file_get_contents("php://input") ?? null;
    }

    public static function validateArrayKeys($keys, $array) : bool{
        return $keys == array_keys($array);
    }
}