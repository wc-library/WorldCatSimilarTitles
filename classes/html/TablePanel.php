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
 * Description of TablePanel
 *
 * @author bgarcia
 */
class TablePanel extends \html\Panel {

    protected $thead = "";
    protected $rows = "";

    public static function fromArray($label,$id,array $rows) {
        $tbl = new TablePanel($label,$id);

        foreach ($rows as $row) {
            $tbl->rows .= "<tr>";
            if (count($row)) {
                $tbl->rows .= "<td>".implode("</td><td>",$row)."</td>";
            }
            $tbl->rows .= "</tr>\n";
        }

        return $tbl;
    }

    public function addheader($colnames) {
        $this->thead .= "<thead>\n<th>".implode("</th><th>",$colnames)."</th>\n</thead>";
        return $this;
    }

    public function addrows($rows) {
        foreach ($rows as $row) {
            $this->rows .= "<tr>";
            if (count($row)) {
                $this->rows .= "<td>".implode("</td><td>",$row)."</td>";
            }
            $this->rows .= "</tr>\n";
        }
        return $this;
    }

    public function addrow($rowcls, $row) {
        if ($rowcls) {
            $this->rows .= "<tr class=\"$rowcls\"><td>".implode("</td><td>",$row)."</td></tr>\n";
        } else {
            $this->rows .= "<tr><td>".implode("</td><td>",$row)."</td></tr>\n";
        }
        return $this;
    }

    public function addrow_raw($html) {
        $this->rows .= $html;
        return $this;
    }

    public function html() {
        return "<div$this->id>$this->label<div class='table-responsive'><table>$this->thead$this->rows</table></div></div>";
    }
}
