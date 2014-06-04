<?php

namespace CSanquer\Silex\PdoServiceProvider\Tests\Config;

use CSanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory;

/**
 * TestCase for PdoConfigFactoryTest
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class PdoConfigFactoryTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PdoConfigFactory
     */
    protected $factory;

    public function setUp()
    {
        $this->factory = new PdoConfigFactory();
    }

    /**
     * @dataProvider dataProviderCreateConfig
     */
    public function testCreateConfig($params, $expected)
    {
        $this->assertInstanceOf($expected, $this->factory->createConfig($params['driver']));
    }

    public function dataProviderCreateConfig()
    {
        return array(
            array(
                array(
                    'driver' => '',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\SqliteConfig',
            ),
            array(
                array(
                    'driver' => 'sqlite',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\SqliteConfig',
            ),
            array(
                array(
                    'driver' => 'mysql',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\MySqlConfig',
            ),
            array(
                array(
                    'driver' => 'pgsql',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\PgSqlConfig',
            ),
            array(
                array(
                    'driver' => 'postgre',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\PgSqlConfig',
            ),
            array(
                array(
                    'driver' => 'postgresql',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\PgSqlConfig',
            ),
            array(
                array(
                    'driver' => 'oci',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\OracleConfig',
            ),
            array(
                array(
                    'driver' => 'oracle',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\OracleConfig',
            ),
            array(
                array(
                    'driver' => 'sqlsrv',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'sqlserver',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'mssqlserver',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'mssql',
                ),
                '\CSanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
        );
    }
}
