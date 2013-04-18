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
namespace Highchart;
use Highchart\Plot\Options as PlotOptions;

class Highchart extends Output
{

	/**
	 * Basic chart info
	 *
	 * @var Chart
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
	 * @var Title
	 */
	public $title;

	/**
	 * xAxis
	 *
	 * @var XAxis
	 */
	public $xAxis;

	/**
	 * yAxis
	 *
	 * @var YAxis
	 */
	public $yAxis;

	/**
	 * Legend
	 *
	 * @var Legend
	 */
	public $legend;

	/**
	 * Tooltip
	 *
	 * @var Tooltip
	 */
	public $tooltip;

	/**
	 * Plot Options
	 *
	 * @var PlotOptions
	 */
	public $plotOptions;

	/**
	 * Series
	 *
	 * @var Series
	 */
	public $series;

	const HIGHCHARTS_ENGINE_AJAX = 'ajax';

	const HIGHCHARTS_ENGINE_JQUERY = 'jquery';

	const HIGHCHARTS_ENGINE_JQUERY_CUSTOM_PREFIX = 'jquery-custom';

	const HIGHCHARTS_ENGINE_MOOTOOLS = 'mootools';

	/**
	 * Create new Highcharts object
	 *
	 * @param Chart $chart
	 * @param string $engine Optional: JavaScript engine
	 * @param string $custom_prefix Optional: custom JavaScript engine prefix
	 *
	 * @return Highchart
	 */
	public function __construct(Chart $chart, $engine = self::HIGHCHARTS_ENGINE_JQUERY, $custom_prefix = null)
	{
		$this->_chart = $chart;
		$this->_engine = $engine;
		$this->_custom_prefix = $custom_prefix;

		$this->title = new Title();
		$this->series = new Series();
		$this->xAxis = new XAxis();
		$this->yAxis = new YAxis();

		$this->legend = new Legend();
		$this->tooltip = new Tooltip();
		$this->plotOptions = new PlotOptions();
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
	 *
	 * @return string
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
	 * @return string
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