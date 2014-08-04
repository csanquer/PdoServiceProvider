<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

/**
 * OracleConfig
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class OracleConfig extends PdoConfig
{
    protected $driver = 'oci';

    protected $defaults = array(
        'host' => 'localhost',
        'port' => 1521,
        'service' => null,
        'charset' => null,
        'password' => null,
    );

    protected $allowedTypes = array(
        'host' => array('string'),
        'port' => array('integer', 'null'),
        'dbname' => array('string'),
        'user' => array('string'),
        'password' => array('string', 'null'),
        'service' => array('bool', 'null'),
        'charset' => array('string', 'null'),
    );

    protected function resolve(array $params)
    {
        $params = parent::resolve($params);

        if (isset($params['host']) && $params['host'] != null) {
            $dbname = '(DESCRIPTION=(ADDRESS_LIST=(ADDRESS=(PROTOCOL=TCP)' .
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
