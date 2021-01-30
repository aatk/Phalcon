<?php

namespace RestApi\Api;

use Phalcon\Mvc\ModuleDefinitionInterface;

//use Phalcon\Db\Adapter\Pdo\Postgresql as DbAdapter;
//use Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;


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
        
        /**
         * Database connection is created based in the parameters defined in the configuration file
         */
        
        if ($config->database->default == "mysql")
        {
            $di['db'] = function () use ($config)
            {
                return new \Phalcon\Db\Adapter\Pdo\Mysql([
                    "host"     => $config->database->mysql->host,
                    "username" => $config->database->mysql->username,
                    "password" => $config->database->mysql->password,
                    "dbname"   => $config->database->mysql->dbname,
                    "schema"   => $config->database->mysql->schema,
                ]);
            };
        }
        else
        {
            $di['db'] = function () use ($config)
            {
                return new \Phalcon\Db\Adapter\Pdo\Postgresql([
                    "host"     => $config->database->postgresql->host,
                    "username" => $config->database->postgresql->username,
                    "password" => $config->database->postgresql->password,
                    "dbname"   => $config->database->postgresql->dbname,
                    "schema"   => $config->database->postgresql->schema,
                    "port"     => $config->database->postgresql->port,
                ]);
            };
        }
        
    }
}
