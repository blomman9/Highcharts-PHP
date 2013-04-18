
        <!-- jQuery and Highchart JS -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://www.highcharts.com/js/highcharts.js" type="text/javascript"></script>

        <?php

		// Load composer autoloader
        require_once('../../vendor/autoload.php');

        // Start by adding a new reference object
        // and adding some configuration for the chart
        $oHighcharts = new Highchart\Highchart(new Highchart\Chart('container', Highchart\Chart::SERIES_TYPE_COLUMN));

		// Title typeof HighchartsTitle
		$oHighcharts->title = new Highchart\Title('Stacked bar chart');

        // Description of xAxis
        $oHighcharts->xAxis->categories = array('Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas');

        // Options for yAxis
        $oHighcharts->yAxis->min = 0;
        $oHighcharts->yAxis->setTitle(new Highchart\Title('Total fruit consumption'));

        $oHighcharts->legend->reversed = true;

        // The formatter is a javascript callback
        $oHighcharts->tooltip->setFormatter("function() {
            return this.series.name +': '+ this.y +'';
        }");

        // If stacking, choose normal
        $oHighcharts->plotOptions->column->stacking = Highchart\Plot\Options\Column::HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NORMAL;

        // These are your data
        $oHighcharts->series->addSerie(new Highchart\Serie(array(5, 3, 4, 7, 2), 'John'));
        $oHighcharts->series->addSerie(new Highchart\Serie(array(2, 2, 3, 2, 1), 'Jane'));
        $oHighcharts->series->addSerie(new Highchart\Serie(array(3, 4, 4, 2, 5), 'Joe'));


        // Render chart
        echo $oHighcharts->render();

        // Enjoy your new chart
        echo '<div id="container" style="width: 340px; height: 240px;"> </div>';