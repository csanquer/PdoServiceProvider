<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\SqliteConfig;

/**
 * TestCase for SqliteConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class SqliteConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var SqliteConfig
     */
    protected $pdoConfig;

    public function setUp()
    {
        $this->pdoConfig = new SqliteConfig();
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
                ),
                array(
                    'dsn' => 'sqlite::memory:',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
            array(
                array(
                    'path' => 'memory',
                ),
                array(
                    'dsn' => 'sqlite::memory:',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
            array(
                array(
                    'path' => 'var/db/db.sq3',
                ),
                array(
                    'dsn' => 'sqlite:var/db/db.sq3',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
        );
    }

    /**
     * @dataProvider dataProviderConnect
     */
    public function testConnect($params)
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }

        $pdo = $this->pdoConfig->connect($params);
        $this->assertInstanceOf('\PDO', $pdo);
    }

    public function dataProviderConnect()
    {
        return array(
            array(
                array(
                ),
            ),
        );
    }

}
