<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

/**
 * DBlibConfig
 *
 * @author Cristian Pascottini <cristianp6@gmail.com>
 */
class DBlibConfig extends PdoConfig
{
    protected $driver = 'dblib';

    protected $defaults = array(
        'host'      => 'localhost',
        'port'      => 1433,
        'MultipleActiveResultSets' => null,
        'password'  => null,
    );

    protected $allowedTypes = array(
        'host'      => array('string'),
        'port'      => array('integer', 'null'),
        'dbname'    => array('string'),
        'user'      => array('string'),
        'password'  => array('string', 'null'),
        'MultipleActiveResultSets' => array('boolean', 'null'),
    );

    protected function resolve(array $params)
    {
        $params = parent::resolve($params);

        if (is_null($params['MultipleActiveResultSets'])) {
            unset($params['MultipleActiveResultSets']);
        }

        return $params;
    }
}
