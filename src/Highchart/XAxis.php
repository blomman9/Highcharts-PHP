<?php
namespace Highchart;

class XAxis extends Axis
{

	/**
	 * List of categories
	 *
	 * @var array
	 */
	public $categories;

	public function render()
	{
		$this->_code = 'xAxis' . ': ' . json_encode($this);
		return parent::render();
	}
}