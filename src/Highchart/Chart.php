<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:27 PM
 */

namespace Highchart;

class Chart extends Output
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
	 *
	 * @return Chart
	 */
	public function __construct($renderTo = 'container', $defaultSeriesType = self::SERIES_TYPE_LINE)
	{
		$this->renderTo = $renderTo;
		$this->defaultSeriesType = $defaultSeriesType;

		$this->_code = 'chart: ' . json_encode($this);
	}
}