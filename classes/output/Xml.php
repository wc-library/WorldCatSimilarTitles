<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace output;

/**
 * Description of Xml
 *
 * @author bgarcia
 */
class Xml {
    public function display($title,$data) {
        header("Content-type: text/xml");
        echo \util\Array2XML::createXML($title,$data)->saveXML();
    }
}
