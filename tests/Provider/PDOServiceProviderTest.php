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

    public function testRegistrationDoesNotOverwriteConfig()
    {
        $pdoMock = $this->getMock(
            '\\Csanquer\\Silex\\PdoServiceProvider\\Provider\\PDOServiceProvider',
            array('getPdo'),
            array('test_pdo')
        );
        $pdoMock->expects($this->once())->method('getPdo');
        $config = $this->getTestConfig();
        $app = new Application($config);
        $app->register($pdoMock);
        foreach ($config as $key => $value) {
            $this->assertSame($value, $app[$key]);
        }
    }

    protected function getTestConfig()
    {
        return array(
            'test_pdo.server'   => array(
                // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite, dblib
                'driver'   => 'mysql',
                'host'     => 'mock_host',
                'dbname'   => 'mock_db',
                'port'     => 3306,
                'user'     => 'mock_user',
                'password' => 'mock_password',
            ),
            // optional PDO attributes used in PDO constructor 4th argument driver_options
            // some PDO attributes can be used only as PDO driver_options
            // see http://www.php.net/manual/fr/pdo.construct.php
            'test_pdo.options' => array(
                \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
            ),
            // optional PDO attributes set with PDO::setAttribute
            // see http://www.php.net/manual/fr/pdo.setattribute.php
            'test_pdo.attributes' => array(
                \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            ),
        );
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
