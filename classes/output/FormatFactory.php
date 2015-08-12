<?php

namespace output;

class FormatFactory {
    public static function make($outputFormat) {
        if ($outputFormat === 'xml') {
            $f = new \output\Xml;
        } else if ($outputFormat === 'html') {
            $f = new \output\Html;
        }

        return $f;
    }
}
