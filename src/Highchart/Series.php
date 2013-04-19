<?php
/**
 * Created by lsv
 * Date: 4/18/13
 * Time: 5:32 PM
 */

namespace Highchart;

class Series extends Output
{

	/**
	 * List of series
	 *
	 * @var array
	 */
	private $_arrSeries;

	/**
	 * Add new serie
	 *
	 * @param Serie $serie
	 * @return Series
	 */
	public function addSerie(Serie $serie)
	{
		$this->_arrSeries[] = $serie;
		return $this;
	}

	/**
	 * Render series
	 *
	 */
	public function render()
	{
		if ($this->_arrSeries) {
			$this->_code = 'series' . ': ' . json_encode($this->_arrSeries);
		}
		return parent::render();
	}
}