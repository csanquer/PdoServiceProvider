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
    public function testConnection($prefix, $options = array())
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
        
        $this->assertInternalType('array', $app[$prefix.'.options']);
        $this->assertInstanceOf('\PDO', $app[$prefix]);
    }
    
    public function providerConnection() 
    {
        return array(
            array(
                null,
            ),
            array(
                'pdo',
            ),
            array(
                'foo',
                array('driver' => 'sqlite', 'path' => 'memory'),
            ),
        );
    }
}
