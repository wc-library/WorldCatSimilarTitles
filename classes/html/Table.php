<?php

namespace html;

final class Table {

    /**
     * @var array $_tr
     */
    private $rows;

    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $id
     */
    private $id;

    private $thead;

    /**
     * @param string $id
     */
    public function __construct($class=null,$id = null) {
        $this->class = $class?" class=\"$class\"":null;
        $this->id = $id?" id=\"$id\"":null;
    }

    public static function fromArray($class=null,$id=null,array $rows) {
        $tbl = new Table;
        $tbl->class = $class?" class=\"$class\"":null;
        $tbl->id = $id?" id=\"$id\"":null;

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
        // add thead
        $this->thead = "<thead>\n<th>".implode("</th><th>",$colnames)."</th>\n</thead>";
    }

    public function addrow($class,$data) {
        if ($class) {
            $this->rows .= "<tr class=\"$class\"><td>".implode("</td><td>",$data)."</td></tr>\n";
        } else {
            $this->rows .= "<tr><td>".implode("</td><td>",$data)."</td></tr>\n";
        }
        return $this;
    }

    public function quickInsertRows($rows) {
        foreach ($rows as $row) {
            $this->rows .= "<tr>";
            if (count($row)) {
                $this->rows .= "<td>".implode("</td><td>",$row)."</td>";
            }
            $this->rows .= "</tr>\n";
        }

        return $this;
    }

    /**
     * @return string
     */
    public function html() {
        // return table HTML
        return "<table$this->id$this->class>\n"
            .$this->thead."\n" // thead
            .$this->rows // tbody
            ."</table>\n";
    }

}
