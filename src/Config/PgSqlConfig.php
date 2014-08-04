<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

/**
 * PgSqlConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class PgSqlConfig extends PdoConfig
{
    protected $driver = 'pgsql';

    protected $defaults = array(
        'host' => 'localhost',
        'port' => 5432,
        'password' => null,
    );

    protected $allowedTypes = array(
        'host' => array('string'),
        'port' => array('integer', 'null'),
        'dbname' => array('string'),
        'user' => array('string'),
        'password' => array('string', 'null'),
    );
}
