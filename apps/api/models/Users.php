<?php

namespace RestApi\Api\Models;

//CREATE TABLE `users` (
//  `id` int(12) unsigned NOT NULL AUTO_INCREMENT,
//  `firstname` varchar(70) NOT NULL,
//  `secondname` varchar(70) NOT NULL,
//  `surname` varchar(70) NOT NULL,
//  PRIMARY KEY (`id`)
//);

class Users extends \Phalcon\Mvc\Model
{
    public $id;
    public $firstname;
    public $secondname;
    public $surname;
    
    public function initialize()
    {
        $this->setConnectionService('db');
    }
    
//    public function notSaved()
//    {
//        // Obtain the flash service from the DI container
//        //$flash = $this->getDI()->getFlash();
//
//        $messages = $this->getMessages();
//
//        // Show validation messages
//        foreach ($messages as $message) {
//            var_dump($message);
//        }
//    }
}