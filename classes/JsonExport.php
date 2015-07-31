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
class JsonExport implements ExportInterface {
    public function getFrom($format, array $IDs) {
        return json_encode($IDs);
    }
}
