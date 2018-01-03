PdoServiceProvider
==================

**LOOKING FOR NEW MAINTAINER**

[![Latest Stable Version](https://poser.pugx.org/csanquer/pdo-service-provider/v/stable.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Latest Unstable Version](https://poser.pugx.org/csanquer/pdo-service-provider/v/unstable.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Build Status](https://travis-ci.org/csanquer/PdoServiceProvider.png?branch=master)](https://travis-ci.org/csanquer/PdoServiceProvider)
[![Code Coverage](https://scrutinizer-ci.com/g/csanquer/PdoServiceProvider/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/csanquer/PdoServiceProvider/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/csanquer/PdoServiceProvider/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/csanquer/PdoServiceProvider/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/e29001fc-fd0c-4fb8-8995-592deb17c991/mini.png)](https://insight.sensiolabs.com/projects/e29001fc-fd0c-4fb8-8995-592deb17c991)

[![Maintenance](https://img.shields.io/maintenance/yes/2015.svg)]()
[![License](https://poser.pugx.org/csanquer/pdo-service-provider/license.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Daily Downloads](https://poser.pugx.org/csanquer/pdo-service-provider/d/daily.png)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Monthly Downloads](https://poser.pugx.org/csanquer/pdo-service-provider/d/monthly.png)](https://packagist.org/packages/csanquer/pdo-service-provider)
[![Total Downloads](https://poser.pugx.org/csanquer/pdo-service-provider/downloads.svg)](https://packagist.org/packages/csanquer/pdo-service-provider)


a Simple PDO service provider for Silex

Installation
------------

add this package to [Composer](https://getcomposer.org/) dependencies configuration:

```sh
php composer.phar require "csanquer/pdo-silex-provider=~1.0"
```

Usage
-----

* Configure only one database

use the `PdoServiceProvider` silex provider :

```php
use Csanquer\Silex\PdoServiceProvider\Provider\PdoServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(
    // you can customize services and options prefix with the provider first argument (default = 'pdo')
    new PdoServiceProvider('pdo'),
    array(
        'pdo.server'   => array(
            // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite, dblib
            'driver'   => 'mysql',
            'host'     => 'mysql',
            'dbname'   => 'rfactori',
            'port'     => 3306,
            'user'     => 'ger',
            'password' => 'GER',
        ),
        // optional PDO attributes used in PDO constructor 4th argument driver_options
        // some PDO attributes can be used only as PDO driver_options
        // see http://www.php.net/manual/fr/pdo.construct.php
        'pdo.options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ),
        // optional PDO attributes set with PDO::setAttribute
        // see http://www.php.net/manual/fr/pdo.setattribute.php
        'pdo.attributes' => array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ),
    )
);

// get PDO connection
$pdo = $app['pdo'];
```

* Configure several databases

```php
use Csanquer\Silex\PdoServiceProvider\Provider\PdoServiceProvider;
use Silex\Application;

$app = new Application();
$app->register(
    // use custom prefix for service and options
    // first PDO connection
    new PdoServiceProvider('pdo.db1'),
    array(
        // use previous custom prefix pdo.db1
        'pdo.db1.server' => array(
            // PDO driver to use among : mysql, pgsql , oracle, mssql, sqlite, dblib
            'driver'   => 'mysql',
            'host'     => '127.0.0.1',
            'dbname'   => 'db1',
            'port'     => 3306,
            'user'     => 'username',
            'password' => 'password',
        ),
        // optional PDO attributes used in PDO constructor 4th argument driver_options 
        'pdo.db1.options' => array(
            \PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES 'UTF8'"
        ),
        // optional PDO attributes set with PDO::setAttribute
        'pdo.db1.attributes' => array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
        ),
    )
);

$app->register(
    // second PDO connection
    new PdoServiceProvider('pdo.db2'),
    array(
        'pdo.db2.server' => array(
            'driver' => 'sqlite',
            'path' => 'var/db/db2.sqlite',
        ),
    )
);

// get PDO connections
$db1Pdo = $app['pdo.db1'];
$db2Pdo = $app['pdo.db2'];
```
