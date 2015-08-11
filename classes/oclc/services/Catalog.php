<?php

namespace oclc\services;

class Catalog {
    public static function batchQuery($idtype, array $idlist, array $params) {
        $idtype = ($idtype === "oclc")?"":$idtype;
        $BASEURL = "http://www.worldcat.org/webservices/catalog/content/libraries/$idtype";
        $PARAMS = \http_build_query($params);

        $requests = array();
        foreach ($idlist as $id) {
            $requests[$id] =  file_get_contents("$BASEURL/$id?$PARAMS");
        }

        return $requests;
    }
}
