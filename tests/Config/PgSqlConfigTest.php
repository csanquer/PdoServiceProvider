<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\PgSqlConfig;

/**
 * TestCase for PgSqlConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class PgSqlConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PgSqlConfig
     */
    protected $pdoConfig;

    public function setUp()
    {
        $this->pdoConfig = new PgSqlConfig();
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
                    'dsn' => 'pgsql:host=localhost;port=5432;dbname=fake-db',
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
                    'dsn' => 'pgsql:host=127.0.0.1;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
        );
    }
}
