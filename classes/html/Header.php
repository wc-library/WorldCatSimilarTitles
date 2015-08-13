<?php

namespace html;

class Header {
    protected $title = "";
    protected $includes = array();

    public function html() {
        return "<head lang=\"en\">\n"
        ."<meta content=\"text/html; charset=UTF-8\">\n"
        ."<title>$this->title</title>\n"
        . implode("\n",$this->includes)
        . "\n</head>";
    }

    public function css() {
        foreach (func_get_args() as $fname) {
            $this->includes[] = "<link type=\"text/css\" rel=\"stylesheet\" href=\"css/$fname\" />";
        }
        return $this;
    }

    public function js() {
        foreach (func_get_args() as $fname) {
            $this->includes[] = "<script type='text/javascript' src='js/$fname'></script>";
        }
        return $this;
    }

    public function title($title) {
        $this->title = htmlspecialchars($title);
        return $this;
    }
}
