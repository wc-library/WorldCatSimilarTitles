<?php

/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */

spl_autoload_register(function ($class) {
    $classpath = str_replace("\\","/",$class);
    require_once "classes/$classpath.php";
});