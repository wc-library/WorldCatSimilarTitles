<?php

namespace util;

final class PHPProfiler {
    public static function installed() {
        return \util\Config::$xhgui->installed;
    }

    public static function run() {
        if (self::installed()) {
            include(\util\Config::$xhgui->header);
        } else {
            error_log("xhgui not installed/configured!!!");
        }
    }
}
