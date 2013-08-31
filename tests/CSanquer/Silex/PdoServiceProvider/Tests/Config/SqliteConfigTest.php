<?php

namespace CSanquer\Silex\PdoServiceProvider\Tests\Config;

use CSanquer\Silex\PdoServiceProvider\Config\SqliteConfig;
use CSanquer\Silex\PdoServiceProvider\Config\PdoConfig;

/**
 * TestCase for SqliteConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class SqliteConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var PdoConfig
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
                ),
            ),
            array(
                array(
                    'path' => 'memory',
                ),
                array(
                    'dsn' => 'sqlite::memory:',
                ),
            ),
            array(
                array(
                    'path' => 'var/db/db.sq3',
                ),
                array(
                    'dsn' => 'sqlite:var/db/db.sq3',
                ),
            ),
        );
    }
}
