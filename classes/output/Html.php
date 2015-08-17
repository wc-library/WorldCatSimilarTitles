<?php

namespace output;

class Html {
    public function display($title,$data) {
        $this->idtype = $_POST['idtype'];
        $this->results = $data['query'];
        $this->libinfo = $data['library'];

        $html_header = new \html\Header;
        $html_header
            ->title("WorldCat Similar Titles")
            ->css("normalize.css","bootstrap.min.css","bootstrap-theme.min.css")
            ->css("style.css")
            ->js('jquery.min.js','bootstrap.min.js');

        $lib_tbl = new \html\Table("table table-bordered table-condensed");
        $lib_tbl
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

        $res_tbl = new \html\Table('table table-bordered table-hover table-condensed');
        $res_tbl
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
                ->td($query['date']);
            $res_tbl->td(\implode("&nbsp;<br>",$query['related']));
        }

        $info_panel = new \html\Panel("panel-info");
        $info_panel
            ->heading('Info')
            ->body("Rows highlighted in green indicate that a catalog url was found for the configured library.");

        $lib_panel = new \html\Panel("panel-info");
        $lib_panel
            ->heading("Library")
            ->table("<div class='table-responsive'>".$lib_tbl->html()."</div>");

        $res_panel = new \html\Panel("panel-primary");
        $res_panel
            ->heading($title)
            ->table("<div class='table-responsive'>".$res_tbl->html()."</div>");

        $container = new \html\GridDiv('container-fluid');
        $container
                ->row()
                    ->column('md-7',null,$lib_panel->html())
                    ->column('md-5',null,$info_panel->html())
                ->row()
                    ->column('md-12',null,$res_panel->html());

        echo "<!DOCTYPE html>\n<html>\n",
            $html_header->html(),
            "<body>\n",
                $container->html(),
            "</body>\n</html>";
    }
}
