<?php

namespace util;

class FileUpload {
    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }

    protected function checkForErrors() {
        $ok = isset($_FILES[$this->id])
            && $_FILES[$this->id]['tmp_name']!=="";
        return !$ok;
    }

    public function read() {
        if ($this->checkForErrors()) {
            return FALSE;
        }

        return file_get_contents(
            $_FILES[$this->id]['tmp_name']
        );
    }
}
