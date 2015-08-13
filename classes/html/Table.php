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
 *    - renamed setter methods
 *    - removed a lot of attribute setters that should be left in css
 */

namespace html;

final class Table {

      /**
       * Current node ID
       *
       * @var int $_node_id
       */
      private $_node_id = 0;

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
      public $class;

      /**
       * @var string $id
       */
      public $id;

      /**
       * @param string $id
       */
      public function  __construct($id = null) {
            // set table ID
            $this->id = $id;
      }

      /**
       * @param string $class
       */
      private function formatClass($class) {
            return $class ? " class=\"$class\"" : null;
      }

      /**
       * Current node ID getter
       *
       * @return int
       */
      private function _getNodeId() {
            // return node ID
            return $this->_node_id;
      }

      /**
       * Current node ID setter
       */
      private function _setNodeId() {
            // increment new node ID
            $this->_node_id++;
      }

      /**
       * @return string
       */
      private function _getTbody() {
            $html = null;

            // add tr(s)
            foreach($this->_tr as $tr) {
                  // add tr and close tr
                  $html .= "{$tr}</tr>\n";
            }

            return $html;
      }

      /**
       * @return string
       */
      private function _getThead() {
            $html = null;

            // add thead(s)
            foreach($this->_thead as $thead) {
                  // add thead and close thead
                  $html .= "{$thead}</thead>\n";
            }

            return $html;
      }

      private function _getCaption() {
          return "<caption>$this->_caption</caption>\n";
      }

      public function setClass($class) {
          $this->class = $class;
          return $this;
      }

      public function setCaption($text = null) {
          $this->_caption = $text;
          return $this;
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
            $this->_tr[$this->_getNodeId()] .= "<td{$this->formatClass($class)}>"
                  . "{$text}</td>\n";

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
            $this->_thead[$this->_getNodeId()] .= "<th{$this->formatClass($class)}>"
                  . "{$text}</th>\n";

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
            $this->_setNodeId();

            // add thead
            $this->_thead[$this->_getNodeId()] = "<thead{$this->formatClass($class)}>"
                  . PHP_EOL;

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
            $this->_setNodeId();

            // add tr
            $this->_tr[$this->_getNodeId()] = "<tr{$this->formatClass($class)}>"
                  . PHP_EOL;

            return $this;
      }

      /**
       * @return string
       */
      public function html() {
            // return table HTML
            return "<table "
                  // set ID if set, set class
                  . ( $this->id ? " id=\"{$this->id}\"" : null )
                  . $this->formatClass($this->class) . "\">" . PHP_EOL

                  // add table caption, thead and tbody
                  . $this->_getCaption() . $this->_getThead() . $this->_getTbody()

                  // add table HTML
                  . $this->_table

                  // close table
                  . "</table>\n";
      }
}