<?php

namespace html;

final class Form {

    const EOF_LINE = "\n";
    private $_node_id = 0;
    private $_input = array();
    private $_class = "form-horizontal";

    private $_selectList = array();

    private $_action;
    private $_enctype;
    private $_name;

    public function __construct($name,$action,$encType ='multipart/form-data') {
        $this->_name = $name;
        $this->_action = $action;
        $this->_enctype = $encType;
    }

    public function setClass($class) {
        $this->_class = $class;
        return $this;
    }

    private function getNodeId() {
        return $this->_node_id;
    }

    private function setNodeId() {
        ++$this->_node_id;
    }

    public function select($name,$label,$required) {
        $this->setNodeId();
        $this->_selectList[] = $this->getNodeId();
        $this->_input[$this->getNodeId()] = "<div class=\"form-group\">
            <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>
            <div class=\"col-md-4\">
            <select id=\"$name\" name=\"$name\" class=\"form-control\""
            . (($required)?'required':'') . ">";
        return $this;
    }

    public function option($value,$txt) {
        $this->_input[$this->getNodeId()] .= "<option value=\"$value\">$txt</option>";
        return $this;
    }

    public function file($name,$label) {
        $this->setNodeId();
        $this->_input[$this->getNodeId()] = "<div class=\"form-group\">
            <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>
            <div class=\"col-md-4\">
              <input id=\"$name\" name=\"$name\" class=\"input-file\" type=\"file\">
            </div>
        </div>";
        return $this;
    }

    public function textarea($name,$label) {
        $this->setNodeId();
        $this->_input[$this->getNodeId()] = "<div class=\"form-group\">
            <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>
            <div class=\"col-md-4\">
              <textarea class=\"form-control\" id=\"$name\" name=\"$name\"></textarea>
            </div>
        </div>";
        return $this;
    }

    public function button($name,$label,$class) {
        $this->setNodeId();
        $this->_input[$this->getNodeId()] =
            "<div class=\"form-group\">
                <label class=\"col-md-4 control-label\" for=\"$name\"></label>
                <div class=\"col-md-4\">
                  <button id=\"$name\" name=\"$name\" class=\"$class\">$label</button>
                </div>
            </div>";

        return $this;
    }

    public function html() {
        $form = "<form class=\"$this->_class\" action=\"$this->_action\" method='post' enctype=\"$this->_enctype\">
            <legend>$this->_name</legend>";

        foreach ($this->_selectList as $id) {
            $this->_input[$id] .= "</select></div></div>";
        }

        foreach ($this->_input as $input) {
            $form .= $input;
        }

        return $form."</form>";
    }
}
