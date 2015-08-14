<?php

namespace html;

class Panel {
    private $id="";
    private $class=null;
    private $html="";

    public function __construct($class='',$id='') {
        $this->class = $class?$class:"panel-default";
        if ($id) {
            $this->id=" id=\"$id\"";
        }
    }

    public function heading($html) {
        $this->html .= "<div class=\"panel-heading\">$html</div>";
        return $this;
    }

    public function body($html) {
        $this->html .= "<div class=\"panel-body\">$html</div>";
        return $this;
    }

    public function footer($html) {
        $this->html .= "<div class=\"panel-footer\">$html</div>";
        return $this;
    }

    public function addhtml($html) {
        $this->html .= $html;
        return $this;
    }

    public function html() {
        return "<div$this->id class=\"panel $this->class\">$this->html</div>";
    }
}
