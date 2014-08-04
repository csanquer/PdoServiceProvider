<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

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
    public function prepareParameters(array $params);

    /**
     *
     * @param array $params
     *
     * @return \PDO
     */
    public function connect(array $params);
}
