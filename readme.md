
===What is Highcharts PHP===
Highcharts PHP is a PHP library to interact with the Highcharts JS charting library. Thanks to Roberto Aloi for making the first highcharts-php library.

===What is Highcharts===
Reading from the official documentation, "Highcharts is a charting library written in pure JavaScript, offering an easy way of adding interactive charts to your web site or web application".

===Installation===
The Highcharts JS libraries are available at: www.highcharts.com and they are free for non commercial use. For commercial usage, please refers to the license and pricing section of their website. Download the Highchart JS library along with jQuery.

===Example===
Here is an example implementation:

        <!-- jQuery and Highchart JS -->
        <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="http://www.highcharts.com/js/highcharts.js" type="text/javascript"></script>

        <?php

        // Include the library
        require_once('highcharts.php');


        // Start by adding a new reference object
        // and adding some configuration for the chart
        $oHighcharts = new Highcharts(new HighchartsChart('container', HighchartsChart::SERIES_TYPE_COLUMN));

        // Title typeof HighchartsTitle
        $oHighcharts->title = new HighchartsTitle('Stacked bar chart');

        // Description of xAxis
        $oHighcharts->xAxis->categories = array('Apples', 'Oranges', 'Pears', 'Grapes', 'Bananas');

        // Options for yAxis
        $oHighcharts->yAxis->min = 0;
        $oHighcharts->yAxis->setTitle(new HighchartsTitle('Total fruit consumption'));

        $oHighcharts->legend->reversed = true;

        // The formatter is a javascript callback
        $oHighcharts->tooltip->formatter = "function() {
            return this.series.name +': '+ this.y +'';
        }";

        // If stacking, choose normal
        $oHighcharts->plotOptions->column->stacking = HighchartsPlotOptionsColumn::HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NORMAL;

        // These are your data
        $oHighcharts->series->addSerie(new HighchartsSerie('John', array(5, 3, 4, 7, 2)));
        $oHighcharts->series->addSerie(new HighchartsSerie('Jane', array(2, 2, 3, 2, 1)));
        $oHighcharts->series->addSerie(new HighchartsSerie('Joe', array(3, 4, 4, 2, 5)));


        // Render chart
        echo $oHighcharts->render();

        // Enjoy your new chart
        echo '<div id="container" style="width: 340px; height: 240px;"> </div>';