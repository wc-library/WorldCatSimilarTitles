<?php

namespace output;

class Html {
    public function display($title,$data) {
        $this->idtype = $_POST['idtype'];
        $this->results = $data['query'];
        $this->libinfo = $data['library'];
?>
<!DOCTYPE html>
<html>
    <?php
        $html_header = new \html\Header;
        echo $html_header
            ->title("WorldCat Similar Titles")
            ->css("normalize.css")
            ->css("bootstrap.min.css")
            ->css("bootstrap-theme.min.css")
            ->js('jquery.js')
            ->html();

        echo "<body>";

        echo "<div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-6\">";

        $table = new \html\Table();
        $table->setClass("table table-condensed table-bordered")
            ->setCaption("library info")
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
        echo $table->html();

        echo"</div>
            <div class=\"col-md-4\"></div>
            </div>
            <div class=\"row\">
            <div class=\"col-md-2\"></div>
            <div class=\"col-md-8\">";
            $table = new \html\Table();
            $table->setClass('table table-bordered table-hover table-condensed')
                ->setCaption($title)
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
                $table->tr($rowcls)
                    ->td($id)
                    ->td($query['title'])
                    ->td($query['author'])
                    ->td($query['publisher'])
                    ->td($query['date'])
                    ->td(\implode("&nbsp;<br>",$query['related']));
            }

            echo $table->html();
            echo "</div>
            <div class=\"col-md-2\"></div>
            </div>";
        ?>
    </body>
</html>
<?php
    }
}
