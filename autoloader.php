<?php

/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */

define('BASE_DIR', dirname(__FILE__));
function autoload($classname) {
    $filename = str_replace('\\',DIRECTORY_SEPARATOR,
        ltrim($classname, '\\'));
    $filename = "classes/$filename.php";

    if ($filepath = stream_resolve_include_path($filename)) {
        require $filepath;
    }
    return $filepath !== false;
}
spl_autoload_register('autoload');