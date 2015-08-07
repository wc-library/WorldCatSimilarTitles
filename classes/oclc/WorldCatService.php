<?php

namespace oclc;

class WorldCatService {

    public function lookup($idtype, $id, $includeRelated=true) {
        $request = \oclc\services\Catalog::genRequest($idtype, $id, array(
            'oclcsymbol'=>\util\Config::$library->oclcsymbol,
            'wskey' => \util\Config::$library->wskey,
            'servicelevel' => 'full',
            'format' => 'json',
            'frbrGrouping' => ($includeRelated)?'on':'off'
        ));
        $response = file_get_contents($request);
        $attr = array($idtype=>$id);
        $data = json_decode($response);
        return new \output\xml\Tree("query",$attr,$data);
    }
}
