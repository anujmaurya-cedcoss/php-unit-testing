<?php
use Phalcon\Di\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\Application;
use Phalcon\Url;
use Phalcon\Db\Adapter\Pdo\Mysql;
use Phalcon\Config;
use Phalcon\Mvc\Dispatcher;

$config = new Config([]);

// Define some absolute path constants to aid in locating resources
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Register an autoloader
$loader = new Loader();

$loader->registerDirs(
    [
        APP_PATH . "/controllers/",
        APP_PATH . "/models/",
        APP_PATH . "/views/",
    ]
);
// make these namespaces
$loader->registerNamespaces(
    [
        'MyApp\Handlers' => APP_PATH . '/handlers/',
        'Login\Controllers' => APP_PATH . '/controllers/',
        'Signup\Controllers' => APP_PATH . '/controllers/',
        'Index\Controllers' => APP_PATH . '/controllers/',
        'MyApp\Models' => APP_PATH . '/models/',
        'Tests' => APP_PATH . '/../tests/',
    ]
);

$loader->register();

$container = new FactoryDefault();

$container->set(
    'view',
    function () {
        $view = new View();
        $view->setViewsDir(APP_PATH . '/views/');
        return $view;
    }
);

$container->set(
    'url',
    function () {
        $url = new Url();
        $url->setBaseUri('/');
        return $url;
    }
);

$application = new Application($container);

$container->set(
    'db',
    function () {
        return new Mysql(
            [
                'host' => 'mysql-server',
                'username' => 'root',
                'password' => 'secret',
                'dbname' => 'phalcon1',
            ]
        );
    }
);
// newly added
$container->set(
    'dispatcher',
    function () {
        $dispatcher = new Dispatcher();
        $dispatcher->setDefaultNamespace(
            'Index\Controllers',
        );
        // $dispatcher->setDefaultNamespace(
        //     'Login\Controllers',
        // );
        // $dispatcher->setDefaultNamespace(
        //     'Signup\Controllers',
        // );

        return $dispatcher;
    }
);


try {
    // Handle the request
    $response = $application->handle(
        $_SERVER["REQUEST_URI"]
    );

    $response->send();
} catch (\Exception $e) {
    echo 'Exception: ', $e->getMessage();
}