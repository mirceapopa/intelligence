<?php

use \PHPUnit\Framework\TestCase;

class LoggerTest extends TestCase
{
    public function testLogFileCreation(){
        $log_file = __DIR__ . DIRECTORY_SEPARATOR . ".." . DIRECTORY_SEPARATOR . LOG_FILE;
        if(file_exists($log_file)){
            unlink($log_file);
        }

        \Mpopa\Logger::writeError("ExampleClass.php", 0 , 0);
        $this->assertFileExists($log_file);
        
        if(file_exists($log_file)){
            unlink($log_file);
        }
    }
}