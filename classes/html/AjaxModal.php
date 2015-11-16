<?php

namespace html;

class AjaxModal {
    public function __construct($idtype,$id) {
        $this->idtype = $idtype;
        $this->id = $id;
    }

    public static function ajax_html() {
        $data = json_decode($_POST['jsonData'],true);

        $fnames = array("Title","Author","Publisher","Date","Related {$data['idtype']}#s");
        $fvals = array_values($data);

        $header = "";
        $row = "";

		$relatedIDs = explode(',',preg_replace("/[^0-9]+/",',',$fvals[5]));
        $n = count($relatedIDs);

        $urls = \oclc\WorldCatCatalogSearch::getLinks($data['idtype'],$relatedIDs);
        for ($i=0; $i<$n; ++$i) {
            $id = $relatedIDs[$i];
            if ($urls[$id] !== FALSE) {
                $relatedIDs[$i] = "<a href=\"{$urls[$id]}\" target=\"_blank\">$id</a>";
            }
        }
        $fvals[5] = implode("&nbsp;<br/>",$relatedIDs);

        for ($i=1; $i<6; $i++) {
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
        ."<h4 class='modal-title' id='$this->id-label'></h4>"
        ."</div>"

        ."<div class='modal-body'>"
        ."</div>"

        ."<div class='modal-footer'>"
        ."<button type='button' class='btn btn-default' data-dismiss='modal'>Close</button>"
        ."</div></div></div></div>";
    }
}
