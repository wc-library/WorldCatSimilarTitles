<?php

namespace output;

class Html {

    public function display($title,$data) {
        $idtype = $_POST['idtype'];

        // initialize header
		$this->header = new \html\Header(array(
            'title'=>"WorldCat Similar Titles",
            'css'=>array("style.min.css"),
            'js'=>array('jquery.min.js','bootstrap.min.js','results.js')
		));

		// initialize breadcrumbs
        $this->breadcrumbs = new \html\Breadcrumb(array(
            'Index'=>'index.php',
			'Results'=>'process.php'
        ));

		// initialize library panel
		$this->library_panel = \html\TablePanel::fromArray("Library","library-panel",array(
            array("<b>Institution Name</b>",\util\Config::$library->name),
            array("<b>OCLC Symbol</b>",\util\Config::$library->oclcsymbol),
            array("<b>City</b>",$data['library']['city']),
            array("<b>State</b>",$data['library']['state']),
            array("<b>Country</b>",$data['library']['country']),
            array("<b>Postal Code</b>",$data['library']['postalCode'])
        ));

		// initialize info panel
        $this->info_panel = new \html\TextPanel('Info',"info-panel");
        $this->info_panel->setText("Rows highlighted in green indicate that a catalog url was found for the configured library.");

		// initialize error panel
        $this->error_panel = null;
        if ($data['errormsg']) {
            $this->error_panel = new \html\TextPanel('Error','error-panel');
            $this->error_panel->setText($data['errormsg']);
        }

		// initialize results panel
        $this->results_panel = new \html\TablePanel($title,"results-panel");
        $this->results_panel->addheader(array("$idtype#","Title","Author","Publisher","Date","Related $idtype#s"));
        foreach ($data['query'] as $query) {
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
                    ."<td>".\implode("&nbsp;<br/>",$query['related'])."</td>"
                ."</tr>";
            $this->results_panel->addrow_raw($recordhtml);
        }

		// initialize modal
        $this->modal = new \html\AjaxModal($idtype,"lookup-modal", "Modal Title");

		// initialize scrolltotop
		$this->scrolltotop = "<a id='back-to-top' href='#' class='btn btn-primary btn-lg back-to-top' role='button' title='Click to return on the top page' data-toggle='tooltip' data-placement='left'><span class='glyphicon glyphicon-chevron-up'></span></a>";

        $container = new \html\GridDiv('container-fluid');
        $container
            ->row()
                ->column('md-12',null,$this->breadcrumbs->html())
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
