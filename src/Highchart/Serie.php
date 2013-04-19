<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:33 PM
 */

namespace Highchart;

class Serie
{

	/**
	 * Name of the serie,
	 * must be utf8_encoded variable
	 *
	 * @var string|null
	 */
	public $name = null;

	/**
	 * List of items
	 * @var array
	 */
	public $data = array();

	/**
	 * Create new HighchartsSerie
	 *
	 * @param mixed $name
	 * @param array $data
	 *
	 * @return Serie
	 */
	public function __construct(array $data, $name = null)
	{
		$this->name = $name;
		$this->data = $data;
	}
}