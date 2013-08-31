<?php

namespace CSanquer\Silex\PdoServiceProvider\Config;

/**
 * PdoConfigFactory
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class PdoConfigFactory
{
    /**
     * 
     * @param array $params
     * 
     * @return PdoConfigInterface
     */
    public function createConfig(array $params) 
    {
        $driver = isset($params['driver']) ? $params['driver'] : null;
        switch ($driver) {
            case 'pgsql':
            case 'postgre':
            case 'postgresql':
                $params['driver'] = 'pgsql';
                $cfg = new PgSqlConfig();
                break;
            case 'oci':
            case 'oracle':
                $params['driver'] = 'oci';
                $cfg = new OracleConfig();
                break;
            case 'sqlsrv':
            case 'sqlserver':
            case 'mssqlserver':
            case 'mssql':
                $params['driver'] = 'sqlsrv';
                $cfg = new SqlSrvConfig();
                break;
            case 'mysql':
                $params['driver'] = 'mysql';
                $cfg = new MySqlConfig();
                break;
            case 'sqlite':
            default:
                $cfg = new SqliteConfig();
                break;
        }
        
        return $cfg;
    }
}
