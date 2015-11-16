<?php

namespace html;

class TextPanel extends \html\Panel {
    public function setText($html) {
        $this->html .= "<div class=\"panel-body\">$html</div>";
        return $this;
    }
}
