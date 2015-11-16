<?php

namespace output;

class Xml {
    public function display($title,$data) {
        header("Content-type: text/xml");
        echo \util\Array2XML::createXML($title,$data)->saveXML();
    }
}
