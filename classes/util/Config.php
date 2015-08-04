<?php

namespace util;

class Config {

    public static $library;

    public static function init() {
        $data = parse_ini_file(BASE_DIR . "/config.ini", true);
        self::$library = (object) $data['library'];
    }

}
