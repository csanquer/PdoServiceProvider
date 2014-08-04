<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

/**
 * SqliteConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class SqliteConfig extends PdoConfig
{
    protected $driver = 'sqlite';

    protected $required = array(
        'path',
    );

    protected $defaults = array(
        'path' => 'memory',
    );

    protected $allowedTypes = array(
        'driver' => array('string'),
        'options' => array('array', 'null'),
        'path' => array('string', 'null'),
    );

    protected function constructDSN(array $params)
    {
        return $this->driver.':'.($params['path'] == 'memory' || empty($params['path'])? ':memory:' : $params['path']);
    }
}
