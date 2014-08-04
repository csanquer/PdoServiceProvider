<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use \Silex\Application;
use \Csanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider;

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
    public function testConnection($prefix, $server = array(), $options = array(), $attributes = array(), $expectedServer = array(), $expectedOptions = array(), $expectedAttributes = array())
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }

        if (empty($prefix)) {
            $this->setExpectedException('InvalidArgumentException', 'The specified prefix is not valid.');
        }

        $app = new Application();
        $app->register(new PDOServiceProvider($prefix), array(
            $prefix.'.server' => $server,
            $prefix.'.options' => $options,
            $prefix.'.attributes' => $attributes,
        ));

        $this->assertInstanceOf('\PDO', $app[$prefix]);
        $this->assertEquals($expectedServer, $app[$prefix.'.server']);
        $this->assertEquals($expectedOptions, $app[$prefix.'.options']);
        $this->assertEquals($expectedAttributes, $app[$prefix.'.attributes']);
    }

    public function providerConnection()
    {
        return array(
            array(
                null,
            ),
            array(
                'pdo',
                array(),
                array(),
                array(),
                array('driver' => 'sqlite'),
            ),
            array(
                'foo',
                array('driver' => 'sqlite', 'path' => 'memory'),
                array(),
                array(
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ),
                array('driver' => 'sqlite', 'path' => 'memory'),
                array(),
                array(
                    \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
                ),
            ),
        );
    }
}
