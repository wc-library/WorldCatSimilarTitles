<?php

namespace oclc\services;

class Catalog {

    public static function genRequest($idtype, $id, array $params) {
        return "http://www.worldcat.org/webservices/catalog/content/libraries/"
            . "$idtype/$id?"
            . \http_build_query($params);
    }

}
