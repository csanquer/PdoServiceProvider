<?php

namespace CSanquer\Silex\PdoServiceProvider\Tests\Config;

use \Silex\Application;
use \CSanquer\Silex\PdoServiceProvider\Provider\MultiPDOServiceProvider;


/**
 * Unit tests for MultiPDOServiceProvider
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class MultiPDOServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerConnections
     */
    public function testConnections($prefix, $dbs, $default = null, $expectedDefault = null)
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }

        if (empty($prefix)) {
            $this->setExpectedException('InvalidArgumentException', 'The specified prefix is not valid.');
        }

        $app = new Application();
        $app->register(new MultiPDOServiceProvider($prefix), array(
            $prefix.'.dbs' => $dbs,
            $prefix.'.dbs.default' => $default,
        ));
        
        $this->assertEquals(array(
            'driver' => 'sqlite',
            'options' => array(),
        ), $app[$prefix.'.default_options']);

        $this->assertInstanceOf('\CSanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory', $app[$prefix.'.config_factory']);
        $this->assertInstanceOf('\Closure', $app[$prefix.'.pdo_factory']);

        /*$this->assertEquals('foo', $app[$prefix.'.dbs.default']);*/

        $this->assertCount(count($dbs), $app[$prefix]);

        foreach ($dbs as $db => $options) {
            $this->assertArrayHasKey($db, $app[$prefix]);
            $this->assertInstanceOf('\PDO', $app[$prefix][$db]);
        }

        if (count($dbs)) {
            $this->assertEquals($expectedDefault, $app[$prefix.'.dbs.default']);
            $this->assertInstanceOf('\PDO', $app[$prefix.'.default']);
            if ($expectedDefault) {
                $this->assertEquals($app[$prefix][$expectedDefault], $app[$prefix.'.default']);
            }
        } else {
            $this->assertNull($app[$prefix.'.dbs.default']);
            $this->assertNull($app[$prefix.'.default']);
        }
    }
    
    public function providerConnections() 
    {
        return array(
            array(
                null,
                array(),
            ),
            array(
                'pdo',
                array(),
            ),
            array(
                'pdo',
                array(
                    'db' => array(
                        'driver' => 'sqlite'
                    ),
                ),
                null,
                'db',
            ),
            array(
                'pdo',
                array(
                    'db1' => array(
                        'driver' => 'sqlite',
                        'path' => 'memory',
                    ),
                    'db2' => array(
                        'driver' => 'sqlite',
                    ),
                ),
                'db2',
                'db2',
            ),
        );
    }
}
