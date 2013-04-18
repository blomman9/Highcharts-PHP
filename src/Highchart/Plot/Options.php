<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:31 PM
 */

namespace Highchart\Plot;
use Highchart\Output;
use Highchart\Plot\Options\Column;

class Options extends Output
{

	/**
	 * Column
	 *
	 * @var Column
	 */
	public $column;

	/**
	 * Create new HighchartsPlotOptions
	 */
	public function __construct()
	{
		$this->column = new Column();
	}

	/**
	 * Render column
	 *
	 */
	public function render()
	{
		if (isset($this->column)) {
			$this->_code = 'plotOptions' . ': ' . json_encode($this);
		}
		return parent::render();
	}
}