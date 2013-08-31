<?php

namespace CSanquer\Silex\PdoServiceProvider\Tests\Config;


/**
 * TestCase for PDOServiceProvider
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class PDOServiceProviderTest extends \PHPUnit_Framework_TestCase
{

//    public function setUp()
//    {
//        $this->pdoConfig = new MySqlConfig();
//    }

    public function testDefault()
    {
        $app = new \Silex\Application();
        $app->register(new \CSanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider());
        
        $this->assertEquals(array(
            'driver' => 'sqlite',
            'options' => array(),
        ), $app['pdo.dbs.default_options']);
        $this->assertEmpty($app['pdo.dbs.options']);
        $this->assertNull($app['pdo.dbs.default']);
        $this->assertEmpty($app['pdo.dbs']);
        $this->assertNull($app['pdo']);
    }
    
    public function testSingleConnection()
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }
        
        $app = new \Silex\Application();
        $app->register(new \CSanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider());
        
        $app['pdo.dbs.options'] = array(
            'default' => array(
                'driver' => 'sqlite',
            ),
        );
        
        $this->assertInstanceOf('\Pimple',$app['pdo.dbs']);
        $this->assertEquals('default', $app['pdo.dbs.default']);
        $this->assertInstanceOf('\PDO', $app['pdo']);
    }
    
    public function testEmptyDbOptions()
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }
        
        $app = new \Silex\Application();
        $app->register(new \CSanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider());
        
        $app['pdo.dbs.options'] = array(
            'default' => array(
            ),
        );
        
        $this->assertInstanceOf('\Pimple',$app['pdo.dbs']);
        $this->assertEquals('default', $app['pdo.dbs.default']);
        $this->assertInstanceOf('\PDO', $app['pdo']);
    }
    
    public function testMultipleConnection()
    {
        if (!in_array('sqlite', \PDO::getAvailableDrivers())) {
            $this->markTestSkipped('pdo_sqlite is not available');
        }
        
        $app = new \Silex\Application();
        $app->register(new \CSanquer\Silex\PdoServiceProvider\Provider\PDOServiceProvider());
        
        $app['pdo.dbs.options'] = array(
            'master' => array(
                'driver' => 'sqlite',
            ),
            'slave' => array(
                'driver' => 'sqlite',
            ),
        );
        
        $master =  $app['pdo.dbs']['master'];
        $slave =  $app['pdo.dbs']['slave'];
        
        $this->assertInstanceOf('\Pimple', $app['pdo.dbs']);
        $this->assertInstanceOf('\PDO', $master);
        $this->assertInstanceOf('\PDO', $slave);
        $this->assertEquals('master', $app['pdo.dbs.default']);
        $this->assertEquals($master, $app['pdo']);
    }
}

/*
$app['pdo.dbs.default_options'] = array(
            'driver' => 'mysql',
            'options' => array(),
        );

        $app['pdo.dbs'] = $app->share(function ($app) {
            $factory = new \CSanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory();
            $dbs = new \Pimple();
            foreach ($app['pdo.dbs.options'] as $name => $params) {
                if (!isset($app['pdo.dbs.default'])) {
                    $app['pdo.dbs.default'] = $name;
                }
                
                if (empty($params)) {
                    $params = $app['pdo.dbs.default_options'];
                }
                
                $cfg = $factory->createConfig($params);
                $dbs[$name] = $cfg->connect($params);
            }
            
            return $dbs;
        });
        
        // shortcuts for the "first" DB
        $app['pdo'] = $app->share(function ($app) {
            $dbs = $app['pdo.dbs'];

            return $dbs[$app['pdo.dbs.default']];
        });
 * */