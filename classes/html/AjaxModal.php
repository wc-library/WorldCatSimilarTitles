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
 * Description of AjaxModal
 *
 * @author bgarcia
 */
class AjaxModal {
    public function __construct($idtype,$id,$title) {
        $this->idtype = $idtype;
        $this->id = $id;
        $this->title = $title;
    }

    public static function ajax_html() {
        $data = json_decode($_POST['jsonData'],true);
        ;

        $fnames = array("{$data['idtype']}#","Title","Author","Publisher","Date","Related {$data['idtype']}#s");
        $fvals = array_values($data);

        $header = "";
        $row = "";

        $fvals[6] = strtr($fvals[6],array("&nbsp;"=>",", " "=>""));
        $relatedIDs = explode(',',$fvals[6]);
        $n = count($relatedIDs);

        $worldcat = new \oclc\WorldCatService();
        $urls = $worldcat->ajaxGetRelatedLinks($data['idtype'],$relatedIDs);
        for ($i=0; $i<$n; ++$i) {
            $id = $relatedIDs[$i];
            if ($urls[$id] !== FALSE) {
                $relatedIDs[$i] = "<a href=\"{$urls[$id]}\" target=\"_blank\">$id</a>";
            }
        }
        $fvals[6] = implode("nbsp;<br/>",$relatedIDs);

        for ($i=1; $i<7; $i++) {
            $header .= "<th>{$fnames[$i-1]}</th>";
            $row .= "<td>{$fvals[$i]}</td>";
        }
        return "<div id='modal-data'><table><thead>$header</thead><tbody><tr>$row</tr></tbody></table></div>";
    }

    public function html() {
        return "<div class='modal fade' id='$this->id' data-idtype='$this->idtype' tabindex='-1' role='dialog' aria-labelledby='$this->id-label'>"
        ."<div class='modal-dialog'role='document'>"
        ."<div class='modal-content'>"
        ."<div class='modal-header'>"
        ."<button type=\"button\" class=\"close\" data-dismiss=\"modal\" aria-label=\"Close\"><span aria-hidden=\"true\">&times;</span></button>"
        ."<h4 class='modal-title' id='$this->id-label'>$this->title</h4>"
        ."</div>"

        ."<div class='modal-body'>"
        ."</div>"

        ."<div class='modal-footer'>"
        ."<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>"
        ."</div></div></div></div>";
    }
}
