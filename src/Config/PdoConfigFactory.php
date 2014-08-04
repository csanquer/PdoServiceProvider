<?php

namespace Csanquer\Silex\PdoServiceProvider\Config;

/**
 * PdoConfigFactory
 *
 * @author Charles Sanquer <charles.sanquer@gmail.com>
 */
class PdoConfigFactory
{
    /**
     *
     * @param string $driver
     *
     * @return PdoConfigInterface
     */
    public function createConfig($driver)
    {
        switch ($driver) {
            case 'pgsql':
            case 'postgre':
            case 'postgresql':
                $cfg = new PgSqlConfig();
                break;
            case 'oci':
            case 'oracle':
                $cfg = new OracleConfig();
                break;
            case 'dblib':
                $cfg = new DBlibConfig();
                break;
            case 'sqlsrv':
            case 'sqlserver':
            case 'mssqlserver':
            case 'mssql':
                $cfg = new SqlSrvConfig();
                break;
            case 'mysql':
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
