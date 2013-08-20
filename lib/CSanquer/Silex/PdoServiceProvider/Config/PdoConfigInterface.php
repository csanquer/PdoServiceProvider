<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

/**
 * PdoConfig Interface 
 * 
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
interface PdoConfigInterface
{
    /**
     * @param array $params
     * 
     * @return array
     */
    public function sanitize(array $params);
    
    /**
     * 
     * @param array $params
     * @param array $options
     * 
     * @return \PDO
     */
    public function connect(array $params, array $options = array());
}
