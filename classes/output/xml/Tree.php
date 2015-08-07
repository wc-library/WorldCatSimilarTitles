<?php

namespace output\xml;

class Tree {
    public $root;
    public function __construct ($tag,$attributes,$data) {
        $attrStr = "";
        foreach($attributes as $prop=>$val) {
            $val = htmlspecialchars($val);
            $attrStr .= " $prop=\"$val\"";
        }

        if (!is_object($data) && !is_array($data)) {
            $data = array($data);
        }

        $this->root = Node::make($tag,$attrStr,$data);
    }

    public function asXml() {
        return $this->root->asXml();
    }
}
