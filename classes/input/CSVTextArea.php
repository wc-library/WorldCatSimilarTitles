<?php

namespace input;

class CSVTextArea extends \input\AbstractCSV {

    protected $id    = 'idlist_textarea';
    protected $type  = 'textarea';
    protected $label = 'Enter one or more of the selected ID type, separated by commas or line breaks.';

    public function getval() {
        return $this->cleanstr($_POST[$this->id]);
    }

}
