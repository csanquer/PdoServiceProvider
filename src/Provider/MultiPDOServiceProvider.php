<?php

namespace CSanquer\Silex\PdoServiceProvider\Provider;

use Silex\Application;

/**
 * Multiple Database PDO Provider.
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class MultiPDOServiceProvider extends PDOServiceProvider
{
    /**
     * @param Application $app
     * @param string      $prefix
     *
     * @return \PDO[]
     */
    protected function getProviderHandler(Application $app, $prefix)
    {
        return $app->share(function() use ($app, $prefix) {
            $connections = array();
            foreach ($app[$prefix.'.dbs'] as $db => $options) {
                if (empty($app[$prefix.'.dbs.default'])) {
                    $app[$prefix.'.dbs.default'] = $db;
                }

                $connections[$db] = $app[$prefix.'.pdo_factory']($options);
            }

            return $connections;
        });
    }

    protected function getDefaultPdo(Application $app, $prefix)
    {
        return $app->share(function() use ($app, $prefix) {
            $connections = $app[$prefix];

            return array_key_exists($app[$prefix.'.dbs.default'], $connections) ?
                $connections[$app[$prefix.'.dbs.default']] :
                null;
        });
    }

    public function register(Application $app)
    {
        if (empty($app[$this->prefix.'.dbs'])) {
                $app[$this->prefix.'.dbs'] = array();
        }

        if (empty($app[$this->prefix.'.dbs.default'])) {
            $app[$this->prefix.'.dbs.default'] = null;
        }

        parent::register($app);
    }

}
