<?php

namespace RestApi\Api\Controllers;

use RestApi\Api\Models\Users;

class IndexController extends RestController
{
    
    /**
     * @Get("/api/install")
     */
    public function installAction()
    {
        $maxcount = 1000;
        $firstnames  = [ "Александр", "Иван", "Максим", "Олег", "Марат", "Людмила", "Оксана" ];
        $secondnames = [ "Ткаченко", "Жуков", "Чкалов", "Путин", "Шамузинов", "Дахно", "Карась" ];
        $surnames    = [ "Александрович", "Иванович", "Максимович", "Олегович", "Маратович", "Евгеньевич", "Джонович" ];
        
        $Users = new Users();
        $count = $Users::count();
        
        $res = false;
        if ($count < $maxcount)
        {
            for ($next_item = $count; $next_item < $maxcount; $next_item++)
            {
                //заполним таблицу
                $rnd_f  = rand(0, 6);
                $rnd_s  = rand(0, 6);
                $rnd_ss = rand(0, 6);
                
                $Users             = new Users();
                $Users->firstname  = $firstnames[$rnd_f];
                $Users->secondname = $secondnames[$rnd_s];
                $Users->surname    = $surnames[$rnd_ss];
                $res               = $Users->save();
            }
        }
        
        return [ 'result' => $res ];
    }
    
    /**
     * @Get("/api/get/{id}")
     */
    public function getAction($id)
    {
        $result = [];
        $id     = $id ?? 0;
        if ($id > 0)
        {
            $Users  = new Users();
            $result = $Users::find([ "id = $id" ]);
        }
        else
        {
            $this->setStatusCode(404);
        }
        
        return $result;
    }
    
    /**
     * @Get("/api/list/{id}/{limit}")
     */
    public function listAction($id, $limit)
    {
        $result = [];
        $id     = $id ?? 0;
        $limit  = $limit ?? 1;
        if ($id > 0)
        {
            $Users  = new Users();
            $result = $Users::find([ "id >= $id", "limit" => $limit ]);
        }
        else
        {
            $this->setStatusCode(404);
        }
        
        return $result;
    }
    
    /**
     * @Get("/api/search/{find}/{id}/{limit}")
     */
    public function searchAction($find, $id, $limit)
    {
        $Users  = new Users();
        $result = $Users->FullText($find, $id, $limit);
        return $result;
    }
    
    
    private function saveUsers($json)
    {
        $result = false;
        if (isset($json["firstname"]) && isset($json["secondname"]) && isset($json["surname"]))
        {
            $User             = new Users();
            $User->firstname  = $json["firstname"];
            $User->secondname = $json["secondname"];
            $User->surname    = $json["surname"];
            
            if (isset($json["id"]))
            {
                $User->id = $json["id"];
                $result   = $User->update();
            }
            else
            {
                $result = $User->save();
            }
            
            if ($result)
            {
                $result = $User;
            }
        }
        
        return $result;
    }
    
    /**
     * @Post("/api/post")
     */
    public function postAction()
    {
        $result = [];
        
        $json_items = $this->request->getJsonRawBody(true);
        foreach ($json_items as $json)
        {
            unset($json["id"]);
            $UserInfo = $this->saveUsers($json);
            if ($UserInfo)
            {
                $this->setStatusCode(201);
                $result[] = $UserInfo;
            }
            else
            {
                $this->setStatusCode(404);
            }
        }
        
        return $result;
    }
    
    /**
     * @Put("/api/put")
     */
    public function putAction()
    {
        $result     = [];
        $json_items = $this->request->getJsonRawBody(true);
        foreach ($json_items as $json)
        {
            $id = $json["id"] ?? 0;
            if ($id > 0)
            {
                $UserInfo = $this->saveUsers($json);
                if ($UserInfo)
                {
                    $this->setStatusCode(201);
                }
                else
                {
                    $this->setStatusCode(404);
                }
            }
        }
        
        return $result;
    }
    
    /**
     * @Delete("/api/delete")
     */
    public function deleteAction()
    {
        $result     = [];
        $json_items = $this->request->getJsonRawBody(true);
        foreach ($json_items as $json)
        {
            $id = $json["id"] ?? 0;
            if ($id > 0)
            {
                $Users     = new Users();
                $Users->id = $id;
                $Users->delete();
                
                $this->setStatusCode(201);
            }
            else
            {
                $this->setStatusCode(404);
            }
        }
        
        return $result;
    }
}

