<?php

namespace html;

class Header {
    protected $title = "";
    protected $includes = array();

    public function html() {
        return "<head lang=\"en\">
            <meta content=\"text/html; charset=UTF-8\">
        <title>$this->title</title>\n"
        . implode("\n",$this->includes)
        . "</head>";
    }

    public function css($fname) {
        $this->includes[] = "<link type=\"text/css\" rel=\"stylesheet\" href=\"css/$fname\" />";
        return $this;
    }

    public function js($fname) {
        $this->includes[] = "<script type='text/javascript' src='js/$fname'></script>";
        return $this;
    }

    public function title($title) {
        $this->title = htmlspecialchars($title);
        return $this;
    }
}
