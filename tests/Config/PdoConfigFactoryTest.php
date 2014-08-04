<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory;

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
                '\Csanquer\Silex\PdoServiceProvider\Config\SqliteConfig',
            ),
            array(
                array(
                    'driver' => 'sqlite',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\SqliteConfig',
            ),
            array(
                array(
                    'driver' => 'mysql',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\MySqlConfig',
            ),
            array(
                array(
                    'driver' => 'pgsql',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\PgSqlConfig',
            ),
            array(
                array(
                    'driver' => 'postgre',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\PgSqlConfig',
            ),
            array(
                array(
                    'driver' => 'postgresql',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\PgSqlConfig',
            ),
            array(
                array(
                    'driver' => 'oci',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\OracleConfig',
            ),
            array(
                array(
                    'driver' => 'oracle',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\OracleConfig',
            ),
            array(
                array(
                    'driver' => 'sqlsrv',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'sqlserver',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'mssqlserver',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'mssql',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\SqlSrvConfig',
            ),
            array(
                array(
                    'driver' => 'dblib',
                ),
                '\Csanquer\Silex\PdoServiceProvider\Config\DBlibConfig',
            ),
        );
    }
}
