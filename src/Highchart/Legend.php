<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:30 PM
 */

namespace Highchart;

class Legend extends Output
{

	/**
	 * Alignment
	 *
	 * @var string
	 */
	public $align = self::HIGHCHARTS_LEGEND_ALIGN_CENTER;

	/**
	 * Legend x position
	 *
	 * @var int
	 */
	public $x = 0;

	/**
	 * Vertical alignment
	 *
	 * @var string
	 */
	public $verticalAlign = self::HIGHCHARTS_LEGEND_VERTICAL_ALIGN_BOTTOM;

	/**
	 * Legend y position
	 *
	 * @var int
	 */
	public $y = 0;

	/**
	 * Floating (y|n)
	 *
	 * @var boolean
	 */
	public $floating = false;

	/**
	 * Background color
	 *
	 * @var string
	 */
	public $backgroundColor;

	/**
	 * Border color
	 *
	 * @var string
	 */
	public $borderColor = "#CCC";

	/**
	 * Border width
	 *
	 * @var int
	 */
	public $borderWidth = 1;

	/**
	 * Shadow
	 *
	 * @var boolean
	 */
	public $shadow = false;

	/**
	 * Reversed
	 *
	 * @var boolean
	 */
	public $reversed = false;

	const HIGHCHARTS_LEGEND_ALIGN_LEFT = 'left';

	const HIGHCHARTS_LEGEND_ALIGN_CENTER = 'center';

	const HIGHCHARTS_LEGEND_ALIGN_RIGHT = 'right';

	const HIGHCHARTS_LEGEND_VERTICAL_ALIGN_TOP = 'top';

	const HIGHCHARTS_LEGEND_VERTICAL_ALIGN_BOTTOM = 'bottom';

	/**
	 * Render legend
	 *
	 */
	public function render()
	{
		$this->_code = 'legend' . ': ' . json_encode($this);
		return parent::render();
	}
}