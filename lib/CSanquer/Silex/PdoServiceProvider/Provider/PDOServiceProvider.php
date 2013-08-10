<?php

namespace CSanquer\Silex\PdoServiceProvider\Provider;

use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Database PDO Provider.
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class PDOServiceProvider implements ServiceProviderInterface
{

    public function register(Application $app)
    {
        $app['pdo.dbs.default_options'] = array(
            'driver' => 'mysql',
            'dbname' => null,
            'host' => 'localhost',
            'port' => null,
            'user' => 'root',
            'password' => null,
        );

        $app['pdo.dbs.options.initializer'] = $app->protect(function () use ($app) {
            static $initialized = false;

            if ($initialized) {
                return;
            }

            $initialized = true;

            if (!isset($app['pdo.dbs.options'])) {
                $app['pdo.dbs.options'] = array('default' => isset($app['pdo.db.options']) ? $app['pdo.db.options'] : array());
            }

            $tmp = $app['pdo.dbs.options'];
            foreach ($tmp as $name => &$options) {
                $options = array_replace($app['pdo.dbs.default_options'], $options);

                switch ($options['driver']) {
                    case 'sqlite':
                        $options['name'] = empty($options['name']) ?  'memory' : $options['name'];
                        $options['dsn'] = $options['driver'].':'.($options['name'] == 'memory' ? ':'.$options['name'].':' : $options['name']);
                        break;
                    case 'postgre':
                        $options['port'] = empty($options['port']) ?  5432 : $options['port'];
                        $options['dsn'] = $options['driver'].':dbname='.$options['name'].';host='.$options['host'].';port='.$options['port'].';user='.$options['user'].';password='.$options['password'];
                        break;
                    case 'mysql':
                    default:
                        $options['port'] = empty($options['port']) ? 3306 : $options['port'];
                        $options['dsn'] = $options['driver'] . ':dbname=' . $options['name'] . ';host=' . $options['host'] . ';port=' .$options['port'];
                        break;
                };
                
                if (!isset($app['pdo.dbs.default'])) {
                    $app['pdo.dbs.default'] = $name;
                }
            }
            $app['pdo.dbs.options'] = $tmp;
        });
        
        
        $app['pdo.dbs'] = $app->share(function ($app) {
            $app['pdo.dbs.options.initializer']();
            $dbs = new \Pimple();
            foreach ($app['pdo.dbs.options'] as $name => $options) {
                switch ($options['driver']) {
                    case 'sqlite':
                    case 'postgre':
                        $dbs[$name] = new \PDO($options['dsn']);
                        break;
                    case 'mysql':
                    default:
                        $dbs[$name] = new \PDO($options['dsn'], $options['user'], $options['password']);
                        break;
                };
            }
            
            return $dbs;
        });
        
        // shortcuts for the "first" DB
        $app['pdo.db'] = $app->share(function ($app) {
            $dbs = $app['pdo.dbs'];

            return $dbs[$app['pdo.dbs.default']];
        });

        $app['pdo.db.options'] = $app->share(function ($app) {
            $dbs = $app['pdo.dbs.options'];

            return $dbs[$app['pdo.dbs.default']];
        });
    }

    public function boot(Application $app)
    {
        
    }

}
