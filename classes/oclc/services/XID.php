<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace oclc\services;

/**
 * Description of XIDService
 *
 * @author bgarcia
 */
class XID extends \oclc\services\WorldCatAPI {

    public function getEditions($idType, $id) {
        $request = $this->genRequest(array(
            'id' => $id,
            'idType' => $idType,
            'method' => 'getEditions',
            'format' => 'xml',
            'fl' => $idType
        ));

        $response = file_get_contents($request);
        $xml = new \SimpleXMLElement($response);

        return $xml->{$idType};
    }

    protected function genURL($idType) {
        return "http://x$idType.$this->BASE_URL/xid/$idType";
    }
}
