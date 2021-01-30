<?php

namespace Site;

use Phalcon\Loader;
use Phalcon\Mvc\View;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{

    /**
     * Registers the module auto-loader
     */
    public function registerAutoloaders(\Phalcon\DiInterface $dependencyInjector = null)
    {
    }

    /**
     * Registers the module-only services
     *
     * @param \Phalcon\DiInterface $di
     */
    public function registerServices($di)
    {

        /**
         * Read configuration
         */
        $config = include __DIR__ . "/../config/config.php";

        $di['config'] = $config;
        
        $di->set('view', function(){
            $view = new \Phalcon\Mvc\View();
            $view->setViewsDir(__DIR__.'/views/');
            return $view;
        });
        
    }

}
