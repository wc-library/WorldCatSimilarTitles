<?php

/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */
define('BASE_DIR', dirname(__FILE__));

function autoload($classname) {
    $filename = "classes/"
        . str_replace('\\', DIRECTORY_SEPARATOR, ltrim($classname, '\\'))
        . ".php";

    if ($filepath = stream_resolve_include_path($filename)) {
        require $filepath;
    }
    return $filepath !== false;
}

spl_autoload_register('autoload');

\util\Config::init();
