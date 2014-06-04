PdoServiceProvider
==================

[![Latest Stable Version](https://poser.pugx.org/csanquer/pdo-service-provider/v/stable.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Latest Unstable Version](https://poser.pugx.org/csanquer/pdo-service-provider/v/unstable.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Build Status](https://travis-ci.org/csanquer/PdoServiceProvider.png?branch=master)](https://travis-ci.org/csanquer/PdoServiceProvider)

[![Dependency Status](https://www.versioneye.com/user/projects/52fa225bec137599bb000033/badge.svg)](https://www.versioneye.com/user/projects/52fa225bec137599bb000033)
[![Project Status](http://stillmaintained.com/csanquer/PdoServiceProvider.png)](http://stillmaintained.com/csanquer/PdoServiceProvider)
[![License](https://poser.pugx.org/csanquer/pdo-service-provider/license.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)

[![Daily Downloads](https://poser.pugx.org/csanquer/pdo-service-provider/d/daily.png)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Monthly Downloads](https://poser.pugx.org/csanquer/pdo-service-provider/d/monthly.png)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Total Downloads](https://poser.pugx.org/csanquer/pdo-service-provider/downloads.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)


a Simple PDO service provider for Silex

Installation
------------

add this package to Composer dependencies configuration:

```sh
php composer.phar require "csanquer/pdo-silex-provider=~0.2"
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
    // you can customize services and options prefix with the provider first argument (default = 'pdo')
    new PdoServiceProvider('pdo'),
    array(
        'pdo.options' => array(
            // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'db1',
            'port' => 3306,
            'user' => 'username',
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

```php
use CSanquer\Silex\PdoServiceProvider\Provider\PdoServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(
    // use custom prefix for service and options
    // first PDO connection
    new PdoServiceProvider('pdo.db1'),
    array(
        // use previous custom prefix pdo.db1
        'pdo.db1.options' => array(
            // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite
            'driver' => 'mysql',
            'host' => '127.0.0.1',
            'dbname' => 'db1',
            'port' => 3306,
            'user' => 'username',
            'password' => 'password',
            // optional PDO options
            'options' => array(
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
            ),
        ),
    )
);

$app->register(
    // second PDO connection
    new PdoServiceProvider('pdo.db2'),
    array(
        'pdo.db2.options' => array(
                'driver' => 'sqlite',
                'path' => 'var/db/db2.sqlite',
                'options' => array(
                ),
            ),
        ),
    )
);

// get PDO connections
$db1Pdo = $app['pdo.db1'];
$db2Pdo = $app['pdo.db2'];
```
