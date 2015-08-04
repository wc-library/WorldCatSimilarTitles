<?php

namespace oclc;

class WorldCatService {

    public function lookup($idtype, $id, $includeRelated=true) {
        $request = \oclc\services\Catalog::genRequest($idtype, $id, array(
                'servicelevel' => 'full',
                'format' => 'json',
                'frbrGrouping' => ($includeRelated)?'on':'off',
                'wskey' => \util\Config::$library->wskey
        ));

        $response = file_get_contents($request);

        $attr = array($idtype=>$id);
        $data = json_decode($response);
        $xmlTree = new \output\XmlTree("query",$attr,$data);
        return $xmlTree->asXml();
    }

    public function getEditions($idtype, $id) {
        $request = \oclc\services\XID::genRequest($idtype, $id, array(
            'method' => 'getEditions',
            'format' => 'xml',
            'fl' => $idtype
        ));

        $response = file_get_contents($request);
        return $response;
    }

}
