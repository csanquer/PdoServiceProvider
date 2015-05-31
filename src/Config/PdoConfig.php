<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

use Symfony\Component\OptionsResolver\OptionsResolver;

/**
 * PdoConfig
 *
 * @abstract
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
abstract class PdoConfig implements PdoConfigInterface
{
    /**
     *
     * @var OptionsResolver
     */
    protected $resolver;

    /**
     *
     * @var array
     */
    protected $dsnParams;

    /**
     *
     * @var string
     */
    protected $user;

    /**
     *
     * @var string
     */
    protected $password;

    /**
     *
     * @var string
     */
    protected $driver;

    /**
     *
     * @var array
     */
    protected $required = array(
        'dbname',
        'user',
    );

    /**
     *
     * @var array
     */
    protected $defaults = array();

    /**
     *
     * @var array
     */
    protected $allowedValues = array();

    /**
     *
     * @var array
     */
    protected $allowedTypes = array();

    public function __construct()
    {
        $this->allowedTypes = array_merge(array(
            'driver' => array('string'),
            'options' => array('array', 'null'),
            'attributes' => array('array'),
        ), $this->allowedTypes);

        $this->allowedValues = array_merge(array(
            'driver' => array($this->driver),
        ), $this->allowedValues);

        $this->defaults = array_merge(array(
            'driver' => $this->driver,
            'options' => array(),
            'attributes' => array(),
        ), $this->defaults);

        $this->resolver = new OptionsResolver();
        $this->resolver
            ->setRequired($this->required)
            ->setDefaults($this->defaults);

        foreach($this->allowedValues as $option => $value) {
            $this->resolver->setAllowedValues($option, $value);
        }

        foreach($this->allowedTypes as $option => $value) {
            $this->resolver->setAllowedTypes($option, $value);
        }
    }

    /**
     *
     * @param  array  $params
     * @return string dsn
     */
    protected function constructDSN(array $params)
    {
        $driver = $params['driver'];
        unset($params['driver']);

        $dsnParams = array();
        foreach ($params as $key => $value) {
            if ($value != null && $value != '') {
                $dsnParams[] = $key.'='.$value;
            }
        }

        return $driver.':'.implode(';', $dsnParams);
    }

    /**
     *
     * @param array $params
     */
    protected function resolve(array $params)
    {
        return $this->resolver->resolve($params);
    }

    /**
     *
     * @param array $params
     */
    public function prepareParameters(array $params)
    {
        $params = $this->resolve($params);
        $preparedParams = array();

        if (isset($params['options'])) {
            $preparedParams['options'] = $params['options'];
            unset($params['options']);
        }

        if (isset($params['user'])) {
            $preparedParams['user'] = $params['user'];
            unset($params['user']);
        }

        if (isset($params['password'])) {
            $preparedParams['password'] = $params['password'];
            unset($params['password']);
        }

        if (isset($params['attributes'])) {
            $preparedParams['attributes'] = $params['attributes'];
            unset($params['attributes']);
        }

        $preparedParams['dsn'] = $this->constructDSN($params);

        return $preparedParams;
    }

    /**
     *
     * @param array $params
     *
     * @return \PDO
     */
    public function connect(array $params)
    {
        $params = $this->prepareParameters($params);

        $pdo = new \PDO(
            $params['dsn'],
            isset($params['user']) ? (string) $params['user'] : null,
            isset($params['password']) ? (string) $params['password'] : null,
            isset($params['options']) ? (array) $params['options'] : array()
        );

        if (is_array($params['attributes'])) {
            foreach ($params['attributes'] as $attr => $value) {
                $pdo->setAttribute($attr, $value);
            }
        }

        return $pdo;
    }
}
