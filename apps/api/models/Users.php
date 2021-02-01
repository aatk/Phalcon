<?php

namespace RestApi\Api\Models;

use Phalcon\Db;

class Users extends \Phalcon\Mvc\Model
{
    public $id;
    public $firstname;
    public $secondname;
    public $surname;
    
    public function FullText($find, $limit)
    {
        $di = $this->getDI();
        $db = $di['db'];
    
        $where = "to_tsvector(firstname || ' ' || secondname || ' ' || surname) @@ to_tsquery('".$find."')";
        $query = $db->query("SELECT * FROM users WHERE ".$where);
        $query->setFetchMode(Db::FETCH_NUM);
    
        $Users = [];
        while ($User = $query->fetch()) {
            $Users[] = $User;
        }
        
        return $Users;
    }
    
    public function initialize()
    {
        $this->setConnectionService('db');
    }
    
}