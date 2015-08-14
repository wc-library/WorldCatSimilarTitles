<?php

namespace html;

class GridDiv {
    protected $html;

    private $currNode = -1;
    private $rows = array();
    private $rows_cls_data = array();

    public function __construct($class='',$id='') {
        $this->html = "<div"
            . ($id?" id=\"$id\"":"")
            . ($class?" class=\"$class\"":"") .">";
    }

    public function row($class='') {
        $this->currNode++;
        $this->rows[$this->currNode] = "";
        $this->rows_cls_data[$this->currNode] = $class;
        return $this;
    }

    public function column($data,$gridwidth=null,$class='') {
        $gridwidth = ($gridwidth)?"col-md-$gridwidth ":"";
        $class = ($gridwidth||$class)?" class=\"$gridwidth$class\"":'';

        $this->rows[$this->currNode] .= "<div$class>$data</div>";
        return $this;
    }

    protected function getRowHtml() {
        $html = "";
        foreach ($this->rows as $i=>$txt) {
            $row_cls = " ".$this->rows_cls_data[$i];
            $html .= "<div class=\"row$row_cls\">$txt</div>";
        }
        return $html;
    }

    public function html() {
        $this->html .= $this->getRowHtml();
        return "$this->html</div>";
    }
}
