<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:31 PM
 */

namespace Highchart\Plot\Options;
use Highchart\Plot\Options\Column\Labels;

class Column
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
	 * @var Labels
	 */
	public $dataLabels;

	const HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NONE = null;

	const HIGHCHARTS_PLOT_OPTIONS_COLUMN_STACKING_NORMAL = 'normal';

	/**
	 * Create new HighchartsPlotOptionsColumn
	 *
	 */
	public function __construct()
	{
		$this->dataLabels = new Labels();
	}
}