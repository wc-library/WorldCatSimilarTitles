<?php

namespace html;

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
