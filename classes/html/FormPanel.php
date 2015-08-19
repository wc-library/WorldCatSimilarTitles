<?php

namespace html;

final class FormPanel extends \html\Panel{

    private $node_id = 0;
    private $inputs = array();
    private $class;

    private $prevSelect = FALSE;

    private $errors = array();
    private $action;
    private $enctype;

    public function __construct($label,$id,$gridwidth,$class,$action,$encType ='multipart/form-data') {
        parent::__construct($label, $id);
        $this->class = "col-$gridwidth $class";
        $this->action = $action;
        $this->enctype = $encType;
    }

    private function setNodeId() {
        if ($this->node_id===$this->prevSelect['node']) {
            $this->prevSelect = FALSE;
            $this->inputs[$this->node_id] .= "</select></div></div>";
        }
        ++$this->node_id;
    }

    public function error($msg) {
        $this->errors[] = $msg;
        return $this;
    }

    public function select($name,$label,$required) {
        $this->setNodeId();
        $this->prevSelect = array('name'=>$name,'node'=>$this->node_id);
        $this->inputs[$this->node_id] = "<div class=\"form-group\">\n
                <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>\n
                <div class=\"col-md-4\">\n
            <select id=\"$name\" name=\"$name\" class=\"form-control\""
            . (($required)?'required':'') . ">\n";
        return $this;
    }

    public function option($value,$txt) {
        $selected = "";
       if ( isset($_POST[$this->prevSelect['name']])
           && $_POST[$this->prevSelect['name']]===$value) {
           $selected = "selected";
           }

        $this->inputs[$this->node_id] .= "<option value=\"$value\" $selected>$txt</option>\n";
        return $this;
    }

    public function file($name,$label) {
        $this->setNodeId();
        $this->inputs[$this->node_id] = $this->inputBlock($name,$label,
            "<input class=\"input-file\"
                id=\"$name\" name=\"$name\"  type=\"file\">");
        return $this;
    }

    public function textarea($name,$label) {
        $this->setNodeId();
        $this->inputs[$this->node_id] = $this->inputBlock($name,$label,
            "<textarea class=\"form-control\"
                id=\"$name\" name=\"$name\"></textarea>");
        return $this;
    }

    public function button($name,$label,$class) {
        $this->setNodeId();
        $this->inputs[$this->node_id] =
            $this->inputBlock($name, "",
                "<button class=\"$class\"
                    id=\"$name\"
                    name=\"$name\">$label</button>");
        return $this;
    }

    public function html() {
        $this->html .= "<div$this->id>$this->label<div class=\"panel-body\"><form class=\"$this->class\" action=\"$this->action\" method='post' enctype=\"$this->enctype\">";
        if (count($this->errors)>0) {
            foreach ($this->errors as $msg) {
                $this->html .= "<div class='alert alert-danger' role='alert'>\n
                    <a href='#' class='close' data-dismiss='alert' aria-label='close'>&times;</a>\n
                        <strong>Error!</strong> $msg\n
                    </div>\n";
            }
        } else {
            $this->html .= "<div class='row'></div>";
        }
        foreach ($this->inputs as $input) {
            $this->html .= $input;
        }
        return $this->html."</form></div></div>";
    }

    public static function makeHiddenForm($id,$action,$params) {
        $form = "<form id='$id' action='$action' method='post'>\n";
        foreach ($params as $name=>$value) {
            $form .= "<input type=\"hidden\" name=\"$name\" value=\"$value\"></input>\n";
        }

        $form .= "<script type='text/javascript'>
            $(document).ready(function () {
                $('#$id').submit();
            });
            </script>";

        return $form;
    }

    private function inputBlock($name,$label,$inputString) {
        return "<div class=\"form-group\">\n
                <label class=\"col-md-4 control-label\" for=\"$name\">$label</label>\n
                <div class=\"col-md-4\">\n
                $inputString
                \n</div>\n
                </div>";
    }
}
