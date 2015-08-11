<?php

namespace output;

class FormatFactory {
    public static function make($format) {
        if ($format === 'xml') {
            return new \output\Xml;
        }
    }
}
