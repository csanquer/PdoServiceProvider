<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\DBlibConfig;

/**
 * TestCase for DBlibConfig
 *
 * @author Cristian Pascottini <cristianp6@gmail.com>
 *
 */
class DBlibConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var DBlibConfig
     */
    protected $pdoConfig;

    public function setUp()
    {
        $this->pdoConfig = new DBlibConfig();
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
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                ),
                array(
                    'dsn' => 'dblib:host=localhost;port=1433;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
            array(
                array(
                    'host' => '127.0.0.1',
                    'port' => null,
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'attributes' => array(),
                ),
                array(
                    'dsn' => 'dblib:host=127.0.0.1;dbname=fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
        );
    }
}
