PdoServiceProvider [![Build Status](https://travis-ci.org/csanquer/PdoServiceProvider.png?branch=master)](https://travis-ci.org/csanquer/PdoServiceProvider) [![Project Status](http://stillmaintained.com/csanquer/PdoServiceProvider.png)](http://stillmaintained.com/csanquer/PdoServiceProvider)
==================

a PDO service provider for Silex

Installation
------------

add this package to Composer dependencies configuration:

```sh
php composer.phar require "csanquer/pdo-silex-provider"
```

Usage
-----

* Configure only one database

use the `PdoServiceProvider` silex provider :

```php
use CSanquer\Silex\PdoServiceProvider\Provider\PdoServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(
    // you can customize default services prefix with the provider first argument (default = 'pdo')
    new PdoServiceProvider('pdo'),
    array(
        'pdo.options' => array(
            // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'db1',
            'port' => '3306', 
            'username' => 'username',
            'password' => 'password',
            // optional PDO options
            'options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
            ),
        ),
    )
);

// get PDO connection
$pdo = $app['pdo'];
```

* Configure several databases

use `MultiPdoServiceProvider` silex provider instead of `PdoServiceProvider`:

```php
use CSanquer\Silex\PdoServiceProvider\Provider\MultiPdoServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(
    // you can customize default services prefix with the provider first argument (default = 'pdo')
    new MultiPdoServiceProvider(),
    array(
        // set default database (if not set, default is first )
        'pdo.dbs.default' => 'db1', 
        'pdo.dbs' => array(
            // first and default database
            'db1' => array(
                // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite
                'driver' => 'mysql',
                'host' => '127.0.0.1',
                'dbname' => 'db1',
                'port' => '3306', 
                'username' => 'username',
                'password' => 'password',
                // optional PDO options
                'options' => array(
                    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
                ),
            ),
            // a second database
            'db2' => array(
                'driver' => 'sqlite',
                'path' => 'var/db/db2.sqlite',
                'options' => array(
                ),
            ),
        ),
    )
);

// get PDO connections
$db1Pdo = $app['pdo']['db1'];
$db2Pdo = $app['pdo']['db2'];

// get default database
$db1Pdo = $app['pdo.default'];
```
