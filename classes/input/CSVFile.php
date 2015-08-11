<?php

namespace input;

class CSVFile extends \input\AbstractCSV {

    protected $id    = 'idlist_file';
    protected $type  = 'file';
    protected $label = 'Import from file';

    public function getval() {
        return $this->cleanstr(file_get_contents($_FILES[$this->id]['name']));
    }

}
