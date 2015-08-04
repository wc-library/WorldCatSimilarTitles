<?php

namespace oclc\services;

class XID {

    public static function genRequest($idtype, $id, array $params) {
        return "http://x$idtype.worldcat.org/webservices/xid/"
            . "$idtype/$id?"
            . \http_build_query($params);
    }

}
