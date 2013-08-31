<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

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
     * @var Symfony\Component\OptionsResolver\OptionsResolver 
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
        'host',
        'port',
        'dbname',
        'user',
        'password',
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
        $this->resolver = new OptionsResolver();
        $this->resolver
            ->setRequired($this->required)
            ->setDefaults($this->defaults)
            ->setAllowedValues($this->allowedValues)
            ->setAllowedTypes($this->allowedTypes);
    }

    /**
     * 
     * @param array $params
     * @return string dsn
     */
    protected function constructDSN(array $params)
    {
        $dsnParams = array();
        foreach ($params as $key => $value) {
            if ($value != null && $value != '') {
                $dsnParams[] = $key.'='.$value;
            }
        }
        return $this->driver.':'.implode(';', $dsnParams);
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
        
        if (isset($params['user'])) {
            $preparedParams['user'] = $params['user'];
            unset($params['user']);
        }
        
        if (isset($params['password'])) {
            $preparedParams['password'] = $params['password'];
            unset($params['password']);
        }
        
        $preparedParams['dsn'] = $this->constructDSN($params);
        return $preparedParams;
    }
    
    /**
     * 
     * @param array $params
     * @param array $options
     * 
     * @return \PDO
     */
    public function connect(array $params, array $options = array()) 
    {
        $params = $this->prepareParameters($params);
        return new \PDO($params['dsn'], $params['user'], $params['password'], $options);
    }
}
