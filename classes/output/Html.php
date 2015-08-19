<?php

namespace output;

class Html {
    public function display($title,$data) {
        $idtype = $_POST['idtype'];
        $resultset = $data['query'];
        $library = $data['library'];
        $searchErrors = $data['errormsg'];

        $html_header = new \html\Header;
        $html_header
            ->title("WorldCat Similar Titles")
            ->css("style.css")
            ->js('jquery.min.js','bootstrap.min.js');

        $lib_panel = \html\TablePanel::fromArray("Library","library-panel",array(
            array("<b>Institution Name</b>",$library['institutionName']),
            array("<b>OCLC Symbol</b>",$library['oclcSymbol']),
            array("<b>City</b>",$library['city']),
            array("<b>State</b>",$library['state']),
            array("<b>Country</b>",$library['country']),
            array("<b>Postal Code</b>",$library['postalCode'])
        ));

        $info_panel = new \html\TextPanel('Info',"info-panel");
        $info_panel->setText("Rows highlighted in green indicate that a catalog url was found for the configured library.");

        $error_panel = new \html\TextPanel('Error','error-panel');
        $error_panel->setText($searchErrors);

        $res_panel = new \html\TablePanel($title,"results-panel");
        $res_panel->addheader(array("$idtype#","Title","Author","Publisher","Date","Related $idtype#s"));
        foreach ($resultset as $query) {
            $id = $query['id'];
            $rowcls = null;
            if ($query['url']) {
                $id = "<a href=\"{$query['url']}\" target=\"_blank\">$id</a>";
                $rowcls = "success";
            }
            $res_panel->addrow($rowcls,array(
                $id,
                $query['title'],
                $query['author'],
                $query['publisher'],
                $query['date'],
                \implode("&nbsp;<br>",$query['related'])
            ));
        }

        $breadcrumbs = \html\Breadcrumb::make(array(
            array('index.php','Index'),
            array('process.php','Results')
        ));

        $container = new \html\GridDiv('container-fluid');
        $container
            ->row()
                ->column('md-12',null,$breadcrumbs)
            ->row()
                ->column('md-12',null,$lib_panel->html())
            ->row();

        if ($searchErrors) {
            $container
                ->column('md-6',null,$info_panel->html())
                ->column('md-6',null,$error_panel->html());
        } else {
            $container->column('md-12',null,$info_panel->html());
        }
        $container->row()
                ->column('md-12',null,$res_panel->html());

        echo "<!DOCTYPE html>\n<html>\n",
            $html_header->html(),
            "<body>\n",
                $container->html(),
            "</body>\n</html>";
    }
}
