<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:25 PM
 */

namespace Highchart;

class Output
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
	public function __construct()
	{
	}

	/**
	 * Render content based on shared resource $this->_code
	 *
	 */
	protected function render()
	{
		if (!$this->_code) {
			return '_err: null';
		}
		return $this->_code;
	}
}