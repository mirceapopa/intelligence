<?php
namespace Mpopa;

/**
 * Simple logger class
 */
class Logger{
    /**
     * Writes errors to LOG_FILE file, set in config.php
     */
    static public function writeError($file, $line, $message){
        $error_log_message = date("Y-m-d H-i-s") . " | " . $file . " | line " . $line . " | " . $message . "\n";
        error_log($error_log_message, 3, LOG_FILE);
    }
}