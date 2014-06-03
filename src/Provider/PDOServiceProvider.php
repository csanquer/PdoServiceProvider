<?php

namespace CSanquer\Silex\PdoServiceProvider\Provider;

use CSanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory;
use Silex\Application;
use Silex\ServiceProviderInterface;

/**
 * Database PDO Provider.
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class PDOServiceProvider implements ServiceProviderInterface
{
    /**
     * @param string $prefix
     */
    protected $prefix;

    /**
     * @param string $prefix Prefix name used to register the service provider in Silex.
     */
    public function __construct($prefix = 'pdo')
    {
        if (empty($prefix)) {
            throw new \InvalidArgumentException('The specified prefix is not valid.');
        }

        $this->prefix = $prefix;
    }

    /**
     * @param Application $app
     * @param string      $prefix
     *
     * @return \PDO
     */
    protected function getPdoFactory(Application $app, $prefix)
    {
        return $app->protect(function($options) use ($app, $prefix) {
            $factory = $app[$prefix.'.config_factory'];

            $options = array_replace($app[$prefix.'.default_options'], is_array($options) ? $options : (array) $options);
            $cfg = $factory->createConfig($options);

            return $cfg->connect($options);
        });
    }

    /**
     * @param Application $app
     * @param string      $prefix
     *
     * @return \PDO
     */
    protected function getProviderHandler(Application $app, $prefix)
    {
        return $app->share(function() use ($app, $prefix) {
            if (empty($app[$prefix.'.options'])) {
                $app[$prefix.'.options'] = array();
            }

            return $app[$prefix.'.pdo_factory']($app[$prefix.'.options']);
        });
    }

    protected function getDefaultPdo(Application $app, $prefix)
    {
        return $app->share(function() use ($app, $prefix) {
            return $app[$prefix];
        });
    }

    public function register(Application $app)
    {
        $prefix = $this->prefix;

        $app[$prefix.'.default_options'] = array(
            'driver' => 'sqlite',
            'options' => array(),
        );

        $app[$prefix.'.config_factory'] = $app->share(function() {
            return new PdoConfigFactory();
        });

        $app[$prefix.'.pdo_factory'] = $this->getPdoFactory($app, $prefix);

        $app[$prefix] = $this->getProviderHandler($app, $prefix);
        $app[$prefix.'.default'] = $this->getDefaultPdo($app, $prefix);
    }

    public function boot(Application $app)
    {

    }
}
