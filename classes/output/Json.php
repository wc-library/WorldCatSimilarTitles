<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of JsonExporter
 *
 * @author bgarcia
 */
namespace output;
class Json extends \output\AbstractExporter {
    public function getFrom($format, array $IDs) {
        return json_encode($IDs);
    }
}
