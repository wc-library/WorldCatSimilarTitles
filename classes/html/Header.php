<?php

namespace html;

class Header {
    protected $title = "";
    protected $includes = array();

	public function __construct(array $header_data) {
		$this->html = "<head lang=\"en\">\n<meta content=\"text/html; charset=UTF-8\">\n";

		if (!empty($header_data['title'])) {
			$this->html .= "<title>{$header_data['title']}</title>\n";
		}

		if (!empty($header_data['css'])) {
			$front = "<link type=\"text/css\" rel=\"stylesheet\" href=\"css/";
			$back = "\" />";
			$this->html .= $front.implode("$back\n$front",$header_data['css']).$back;
		}

		if (!empty($header_data['js'])) {
			$front = "<script type='text/javascript' src='js/";
			$back = "'></script>";
			$this->html .= $front.implode("$back\n$front",$header_data['js']).$back;
		}

		$this->html .= "\n</head>";
	}

    public function html() {
        return $this->html;
    }
}
