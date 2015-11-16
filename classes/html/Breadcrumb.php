<?php

/*
 * The MIT License
 *
 * Copyright 2015 bgarcia.
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace html;

/**
 * Description of Breadcrumb
 *
 * @author bgarcia
 */
class Breadcrumb {
    public function __construct(array $pages) {
        $this->html = "<ol class='breadcrumb'>";

		$i=0;
        $n = count($pages);
		foreach ($pages as $label=>$url) {
			$this->html .= "<li";
			if ($i==($n-1)) {
				$this->html .= " class='active'";
			}
			$this->html .= "><a href=\"$url\">$label</a></li>";
			++$i;
		}
		
        $this->html.="</ol>";
    }

	public function html() {
		return $this->html;
	}
}
