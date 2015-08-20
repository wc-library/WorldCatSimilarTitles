<?php

namespace output;

class Html {

    protected function init_header() {
        $this->header = new \html\Header;
        $this->header
            ->title("WorldCat Similar Titles")
            ->css("style.min.css")
            ->js('jquery.min.js','bootstrap.min.js','results.js');
    }

    protected function init_breadcrumbs() {
        $this->breadcrumbs = \html\Breadcrumb::make(array(
            array('index.php','Index'),
            array('process.php','Results')
        ));
    }

    protected function init_panels($title,$data) {
        $idtype = $_POST['idtype'];
        $resultset = $data['query'];
        $library = $data['library'];
        $searchErrors = $data['errormsg'];

        $this->library_panel = \html\TablePanel::fromArray("Library","library-panel",array(
            array("<b>Institution Name</b>",$library['institutionName']),
            array("<b>OCLC Symbol</b>",$library['oclcSymbol']),
            array("<b>City</b>",$library['city']),
            array("<b>State</b>",$library['state']),
            array("<b>Country</b>",$library['country']),
            array("<b>Postal Code</b>",$library['postalCode'])
        ));;

        $this->info_panel = new \html\TextPanel('Info',"info-panel");
        $this->info_panel->setText("Rows highlighted in green indicate that a catalog url was found for the configured library.");

        $this->error_panel = null;
        if ($searchErrors) {
            $this->error_panel = new \html\TextPanel('Error','error-panel');
            $this->error_panel->setText($searchErrors);
        }

        $this->results_panel = new \html\TablePanel($title,"results-panel");
        $this->results_panel->addheader(array("$idtype#","Title","Author","Publisher","Date","Related $idtype#s"));
        foreach ($resultset as $query) {
            $id = $query['id'];
            $rowcls = null;
            if ($query['url']) {
                $id = "<a href=\"{$query['url']}\" target=\"_blank\">$id</a>";
                $rowcls = "success";
            }

            $recordhtml = "<tr class='$rowcls' data-toggle='modal' data-target='#lookup-modal'>"
                    ."<td>$id</td>"
                    ."<td>{$query['title']}</td>"
                    ."<td>{$query['author']}</td>"
                    ."<td>{$query['publisher']}</td>"
                    ."<td>{$query['date']}</td>"
                    ."<td>".\implode("&nbsp;<br>",$query['related'])."</td>"
                ."</tr>";
            $this->results_panel->addrow_raw($recordhtml);
        }
    }

    protected function init_modal($idtype) {
        $this->modal = new \html\AjaxModal($idtype,"lookup-modal", "Modal Title");
    }

    protected function init_scrolltotop() {
        $this->scrolltotop = "<a id='back-to-top' href='#' class='btn btn-primary btn-lg back-to-top' role='button' title='Click to return on the top page' data-toggle='tooltip' data-placement='left'><span class='glyphicon glyphicon-chevron-up'></span></a>";
    }

    public function display($title,$data) {
        $idtype = $_POST['idtype'];

        $this->init_header();
        $this->init_breadcrumbs();
        $this->init_panels($title, $data);
        $this->init_modal($idtype);
        $this->init_scrolltotop();

        $container = new \html\GridDiv('container-fluid');
        $container
            ->row()
                ->column('md-12',null,$this->breadcrumbs)
            ->row()
                ->column('md-12',null,$this->library_panel->html())
            ->row();

        if ($this->error_panel) {
            $container
                ->column('md-6',null,$this->info_panel->html())
                ->column('md-6',null,$this->error_panel->html());
        } else {
            $container->column('md-12',null,$this->info_panel->html());
        }
        $container->row()
                ->column('md-12',null,$this->results_panel->html());

        echo "<!DOCTYPE html>\n<html>\n",
            $this->header->html(),
            "<body>\n",
                $this->modal->html(),
                $container->html(),
                $this->scrolltotop,
            "</body>\n</html>";
    }
}
