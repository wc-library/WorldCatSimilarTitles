<?php

namespace html;

class Panel {
    protected $id="";
    protected $label="";
    protected $html = "";

    public function __construct($label,$id) {
        $this->label = "<div class=\"panel-heading\">$label</div>";
        $this->id=" id=\"$id\"";
    }

    public function html() {
        return "<div$this->id>$this->label$this->html</div>";
    }
}
