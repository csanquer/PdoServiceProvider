<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\MySqlConfig;

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
                    'attributes' => array(),
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
                    'attributes' => array(),
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
                    'attributes' => array(),
                ),
            ),
            array(
                array(
                    'unix_socket' => '/var/run/mysqld/mysqld.sock',
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'attributes' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                    ),
                ),
                array(
                    'dsn' => 'mysql:unix_socket=/var/run/mysqld/mysqld.sock;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(
                        \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                    ),
                ),
            ),
        );
    }
}
