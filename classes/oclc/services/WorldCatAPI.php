<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace oclc\services;

/**
 * Description of WorldCatAPI
 *
 * @author bgarcia
 */
abstract class WorldCatAPI {

    protected $BASE_URL = "worldcat.org/webservices";

    public function __construct(\input\Library $lib) {
        $this->library = $lib;
    }

    protected function genRequest(array $params) {
        $id = $params['id'];
        $idType = $params['idType'];
        unset($params['id'],$params['idType']);
        return $this->genURL($idType)."/$id?" . \http_build_query($params);
    }

    protected abstract function genURL($idType);
}
