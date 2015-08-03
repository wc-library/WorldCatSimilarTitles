<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of TextInput
 *
 * @author bgarcia
 */
namespace input;
class CSVTextInput extends AbstractCSVImport {
    public function getFormID() {
        return "textCSVInput";
    }

    public function formElement() {
        return "<label for='".$this->getFormID()."'>Enter one or more ISBN/ISSN inputs, separated by commas or line breaks.</label><br /><textarea id='".$this->getFormID()."' name='".$this->getFormID()."' rows='4' cols='50'></textarea>\n";
    }

    public function getString() {
        return $this->cleanCSVStr($_POST[$this->getFormID()]);
    }
}
