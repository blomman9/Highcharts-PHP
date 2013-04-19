<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:30 PM
 */

namespace Highchart;

class Tooltip extends Output
{

	/**
	 * Tooltip formatter
	 *
	 * @var string
	 */
	private $formatter;

	/**
	 * Render tooltip
	 *
	 */
	public function render()
	{
		if (isset($this->formatter)) {
			$this->_code = 'tooltip' . ': { formatter: ' . $this->formatter . '}';
		}
		return parent::render();
	}

	/**
	 * @param string $str : javascript callback
	 *
	 * @return Tooltip
	 */
	public function setFormatter($str)
	{
		$this->formatter = $str;
		return $this;
	}
}