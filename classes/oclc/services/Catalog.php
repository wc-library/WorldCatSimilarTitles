<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace oclc\services;

/**
 * Description of CatalogService
 *
 * @author bgarcia
 */
class Catalog extends WorldCatAPI {
    protected function genURL($idType) {
        return "http://www.$this->BASE_URL/catalog/content/libraries/$idType";
    }

    public function lookup($idType, $id) {
        $response = \file_get_contents($this->genRequest(array(
            'servicelevel'=>'full',
            'format'=>'xml',
            'frbrGrouping'=>'off',
            'maximumLibraries'=>1,
            'startLibrary'=>'1',
            'location'=>$this->library->location,
            'wskey'=>$this->library->wskey
        )));

        $xml = new \SimpleXMLElement($response);

        return $xml->{$idType};
    }
}
