<?php

use \PHPUnit\Framework\TestCase;

class DataSourceFactoryTest extends TestCase
{
    public function testMySQLConnectionCreation()
    {
        global $mysql_good_config;
        $this->assertInstanceOf("\Mpopa\DataSource\MySQL", \Mpopa\DataSource\DataSourceFactory::build($mysql_good_config));
    }
    public function testMySQLConnectionWithErrorCreation()
    {
        global $mysql_wrong_config;
        $this->expectException("\Mpopa\ExpException");
        $this->assertInstanceOf("\Mpopa\DataSource\MySQL", \Mpopa\DataSource\DataSourceFactory::build($mysql_wrong_config));
    }

    public function testJsonConnectionCreation()
    {
        global $json_good_config;
        $this->assertInstanceOf("\Mpopa\DataSource\Json", \Mpopa\DataSource\DataSourceFactory::build($json_good_config));
    }

    public function testUndefinedConnectionCreation()
    {
        $wrong_config = (object) array();
        $this->expectException("Mpopa\ExpException");
        \Mpopa\DataSource\DataSourceFactory::build($wrong_config);
    }
}
