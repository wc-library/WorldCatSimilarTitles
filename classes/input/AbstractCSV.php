<?php

namespace input;

abstract class AbstractCSV {

    protected function cleanCSVStr($str) {

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

    public abstract function getFormID();

    public abstract function formElement();

    public abstract function getString();
}
