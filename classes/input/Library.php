<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Library
 *
 * @author bgarcia
 */
namespace input;
class Library {
    public function __construct($libraryName) {
        $data = parse_ini_file(BASE_DIR."/library/{$libraryName}.ini");
        foreach($data as $key => $value) {
            $this->{$key} = $value;
        }
    }
}
