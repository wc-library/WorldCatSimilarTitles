<?php

namespace output;

class Html {
    public function display($title,$data) {
        $idtype = $_POST['idtype'];
        $results = $data['query'];
        $libinfo = $data['library'];

        $html_header = new \html\Header;
        $libTbl = new \html\Table;
        $resTbl = new \html\Table;

        $html_header
            ->title("WorldCat Similar Titles")
            ->css("normalize.css","bootstrap.min.css","bootstrap-theme.min.css")
            ->js('jquery.js','bootstrap.min.js');

        $libTbl->setClass("table table-condensed table-bordered")
            ->setCaption("library info")
            ->tr()
                ->td("<b>Institution Name</b>")
                ->td($libinfo['institutionName'])
            ->tr()
                ->td("<b>OCLC Symbol</b>")
                ->td($libinfo['oclcSymbol'])
            ->tr()
                ->td("<b>City</b>")
                ->td($libinfo['city'])
            ->tr()
                ->td("<b>State</b>")
                ->td($libinfo['state'])
            ->tr()
                ->td("<b>Country</b>")
                ->td($libinfo['country'])
            ->tr()
                ->td("<b>Postal Code</b>")
                ->td($libinfo['postalCode']);

        $resTbl->setClass('table table-bordered table-hover table-condensed')
            ->setCaption($title)
            ->thead()
            ->th("$idtype#")
            ->th("Title")
            ->th("Author")
            ->th("Publisher")
            ->th("Date")
            ->th("Related $idtype#s");

        foreach ($results as $query) {
            $id = $id = $query['id'];
            $rowcls = null;
            if ($query['url']) {
                $id = "<a href=\"{$query['url']}\" target=\"_blank\">$id</a>";
                $rowcls = "success";
            }
            $resTbl->tr($rowcls)
                ->td($id)
                ->td($query['title'])
                ->td($query['author'])
                ->td($query['publisher'])
                ->td($query['date'])
                ->td(\implode("&nbsp;<br>",$query['related']));
        }



        echo "<!DOCTYPE html>
            <html>
                {$html_header->html()}
                <body>
                    <div class=\"row\">
                        <div class=\"col-md-2\"></div>
                        <div class=\"col-md-6\">
                            {$libTbl->html()}
                        </div>
                        <div class=\"col-md-4\"></div>
                        </div>
                        <div class=\"row\">
                        <div class=\"col-md-2\"></div>
                        <div class=\"col-md-8\">
                            {$resTbl->html()}
                        </div>
                        <div class=\"col-md-2\"></div>
                    </div>
                </body>
                </html>";
    }
}
