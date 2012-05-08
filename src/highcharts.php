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
    * Custom prefix for JavaScript engine
    * 
    * @var string
    */
    private $_custom_prefix;

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
    
    const HIGHCHARTS_ENGINE_AJAX                 = 'ajax';
    const HIGHCHARTS_ENGINE_JQUERY               = 'jquery';
    const HIGHCHARTS_ENGINE_JQUERY_CUSTOM_PREFIX = 'jquery-custom';
    const HIGHCHARTS_ENGINE_MOOTOOLS             = 'mootools';

    /**
    * Create new Highcharts object
    * 
    * @param HighchartsChart $chart
    * @param string $engine Optional: JavaScript engine
    * @param string $custom_prefix Optional: custom JavaScript engine prefix
    * @return Highcharts
    */
    public function __construct(HighchartsChart $chart, $engine = self::HIGHCHARTS_ENGINE_JQUERY, $custom_prefix = null)
    {
        $this->_chart = $chart;
        $this->_engine = $engine;
        $this->_custom_prefix = $custom_prefix;

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
        } elseif ($engine == self::HIGHCHARTS_ENGINE_JQUERY_CUSTOM_PREFIX && isset($this->_custom_prefix)) {
            $code .= $this->_custom_prefix . '(document).ready(function() {';
        } elseif ($engine !== self::HIGHCHARTS_ENGINE_AJAX) {
            $code .= '$(document).ready(function() {';
        }
        $code .= 'var ' . $renderTo . ' = ';
        $code .= 'new Highcharts.Chart({';
        $code .= $this->_build();
        $code .= '})';
        if ($engine !== self::HIGHCHARTS_ENGINE_AJAX) {
            $code .= '});';
        }
        $code .= '</script>';
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
        if (!$this->_code) {
            return '_err: null';
        }
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
    public $title = '';
    
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
    /**
    * Render yAxis
    * 
    */
    protected function render() {
        $this->_code = 'yAxis' . ': ' . json_encode($this);
        return parent::render();
    }
}

class HighchartsLegend extends HighchartsOutput
{
    /**
    * Alignment
    * 
    * @var string
    */
    public $align = self::HIGHCHARTS_LEGEND_ALIGN_CENTER;
    
    /**
    * Legend x position
    * 
    * @var int
    */
    public $x = 0;
    
    /**
    * Vertical alignment
    * 
    * @var string
    */
    public $verticalAlign = self::HIGHCHARTS_LEGEND_VERTICAL_ALIGN_BOTTOM;
    
    /**
    * Legend y position
    * 
    * @var int
    */
    public $y = 0;
    
    /**
    * Floating (y|n)
    * 
    * @var boolean
    */
    public $floating = false;
    
    /**
    * Background color
    * 
    * @var string
    */
    public $backgroundColor;
    
    /**
    * Border color
    * 
    * @var string
    */
    public $borderColor = "#CCC";
    
    /**
    * Border width
    * 
    * @var int
    */
    public $borderWidth = 1;
    
    /**
    * Shadow
    * 
    * @var boolean
    */
    public $shadow = false;
    
    /**
    * Reversed
    * 
    * @var boolean
    */
    public $reversed = false;

    const HIGHCHARTS_LEGEND_ALIGN_LEFT = 'left';
    const HIGHCHARTS_LEGEND_ALIGN_CENTER = 'center';
    const HIGHCHARTS_LEGEND_ALIGN_RIGHT = 'right';

    const HIGHCHARTS_LEGEND_VERTICAL_ALIGN_TOP = 'top';
    const HIGHCHARTS_LEGEND_VERTICAL_ALIGN_BOTTOM = 'bottom';

    /**
    * Render legend
    * 
    */
    protected function render() {
        $this->_code = 'legend' . ': ' . json_encode($this);
        return parent::render();
    }
}

class HighchartsTooltip extends HighchartsOutput
{
    /**
    * Tooltip formatter
    * 
    * @var string
    */
    public $formatter;

    /**
    * Render tooltip
    * 
    */
    protected function render() {
        if (isset($this->formatter)) {
            $this->_code = 'tooltip' . ': { formatter: ' . $this->formatter . '}';
        }
        return parent::render();
    }
}

class HighchartsPlotOptions extends HighchartsOutput
{
    /**
    * Column
    * 
    * @var HighchartsPlotOptionsColumn
    */
    public $column;
    
    /**
    * Create new HighchartsPlotOptions
    */
    public function __construct() {
        $this->column = new HighchartsPlotOptionsColumn();
    }

    /**
    * Render column
    * 
    */
    protected function render() {
        if (isset($this->column)) {
            $this->_code = 'plotOptions' . ': ' . json_encode($this);
        }
        return parent::render();
    }
}

class HighchartsPlotOptionsColumn
{
    /**
    * Stacking
    * 
    * @var string
    */
    public $stacking = self::HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NONE;

    /**
    * Data labels
    * 
    * @var HighchartsPlotOptionsColumnDataLabels
    */
    public $dataLabels;

    const HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NONE = null;
    const HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NORMAL = 'normal';

    /**
    * Create new HighchartsPlotOptionsColumn
    * 
    */
    public function __construct() {
        $this->dataLabels = new HighchartsPlotOptionsColumnDataLabels();
    }
}

class HighchartsPlotOptionsColumnDataLabels
{
    /**
    * Enabled
    * 
    * @var boolean
    */
    public $enabled = false;
}

class HighchartsSeries extends HighchartsOutput
{
    /**
    * List of series
    * 
    * @var array
    */
    private $_arrSeries;

    /**
    * Add new serie
    * 
    * @param HighchartsSerie $serie
    */
    public function addSerie(HighchartsSerie $serie) {
        $this->_arrSeries[] = $serie;
    }

    /**
    * Render series
    * 
    */
    protected function render() {
        if ($this->_arrSeries) {
            $this->_code = 'series' . ': ' . json_encode($this->_arrSeries);            
        }
        return parent::render();
    }
}

class HighchartsSerie
{
    /**
    * Name of the serie,
    * must be utf8_encoded variable
    * 
    * @var mixed
    */
    public $name;

    /**
    * List of items
    * 
    * @var array
    */
    public $data;

    /**
    * Create new HighchartsSerie
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
