<?php

namespace output\xml;

class Leaf extends Node {
    protected function __construct($tag,$attrStr,$data) {
        if (is_numeric($tag)) {
            $this->tag = 'leaf';
        } else {
            $this->tag = $tag;
        }
        $this->attr = $attrStr;
        $this->data = htmlspecialchars($data);
    }

    public function asXml() {
        if (trim($this->data)=='') {
            return "";
        }
        return "<$this->tag $this->attr>$this->data</$this->tag>";
    }
}