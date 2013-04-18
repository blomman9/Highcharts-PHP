<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:27 PM
 */

namespace Highchart;

class Title extends Output
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
	 *
	 * @return Title
	 */
	public function __construct($text = null)
	{
		$this->text = $text;

		$this->_code = 'title: ' . json_encode($this);
	}
}