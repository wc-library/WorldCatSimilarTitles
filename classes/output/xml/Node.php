<?php

namespace output\xml;

class Node {
    public $tag;
    public $data;

    protected function __construct($tag,$attrStr,$data) {
        if (is_numeric($tag)) {
            $this->tag = 'node';
        } else {
            $this->tag = $tag;
        }
        $this->attr = $attrStr;
        $this->data = array();
        foreach ($data as $childTag => $childData) {
            $this->data[] = self::make($childTag,"",$childData);
        }
    }

    public static function make($tag,$attrStr,$data) {
        if(is_array($data) || is_object($data)) {
            return new Node($tag,$attrStr,$data);
        } else {
            return new Leaf($tag,$attrStr,$data);
        }
    }

    public function asXml() {
        if (count($this->data)==0) {
            return "";
        }

        $xml = "<$this->tag $this->attr>";
        foreach($this->data as $node) {
            $xml .= $node->asXml();
        }
        $xml .= "</$this->tag>";
        return $xml;
    }
}