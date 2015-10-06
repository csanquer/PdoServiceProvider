<?php

namespace Csanquer\Silex\PdoServiceProvider\Provider;

use Csanquer\Silex\PdoServiceProvider\Config\PdoConfigFactory;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

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
     * @param Container $app
     * @param string      $prefix
     *
     * @return \PDO
     */
    protected function getPdo(Container $app, $prefix)
    {
        return function () use ($app, $prefix) {
            $factory = new PdoConfigFactory();

            $app[$prefix.'.server']  = array_merge(
                array(
                    'driver' => 'sqlite',
                ),
                isset($app[$prefix.'.server']) ? (array) $app[$prefix.'.server'] : array()
            );

            $params = array_merge(
                $app[$prefix.'.server'],
                array(
                    'options' => isset($app[$prefix.'.options']) ? (array) $app[$prefix.'.options'] : array(),
                ),
                array(
                    'attributes' => isset($app[$prefix.'.attributes']) ? (array) $app[$prefix.'.attributes'] : array(),
                )
            );

            $cfg = $factory->createConfig($params['driver']);

            return $cfg->connect($params);
        };
    }

    /**
     * @param Container $app
     *
     */
    public function register(Container $app)
    {
        $prefix = $this->prefix;

        $app[$prefix.'.server'] = array();
        $app[$prefix.'.options'] = array();
        $app[$prefix.'.attributes'] = array();

        $app[$prefix] = $this->getPdo($app, $prefix);
    }
}
