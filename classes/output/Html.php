<?php

namespace output;

class Html {
    public function display($title,$data) {
        $this->idtype = $_POST['idtype'];
        $this->results = $data['query'];
        $this->libinfo = $data['library'];

        $html_header = new \html\Header;
        $container = new \html\GridDiv('container');
            $infobox = new \html\Panel("panel-info");
            $libbox = new \html\Panel();
                $lib_tbl = new \html\Table();
            $resbox = new \html\Panel();
                $res_tbl = new \html\Table();

        $html_header
            ->title("WorldCat Similar Titles")
            ->css("normalize.css","bootstrap.min.css","bootstrap-theme.min.css")
            ->js('jquery.min.js','bootstrap.min.js');

        $lib_tbl->setClass("table table-condensed table-bordered")
            ->tr()
                ->td("<b>Institution Name</b>")
                ->td($this->libinfo['institutionName'])
            ->tr()
                ->td("<b>OCLC Symbol</b>")
                ->td($this->libinfo['oclcSymbol'])
            ->tr()
                ->td("<b>City</b>")
                ->td($this->libinfo['city'])
            ->tr()
                ->td("<b>State</b>")
                ->td($this->libinfo['state'])
            ->tr()
                ->td("<b>Country</b>")
                ->td($this->libinfo['country'])
            ->tr()
                ->td("<b>Postal Code</b>")
                ->td($this->libinfo['postalCode']);

        $res_tbl->setClass('table table-bordered table-hover table-condensed')
                ->thead()
                ->th("$this->idtype#")
                ->th("Title")
                ->th("Author")
                ->th("Publisher")
                ->th("Date")
                ->th("Related $this->idtype#s");

        foreach ($this->results as $query) {
            $id = $id = $query['id'];
            $rowcls = null;
            if ($query['url']) {
                $id = "<a href=\"{$query['url']}\" target=\"_blank\">$id</a>";
                $rowcls = "success";
            }
            $res_tbl->tr($rowcls)
                ->td($id)
                ->td($query['title'])
                ->td($query['author'])
                ->td($query['publisher'])
                ->td($query['date'])
                ->td(\implode("&nbsp;<br>",$query['related']));
        }

        $infobox
            ->heading('Info')
            ->body("Rows highlighted in green indicate that a catalog url was found for the configured library.");

        $libbox
            ->heading("Library")
            ->body($lib_tbl->html());

        $resbox
            ->heading($title)
            ->body($res_tbl->html());

        echo "<!DOCTYPE html>\n<html>\n",
            $html_header->html(),
            "<body>\n",
                $container
                    ->row()
                        ->column('',1)
                        ->column($libbox->html(),6)
                        ->column($infobox->html(),4)
                        ->column('',1)
                    ->row()
                        ->column('',1)
                        ->column($resbox->html(),10)
                        ->column('',1)
                    ->html(),
            "</body>\n</html>";
    }
}
