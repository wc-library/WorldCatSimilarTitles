<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CSVInput
 *
 * @author bgarcia
 */
class CSVFileImport extends AbstractCSVImport {
    public function getFormID() {
        return 'fileCSVInput';
    }

    public function formElement() {
        return "<label for='".$this->getFormID()."'>Import from file</label><br /><input type='file' id='".$this->getFormID()."' name='".$this->getFormID()."' />\n";
    }

    public function getString() {
        return $this->cleanCSVStr(file_get_contents($_FILES[$this->getFormID()]['name']));
    }
}
