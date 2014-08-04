<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig;

/**
 * TestCase for SqlSrvConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class SqlSrvConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SqlSrvConfig
     */
    protected $pdoConfig;

    public function setUp()
    {
        $this->pdoConfig = new SqlSrvConfig();
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
                    'dsn' => 'sqlsrv:port=1433;dbname=fake-db;server=localhost',
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
                    'attributes' => array(),
                ),
                array(
                    'dsn' => 'sqlsrv:dbname=fake-db;server=127.0.0.1',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
        );
    }
}
