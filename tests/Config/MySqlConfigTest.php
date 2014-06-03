<?php

namespace CSanquer\Silex\PdoServiceProvider\Tests\Config;

use CSanquer\Silex\PdoServiceProvider\Config\MySqlConfig;

/**
 * TestCase for MySqlConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class MySqlConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var MySqlConfig
     */
    protected $pdoConfig;

    public function setUp()
    {
        $this->pdoConfig = new MySqlConfig();
    }

    /**
     * @dataProvider dataProviderPrepareParameters
     */
    public function testPrepareParameters($params, $expected)
    {
        $result = $this->pdoConfig->prepareParameters($params);
        $this->assertEquals($expected, $result);
    }
    
    public function dataProviderPrepareParameters()
    {
        return array(
            array(
                array(
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                ),
                array(
                    'dsn' => 'mysql:host=localhost;port=3306;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                ),
            ),
            array(
                array(
                    'host' => '127.0.0.1',
                    'port' => null,
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                ),
                array(
                    'dsn' => 'mysql:host=127.0.0.1;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                ),
            ),
            array(
                array(
                    'unix_socket' => '/var/run/mysqld/mysqld.sock',
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                ),
                array(
                    'dsn' => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                ),
            ),
        );
    }
}
