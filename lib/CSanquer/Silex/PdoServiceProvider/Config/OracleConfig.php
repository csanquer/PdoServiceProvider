<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

/**
 * OracleConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class OracleConfig extends PdoConfig
{
    protected $driver = 'oci';
    
    protected $required = array(
        'dbname',
        'user',
        'password',
    );
    
    protected $defaults = array(
        'host' => null,
        'port' => 1521,
        'service' => null,
    );
    
    protected $allowedTypes = array(
        'host' => array('string', 'null'),
        'port' => array('integer', 'null'),
        'dbname' => array('string'),
        'user' => array('string'),
        'password' => array('string', 'null'),
        'service' => array('boolean', 'null'),
        'charset' => array('string', 'null'),
    );    
    
    protected function resolve(array $params)
    {
        $params = parent::resolve($params);
        
        if (isset($params['host']) && $params['host'] != null) {
            $dbname .= '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)' .
                   '(HOST=' . $params['host'] . ')';

            if (isset($params['port'])) {
                $dbname .= '(PORT=' . $params['port'] . ')';
            } else {
                $dbname .= '(PORT=1521)';
            }

            if (isset($params['service']) && $params['service'] == true) {
                $dbname .= '))(CONNECT_DATA=(SERVICE_NAME=' . $params['dbname'] . ')))';
            } else {
                $dbname .= '))(CONNECT_DATA=(SID=' . $params['dbname'] . ')))';
            }
            
            $params['dbname'] = $dbname;
        }
        
        unset($params['host']);
        unset($params['port']);
        unset($params['service']);
        
        return $params;
    }
}
