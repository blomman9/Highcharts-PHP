<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:28 PM
 */

namespace Highchart;

class Axis extends Output
{

	/**
	 * Axis min value
	 * (optional)
	 *
	 * @var int
	 */
	public $min;

	/**
	 * Axis title
	 *
	 * @var Title
	 */
	public $title = '';

	/**
	 * Use setTitle to make sure explicit type is checked
	 *
	 * @uses Title
	 *
	 * @param Title $title
	 */
	public function setTitle(Title $title)
	{
		$this->title = $title;
	}
}