<?php

namespace oclc\services;

class XID {
    public static function batchQuery($idtype, array $idlist, array $params) {
        $BASEURL = "http://x$idtype.worldcat.org/webservices/xid/$idtype";
        $PARAMS = \http_build_query($params);

        $requests = array();
        foreach ($idlist as $id) {
            $requests[$id] =  file_get_contents("$BASEURL/$id?$PARAMS");
        }

        return $requests;
    }

}
