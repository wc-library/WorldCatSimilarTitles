<?php

namespace util;
class Misc {
    public static function objectToArray($obj) {
        if (is_object($obj)) {
            $obj = (array) $obj;
        }

        if (is_array($obj)) {
            $new = array();
            foreach ($obj as $k=>$v) {
                $new[$k] = self::objectToArray($v);
            }
        } else {
            $new = $obj;

        }
        return $new;
    }
}
