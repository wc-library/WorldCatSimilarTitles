<?php

namespace input;

class Text extends \input\AbstractCSV {

    public function getFormID() {
        return "textCSVInput";
    }

    public function formElement() {
        return "<label for='" . $this->getFormID() . "'>Enter one or more ISBN/ISSN inputs, separated by commas or line breaks.</label><br /><textarea id='" . $this->getFormID() . "' name='" . $this->getFormID() . "' rows='4' cols='50'></textarea>\n";
    }

    public function getString() {
        return $this->cleanCSVStr($_POST[$this->getFormID()]);
    }

}
