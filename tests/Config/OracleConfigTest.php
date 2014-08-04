<?php

namespace Csanquer\Silex\PdoServiceProvider\Tests\Config;

use Csanquer\Silex\PdoServiceProvider\Config\OracleConfig;

/**
 * TestCase for OracleConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 *
 */
class OracleConfigTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var OracleConfig
     */
    protected $pdoConfig;

    public function setUp()
    {
        $this->pdoConfig = new OracleConfig();
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
                    'dsn' => 'oci:dbname=(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=localhost)(PORT=1521)))(CONNECT_DATA=(SID=fake-db)))',
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
                ),
                array(
                    'dsn' => 'oci:dbname=(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=127.0.0.1)(PORT=1521)))(CONNECT_DATA=(SID=fake-db)))',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
            array(
                array(
                    'host' => '127.0.0.1',
                    'service' => true,
                    'port' => 1522,
                    'dbname' => 'fake-db',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                ),
                array(
                    'dsn' => 'oci:dbname=(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)(HOST=127.0.0.1)(PORT=1522)))(CONNECT_DATA=(SERVICE_NAME=fake-db)))',
                    'user' => 'fake-user',
                    'password' => 'fake-password',
                    'options' => array(),
                    'attributes' => array(),
                ),
            ),
        );
    }
}
