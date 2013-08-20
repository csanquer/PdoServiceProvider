<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

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
        'path' => array('string', 'null'),
    ); 
    
    protected function constructDSN()
    {
        return $this->driver.':'.($this->dsnParams['path'] == 'memory' || empty($this->dsnParams['path'])? ':memory:' : $this->dsnParams['path']);
    }
}
