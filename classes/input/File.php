<?php

namespace input;

class File extends \input\AbstractCSV {

    public function getFormID() {
        return 'fileCSVInput';
    }

    public function formElement() {
        return "<label for='" . $this->getFormID() . "'>Import from file</label><br /><input type='file' id='" . $this->getFormID() . "' name='" . $this->getFormID() . "' />\n";
    }

    public function getString() {
        return $this->cleanCSVStr(file_get_contents($_FILES[$this->getFormID()]['name']));
    }

}
