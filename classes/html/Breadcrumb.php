<?php

namespace html;

class Breadcrumb {
    public function __construct(array $pages) {
        $this->html = "<ol class='breadcrumb'>";

		$i=0;
        $n = count($pages);
		foreach ($pages as $label=>$url) {
			if ($i==($n-1)) {
				$this->html .= "<li class='active'>$label</li>";
			} else {
				$this->html .= "<li><a href=\"$url\">$label</a></li>";
				++$i;
			}
		}
		
        $this->html.="</ol>";
    }

	public function html() {
		return $this->html;
	}
}
