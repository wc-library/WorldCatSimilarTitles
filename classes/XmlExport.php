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
class XmlExport implements ExportInterface {
    public function getFrom($format, array $data) {
        echo '<?xml version="1.0" encoding="utf-8"?>';
        echo '<root>';
        foreach ($data as $input => $outputs) {
            echo "<input $format=$input>";
            foreach($outputs as $output) {
                echo "<similar $format=$output>$output</similar>";
            }
            echo "</input>";
        }
        echo '</root>';
    }
}
