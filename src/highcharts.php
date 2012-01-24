<?php

/**
* Highcharts PHP
* 
* Highcharts PHP is a PHP library to interact with the Highcharts JS charting library. 
* 
* Reading from the official documentation, 
* "Highcharts is a charting library written in pure JavaScript, offering an easy way of 
* adding interactive charts to your web site or web application". 
* 
* The reason behind the highcharts-php project is to offer a useful tool to PHP developers 
* to automatically generate Highcharts JS code starting from some PHP data.
* 
* The Highcharts JS libraries are available at: www.highcharts.com and they are free for 
* non commercial use. For commercial usage, please refers to the license and pricing 
* section of their website. Again, the highcharts-php project has nothing to do with 
* the Highcharts projects.
* 
* Compatible with Highcharts JS v2.1.9 (2011-11-11)
* 
* This implementation is a transformation of highcharts-php (https://bitbucket.org/roberto.aloi/highcharts-php)
*/
class Highcharts extends HighchartsOutput
{

    /**
    * Basic chart info
    * 
    * @var HighchartsChart
    */
    private $_chart;

    /**
    * Engine, using const (jquery, or mootools at the moment)
    * 
    * @var string
    */
    private $_engine;

    /**
    * Title
    * 
    * @var HighchartsTitle
    */
    public $title;

    /**
    * xAxis
    * 
    * @var HighchartsXAxis
    */
    public $xAxis;

    /**
    * yAxis
    * 
    * @var HighchartsYAxis
    */
    public $yAxis;

    /**
    * Legend
    * 
    * @var HighchartsLegend
    */
    public $legend;

    /**
    * Tooltip
    * 
    * @var HighchartsTooltip
    */
    public $tooltip;

    /**
    * Plot Options
    * 
    * @var HighchartsPlotOptions
    */
    public $plotOptions;
    
    /**
    * Series
    * 
    * @var HighchartsSeries
    */
    public $series;
    
    const HIGHCHARTS_ENGINE_JQUERY = 'jquery';
    const HIGHCHARTS_ENGINE_MOOTOOLS = 'mootools';

    /**
    * Create new Highcharts object
    * 
    * @param HighchartsChart $chart
    * @param string $engine
    * @return Highcharts
    */
    public function __construct(HighchartsChart $chart, $engine = self::HIGHCHARTS_ENGINE_JQUERY)
    {
        $this->_chart = $chart;
        $this->_engine = $engine;

        $this->title = new HighchartsTitle();
        $this->series = new HighchartsSeries();
        $this->xAxis = new HighchartsXAxis();
        $this->yAxis = new HighchartsYAxis();

        $this->legend = new HighchartsLegend();
        $this->tooltip = new HighchartsTooltip();
        $this->plotOptions = new HighchartsPlotOptions();
    }

    /**
    * Returns JavaScript script DOM with JavaScript var
    * 
    */
    public function render()
    {
        $this->_code = $this->build_code($this->_chart->renderTo, $this->_engine);
        return $this->_code;
    }

    /**
    * Builds JavaScript based on engine
    * 
    * @param mixed $renderTo
    * @param mixed $engine
    */
    private function build_code($renderTo, $engine)
    {
        $code = '<script type="text/javascript">';
        if ($engine == self::HIGHCHARTS_ENGINE_MOOTOOLS) {
            $code .= 'window.addEvent(\'domready\', function() {';
        } else {
            $code .= '$(document).ready(function() {';
        }
        $code .= 'var ' . $renderTo . ' = new Highcharts.Chart({';
        $code .= $this->_build();
        $code .= '});});</script>';
        return $code;
    }

    /**
    * Handles all conditionals and builds JavaScript
    * 
    * @param mixed $options
    */
    private function _build()
    {
        $arrResult = array();

        $arrResult[] = $this->_chart->render();

        if ($this->title) {
            $arrResult[] = $this->title->render();
        }

        if ($this->xAxis) {
            $arrResult[] = $this->xAxis->render();
        }

        if ($this->yAxis) {
            $arrResult[] = $this->yAxis->render();
        }

        if ($this->legend) {
            $arrResult[] = $this->legend->render();
        }

        if ($this->tooltip) {
            $arrResult[] = $this->tooltip->render();
        }

        if ($this->plotOptions) {
            $arrResult[] = $this->plotOptions->render();
        }

        if ($this->series) {
            $arrResult[] = $this->series->render();
        }

        return implode(',', $arrResult);
    }
}

class HighchartsOutput
{
    /**
    * Shared resource for output data
    * 
    * @var string
    */
    protected $_code;

    /**
    * Parent class for output
    */
    public function __construct() {
    }

    /**
    * Render content based on shared resource $this->_code
    * 
    */
    protected function render() {
        return $this->_code;
    }
}

class HighchartsChart extends HighchartsOutput
{
    /**
    * Enter which container´s id (<div id="container"></div>) 
    * that highcharts should render to
    * 
    * @var string
    */
    public $renderTo;

    /**
    * Chart series type (based on const variables)
    * 
    * @var string
    */
    public $defaultSeriesType;

    const SERIES_TYPE_LINE = 'line';
    const SERIES_TYPE_BAR = 'bar';
    const SERIES_TYPE_COLUMN = 'column';
    const SERIES_TYPE_SPLINE = 'spline';

    /**
    * Create new HighchartsChart
    * 
    * @param string $renderTo
    * @param string $defaultSeriesType
    * @return HighchartsChart
    */
    public function __construct($renderTo = 'container', $defaultSeriesType = self::SERIES_TYPE_LINE) {
        $this->renderTo = $renderTo;
        $this->defaultSeriesType = $defaultSeriesType;

        $this->_code = 'chart: ' . json_encode($this);
    }
}

class HighchartsTitle extends HighchartsOutput
{
    /**
    * Title
    * 
    * @var string
    */
    var $text;

    /**
    * Create new HighchartsTitle
    * 
    * @param string $text
    * @return HighchartsTitle
    */
    public function __construct($text = null) {
        $this->text = $text;

        $this->_code = 'title: ' . json_encode($this);
    }
}

class HighchartsAxis extends HighchartsOutput
{
    /**
    * Axis min value
    * (optional)
    * 
    * @var int
    */
    public $min;

    /**
    * Axis title
    * 
    * @var HighchartsTitle
    */
    public $title;
    
    /**
    * Use setTitle to make sure explicit type is checked
    * 
    * @uses HighchartsTitle
    * @param HighchartsTitle $title
    */
    public function setTitle(HighchartsTitle $title) {
        $this->title = $title;
    }
}

class HighchartsXAxis extends HighchartsAxis
{
    /**
    * List of categories
    * 
    * @var array
    */
    public $categories;

    protected function render() {
        $this->_code = 'xAxis' . ': ' . json_encode($this);
        return parent::render();
    }
}

class HighchartsYAxis extends HighchartsAxis
{
    protected function render() {
        $this->_code = 'yAxis' . ': ' . json_encode($this);
        return parent::render();
    }
}

class HighchartsLegend extends HighchartsOutput
{
    /**
    * put your comment there...
    * 
    * @var string
    */
    public $align = self::HIGHCHARTS_LEGEND_ALIGN_CENTER;
    
    /**
    * put your comment there...
    * 
    * @var int
    */
    public $x = 0;
    
    /**
    * put your comment there...
    * 
    * @var string
    */
    public $verticalAlign = self::HIGHCHARTS_LEGEND_VERTICAL_ALIGN_BOTTOM;
    
    /**
    * put your comment there...
    * 
    * @var int
    */
    public $y = 0;
    
    /**
    * put your comment there...
    * 
    * @var boolean
    */
    public $floating = false;
    
    /**
    * put your comment there...
    * 
    * @var string
    */
    public $backgroundColor;
    
    /**
    * put your comment there...
    * 
    * @var string
    */
    public $borderColor = "#CCC";
    
    /**
    * put your comment there...
    * 
    * @var int
    */
    public $borderWidth = 1;
    
    /**
    * put your comment there...
    * 
    * @var boolean
    */
    public $shadow = false;
    
    /**
    * put your comment there...
    * 
    * @var boolean
    */
    public $reversed = false;

    const HIGHCHARTS_LEGEND_ALIGN_LEFT = 'left';
    const HIGHCHARTS_LEGEND_ALIGN_CENTER = 'center';
    const HIGHCHARTS_LEGEND_ALIGN_RIGHT = 'right';

    const HIGHCHARTS_LEGEND_VERTICAL_ALIGN_TOP = 'top';
    const HIGHCHARTS_LEGEND_VERTICAL_ALIGN_BOTTOM = 'bottom';

    protected function render() {
        $this->_code = 'legend' . ': ' . json_encode($this);
        return parent::render();
    }
}

class HighchartsTooltip extends HighchartsOutput
{
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    public $formatter;

    protected function render() {
        $this->_code = 'tooltip' . ': { formatter: ' . $this->formatter . '}';
        return parent::render();
    }
}

class HighchartsPlotOptions extends HighchartsOutput
{
    /**
    * put your comment there...
    * 
    * @var HighchartsPlotOptionsColumn
    */
    public $column;
    
    public function __construct() {
        $this->column = new HighchartsPlotOptionsColumn();
    }

    protected function render() {
        $this->_code = 'plotOptions' . ': ' . json_encode($this);
        return parent::render();
    }
}

class HighchartsPlotOptionsColumn
{
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    public $stacking = self::HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NONE;

    /**
    * put your comment there...
    * 
    * @var HighchartsPlotOptionsColumnDataLabels
    */
    public $dataLabels;

    const HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NONE = null;
    const HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NORMAL = 'normal';
    
    public function __construct() {
        $this->dataLabels = new HighchartsPlotOptionsColumnDataLabels();
    }
}

class HighchartsPlotOptionsColumnDataLabels
{
    /**
    * put your comment there...
    * 
    * @var boolean
    */
    public $enabled = false;
}

class HighchartsSeries extends HighchartsOutput
{
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    private $_arrSeries;

    /**
    * put your comment there...
    * 
    * @param mixed $serie
    */
    public function addSerie($serie) {
        $this->_arrSeries[] = $serie;
    }

    /**
    * put your comment there...
    * 
    */
    protected function render() {
        if ($this->_arrSeries) {
            $this->_code = 'series' . ': ' . json_encode($this->_arrSeries);
            return parent::render();
        }
    }
}

class HighchartsSerie
{
    /**
    * put your comment there...
    * 
    * @var mixed
    */
    public $name;

    /**
    * put your comment there...
    * 
    * @var array
    */
    public $data;

    /**
    * put your comment there...
    * 
    * @param mixed $name
    * @param mixed $data
    * @return HighchartsSerie
    */
    public function __construct($name = null, $data)
    {
        $this->name = $name;
        $this->data = $data;
    }
}
