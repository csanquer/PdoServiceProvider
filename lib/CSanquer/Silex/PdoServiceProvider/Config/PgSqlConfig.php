<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

/**
 * PgSqlConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class PgSqlConfig extends PdoConfig
{
    protected $driver = 'pgsql';
    
    protected $required = array(
        'host',
        'port',
        'dbname',
        'user',
        'password',
    );
    
    protected $defaults = array(
        'host' => 'localhost',
        'port' => 5432,
    );
    
    protected $allowedTypes = array(
        'host' => array('string', 'null'),
        'port' => array('integer', 'null'),
        'dbname' => array('string'),
        'user' => array('string'),
        'password' => array('string', 'null'),
    );  
}
