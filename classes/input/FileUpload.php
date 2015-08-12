<?php

namespace input;

class FileUpload {
    protected $id;

    public function __construct($id) {
        $this->id = $id;
    }

    protected function failed() {
        $ok = isset($_FILES[$this->id]);

        return !$ok;
    }

    public function read() {
        $fname = $_FILES[$this->id]['tmp_name'];

        if ($this->failed()) {
            die();
        } else {
            return file_get_contents($fname);
        }
    }
}
