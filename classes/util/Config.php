<?php

namespace util;

class Config {

    public static $library;
    public static $xhgui;

    public static function init() {
        $data = parse_ini_file(BASE_DIR . "/config.ini", true);
        self::$library = (object) $data['library'];

        if (isset($data['xhgui'])) {
            self::$xhgui = (object) $data['xhgui'];
        } else {
            self::$xhgui = new \stdClass;
        }

        if (!isset(self::$xhgui->installed)) {
            self::$xhgui->installed = false;
        }
    }

}
