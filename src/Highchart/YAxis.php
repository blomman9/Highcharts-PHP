<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:29 PM
 */

namespace Highchart;

class YAxis extends Axis
{

	/**
	 * Render yAxis
	 *
	 */
	public function render()
	{
		$this->_code = 'yAxis' . ': ' . json_encode($this);
		return parent::render();
	}
}