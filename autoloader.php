<?php

/**
 * @author Brandon Garcia <brandon.garcia@my.wheaton.edu>
 */

spl_autoload_register(function ($class) {
    require_once "classes/$class.php";
});