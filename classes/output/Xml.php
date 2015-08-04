<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of XmlExport
 *
 * @author bgarcia
 */
namespace output;
class Xml extends \output\AbstractExporter {
    public function getFrom($format, array $data) {
        echo "<?xml version=\"1.0\" encoding=\"utf-8\"?>\n";
        echo "<root>";
        foreach ($data as $input => $outputs) {
            echo "\n\n<data $format='$input'>";
            foreach($outputs as $output) {
                echo "\n<similar $format='$output'>$output</similar>";
            }
            echo "\n</data>";
        }
        echo "\n</root>";
    }
}
