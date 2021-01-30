<?php

use Phalcon\DI\FactoryDefault;
use Phalcon\Loader;
use Phalcon\Mvc\Application;
use Phalcon\Mvc\Url as UrlResolver;
use Phalcon\Session\Adapter\Files as SessionAdapter;

try
{
    
    $di = new FactoryDefault();
    
    /**
     * Registering a router
     */
    $di['router'] = function ()
    {
        $router = new \Phalcon\Mvc\Router\Annotations(false);
        $router->setDefaultModule("api");
        $router->setDefaultNamespace("RestApi\Api\Controllers");
        $router->notFound([ "controller" => "rest", "action" => "route404" ]);
        $router->addModuleResource("api", "RestApi\Api\Controllers\Index");
        $router->addModuleResource("site", "Site\Controllers\Index");
        return $router;
    };
    
    /**
     * The URL component is used to generate all kind of urls in the application
     */
    $di['url'] = function ()
    {
        $url = new UrlResolver();
        return $url;
    };
    
    /**
     * Start the session the first time some component request the session service
     */
    $di['session'] = function ()
    {
        $session = new SessionAdapter();
        $session->start();
        
        return $session;
    };
    
    
    $loader = new Loader();
    $loader->registerNamespaces([
        'RestApi\Api\Controllers' => __DIR__ . '/apps/api/controllers/',
        'RestApi\Api\Models'      => __DIR__ . '/apps/api/models/',
        'RestApi\Api\Services'    => __DIR__ . '/apps/api/services/',
        'Site\Controllers'        => __DIR__ . '/apps/site/controllers/',
    ]);
    $loader->registerDirs(array(
        __DIR__.'apps/site/controllers/',
    ))->register();
    $loader->register();
    
    
    $application = new Application($di);
    
    $API = false;
    $Url = $_SERVER["REQUEST_URI"];
    if (substr($Url,0,5) == "/api/") {
        $API = true;
        $application->useImplicitView(false);
    }

    
    /**
     * Handle the request
     */
    $application->registerModules([
        'api' => [
            'className' => 'RestApi\Api\Module',
            'path'      => __DIR__ . '/apps/api/Module.php',
        ],
        'site' => [
            'className' => 'Site\Module',
            'path'      => __DIR__ . '/apps/site/Module.php',
        ],
    ]);
    echo $application->handle()->getContent();
    
}
catch (Exception $e)
{
    echo $e->getMessage() . " " . $e->getTraceAsString();
}
