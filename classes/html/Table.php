<?php

/**
 * STable - Generate HTML Tables
 *
 * @package STable
 * @category STable
 * @name STable
 * @version 1.0
 * @author Shay Anderson 03.11
 *
 * modified by Brandon Garcia
 *    - renamed to 'Table' and placed in namespace
 *    - removed some comments to shorten file
 *    - added caption method
 *    - removed a lot of attribute setters that should be left in css
 *    - cleanup, performance tweaking
 */

namespace html;

final class Table {

    /**
     * Current node ID
     *
     * @var int $_node_id
     */
    private $node_id = 0;

    /**
     * @var string $_table
     */
    private $_table;

    /**
     * @var array $_thead
     */
    private $_thead = array();

    /**
     * @var array $_tr
     */
    private $_tr = array();

    /**
     * @var string $class
     */
    private $class;

    /**
     * @var string $id
     */
    private $id;

    private $caption = "";

    /**
     * @param string $id
     */
    public function __construct($class=null,$id = null) {
        $this->class = $class?" class=\"$class\"":null;
        $this->id = $id?" id=\"$id\"":null;
    }

    /**
     * @param string $class
     */
    private function formatClass($class) {
        return $class ? " class=\"$class\"" : null;
    }

    /**
     * Table td setter
     *
     * @param mixed $text
     * @param string $class
     * @return Table
     */
    public function td($text = null, $class = null) {
        // add td to current tr
        $this->_tr[$this->node_id] .= "<td{$this->formatClass($class)}>$text</td>\n";
        return $this;
    }

    /**
     * Table th setter
     *
     * @param mixed $text
     * @param string $class
     * @return Table
     */
    public function th($text = null, $class = null) {
        // add th to current thead
        $this->_thead[$this->node_id] .= "<th{$this->formatClass($class)}>$text</th>\n";

        return $this;
    }

    /**
     * Table thead setter
     *
     * @param string $class
     * @return Table
     */
    public function thead($class = null) {
        // set new node ID
        $this->node_id++;

        // add thead
        $this->_thead[$this->node_id] = "<thead{$this->formatClass($class)}>\n";

        return $this;
    }

    /**
     * Table tr setter
     *
     * @param string $class
     * @return Table
     */
    public function tr($class = null) {
        // set new node ID
        $this->node_id++;

        // add tr
        $this->_tr[$this->node_id] = "<tr{$this->formatClass($class)}>\n";

        return $this;
    }

    /**
     * @return string
     */
    public function html() {
        // return table HTML
        return "<table$this->id$this->class>\n"
            .implode("</thead>",$this->_thead)."</thead>\n" // thead
            .implode("</tr>\n",$this->_tr) . "</tr>\n" // tbody
            ."</table>\n";
    }

}
