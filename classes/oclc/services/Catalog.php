<?php

namespace oclc\services;

class Catalog {
    public static function batchQuery($idtype, array $idlist, array $params) {
        if ($idtype === 'oclc') {
            $idtype = "";
        } else {
            $idtype = "/$idtype";
        }

        $BASEURL = "http://www.worldcat.org/webservices/catalog/content/libraries$idtype";
        $PARAMS = \http_build_query($params);

        $requests = array();
        foreach ($idlist as $id) {
            $requests[$id] =  "$BASEURL/$id?$PARAMS";
        }

        return \util\BatchRequest::make($requests)->exec();
    }
}
