<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ExportFactory
 *
 * @author bgarcia
 */
namespace output;
class Factory {
    public static function makeExporter($outputType) {
        switch ($outputType) {
            case 'json' : return new \output\Json;
            case 'xml' :  return new \output\Xml;
            default:      return null;
        }
    }
}
