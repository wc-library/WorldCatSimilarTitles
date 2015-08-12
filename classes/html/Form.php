<?php

namespace html;

final class Form {

    const EOF_LINE = "\n";
    private $_node_id = 0;
    private $_input = array();
    private $_class = "form-horizontal";

    private $_prevSelect = FALSE;

    private $_errors = array();
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
        if ($this->getNodeId()===$this->_prevSelect['node']) {
            $this->_prevSelect = FALSE;
            $this->_input[$this->getNodeId()] .= "</select></div></div>";
        }
        ++$this->_node_id;
    }

    public function error($msg) {
        $this->_errors[] = $msg;
        return $this;
    }

    public function select($name,$label,$required) {
        $this->setNodeId();
        $this->_prevSelect = array('name'=>$name,'node'=>$this->getNodeId());
        $this->_input[$this->getNodeId()] = "<div class=\"form-group\">".self::EOF_LINE."
                <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>".self::EOF_LINE."
                <div class=\"col-md-4\">".self::EOF_LINE."
            <select id=\"$name\" name=\"$name\" class=\"form-control\""
            . (($required)?'required':'') . ">".self::EOF_LINE;
        return $this;
    }

    public function option($value,$txt) {
        $selected = "";
       if ( isset($_POST[$this->_prevSelect['name']])
           && $_POST[$this->_prevSelect['name']]===$value) {
           $selected = "selected";
           }

        $this->_input[$this->getNodeId()] .= "<option value=\"$value\" $selected>$txt</option>".self::EOF_LINE;
        return $this;
    }

    public function file($name,$label) {
        $this->setNodeId();
        $this->_input[$this->getNodeId()] = $this->inputBlock($name,$label,
            "<input class=\"input-file\"
                id=\"$name\" name=\"$name\"  type=\"file\">");
        return $this;
    }

    public function textarea($name,$label) {
        $this->setNodeId();
        $this->_input[$this->getNodeId()] = $this->inputBlock($name,$label,
            "<textarea class=\"form-control\"
                id=\"$name\" name=\"$name\"></textarea>");
        return $this;
    }

    public function button($name,$label,$class) {
        $this->setNodeId();
        $this->_input[$this->getNodeId()] =
            $this->inputBlock($name, "",
                "<button class=\"$class\"
                    id=\"$name\"
                    name=\"$name\">$label</button>");
        return $this;
    }

    public function html() {
        $form = "<form class=\"$this->_class\" action=\"$this->_action\" method='post' enctype=\"$this->_enctype\">
            <legend>$this->_name</legend>";
        if (count($this->_errors)>0) {
            foreach ($this->_errors as $msg) {
                $form .= "<div class='alert alert-danger' role='alert'>".self::EOF_LINE."
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>".self::EOF_LINE."
                        <strong>Error!</strong> $msg".self::EOF_LINE."
                    </div>".self::EOF_LINE;
            }
        } else {
            $form .= "<div class='row'></div>";
        }
        foreach ($this->_input as $input) {
            $form .= $input;
        }
        return $form."</form>";
    }

    public static function makeHiddenForm($id,$action,$params) {
        $form = "<form id='$id' action='$action' method='post'>".self::EOF_LINE;
        foreach ($params as $name=>$value) {
            $form .= "<input type=\"hidden\" name=\"$name\" value=\"$value\"></input>".self::EOF_LINE;
        }

        $form .= "<script type='text/javascript'>
            $(document).ready(function () {
                $('#$id').submit();
            });
            </script>";

        return $form;
    }

    private function inputBlock($name,$label,$inputString) {
        return "<div class=\"form-group\">".self::EOF_LINE."
                <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>".self::EOF_LINE."
                <div class=\"col-md-4\">".self::EOF_LINE."
                $inputString
                ".self::EOF_LINE."</div>".self::EOF_LINE."
                </div>";
    }
}
