<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

/**
 * MysqlConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class MySqlConfig extends PdoConfig
{
    protected $driver = 'mysql';
    
    protected $required = array(
        'host',
        'port',
        'dbname',
        'user',
        'password',
    );
    
    protected $defaults = array(
        'host' => 'localhost',
        'port' => 3306,
        'charset' => null,
        'unix_socket' => null,
    );
    
    protected $allowedTypes = array(
        'host' => array('string', 'null'),
        'port' => array('integer', 'null'),
        'dbname' => array('string'),
        'user' => array('string'),
        'password' => array('string', 'null'),
        'charset' => array('string', 'null'),
        'unix_socket' => array('string', 'null'),
    );
    
    protected function resolve(array $params)
    {
        $params = parent::resolve($params);
        
        if (!empty($params['unix_socket'])) {
            unset($params['host']);
            unset($params['port']);
        } else {
            unset($params['unix_socket']);
        }
        
        return $params;
    }
}
