<?php

namespace html;

class Container {
    private $container;

    private $currNode = -1;
    private $rows = array();

    public function __construct($id='',$class='') {
        $this->container = "<div"
            . ($id?" id=\"$id\"":"")
            . " class=\"container $class\">";
    }

    public function row() {
        $this->currNode++;
        $this->rows[$this->currNode] = "";
        return $this;
    }

    public function column($data,$gridwidth) {
        $col = "<div class=\"col-md-$gridwidth\">$data</div>";
        $this->rows[$this->currNode] .= "<div class=\"col-md-$gridwidth\">$data</div>";
        return $this;
    }

    public function html() {
        if (count($this->rows)) {
            $this->container .=
  "<div class=\"row\">".implode("</div><div class=\"row\">",$this->rows)."</div>";
        }
        return "$this->container</div>";
    }
}
