<?php
namespace Mpopa;

/**
 * Custom Exception class
 */
class ExpException extends \Exception
{
    public function __construct($message, $code = 0, \Exception $previous = null)
    {
        // Write error to log file
        Logger::writeError($this->file, $this->line, $message);
        parent::__construct((HIDE_ERRORS ? GENERIC_ERROR_MESSAGE : $message), $code, $previous);
    }
}
