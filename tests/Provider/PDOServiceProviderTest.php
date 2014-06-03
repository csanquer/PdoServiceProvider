<?php

namespace CSanquer\Silex\PdoServiceProvider\Tests\Config;

use \Silex\Application;
use \CSanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider;


/**
 * Unit tests for PDOServiceProvider
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class PDOServiceProviderTest extends \PHPUnit_Framework_TestCase
{

    /**
     * @dataProvider providerConnection
     */
    public function testConnection($prefix, $options)
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }

        if (empty($prefix)) {
            $this->setExpectedException('InvalidArgumentException', 'The specified prefix is not valid.');
        }

        $app = new Application();
        $app->register(new PDOServiceProvider($prefix), array(
            $prefix.'.options' => $options,
        ));
        
        $this->assertEquals(array(
            'driver' => 'sqlite',
            'options' => array(),
        ), $app[$prefix.'.default_options']);

        $this->assertEquals($options, $app[$prefix.'.options']);
        $this->assertInternalType('array', $app[$prefix.'.options']);
        $this->assertInstanceOf('\CSanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory', $app[$prefix.'.config_factory']);
        $this->assertInstanceOf('\Closure', $app[$prefix.'.pdo_factory']);
        $this->assertInstanceOf('\PDO', $app[$prefix]);
        $this->assertInstanceOf('\PDO', $app[$prefix.'.default']);
        $this->assertEquals($app[$prefix], $app[$prefix.'.default']);
    }
    
    public function providerConnection() 
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
                'foo',
                array('driver' => 'sqlite'),
            ),
        );
    }
}
