<?php

namespace RestApi\Api\Models;

use Phalcon\Db;

class Users extends \Phalcon\Mvc\Model
{
    public $id;
    public $firstname;
    public $secondname;
    public $surname;
    
    public function FullText($find, $id, $limit)
    {
        $di = $this->getDI();
        $db = $di['db'];
    
        $where = "to_tsvector(firstname || ' ' || secondname || ' ' || surname) @@ to_tsquery('".$find."') AND id > $id";
        $limit = "LIMIT ".$limit;
        $query = $db->query("SELECT * FROM users WHERE ".$where.' ORDER BY id '.$limit);
        $query->setFetchMode(Db::FETCH_ASSOC);
    
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