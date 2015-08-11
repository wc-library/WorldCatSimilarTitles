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

    public static function cleanCSV($str) {

        $list = explode(',', htmlspecialchars(
                preg_replace("/[\s-]+/", '', preg_replace("/[\n]+/", ',', $str)
        )));

        $n = count($list);
        for ($i = 0; $i < $n; ++$i) {
            if ($list[$i] == FALSE) {
                unset($list[$i]);
            } else {
                $list[$i] = intval(preg_replace('/,/', '', $list[$i]));
            }
        }
        return implode(',', array_unique($list, SORT_NUMERIC));
    }
}
