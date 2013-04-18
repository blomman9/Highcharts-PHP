<?php
namespace Highchart\Tests;

use Highchart\Chart;
use Highchart\Highchart;
use Highchart\Serie;

class Highcharts_Test extends \PHPUnit_Framework_TestCase {

	public function testCanAddSeries()
	{
		$serie1 = new Serie(array(7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6), 'Tokyo');
		$serie2 = new Serie(array(-0.2, 0.8, 5.7, 11.3, 17.0, 22.0, 24.8, 24.1, 20.1, 14.1, 8.6, 2.5), 'New York');
		$serie3 = new Serie(array(-0.9, 0.6, 3.5, 8.4, 13.5, 17.0, 18.6, 17.9, 14.3, 9.0, 3.9, 1.0), 'Berlin');
		$serie4 = new Serie(array(3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8), 'London');

		$content = $this->getChart(new Chart())
			->series
				->addSerie($serie1)
				->addSerie($serie2)
				->addSerie($serie3)
				->addSerie($serie4)->render();

		$this->assertRegExp('/Tokyo/', $content);
		$this->assertRegExp('/New York/', $content);
		$this->assertRegExp('/Berlin/', $content);
		$this->assertRegExp('/London/', $content);

		$this->assertRegExp('/14.3/', $content);
		$this->assertRegExp('/6.6/', $content);
		$this->assertRegExp('/-0.2/', $content);
		$this->assertRegExp('/25.2/', $content);
	}

	public function testMootools()
	{
		$content = $this->getChart(new Chart(), Highchart::HIGHCHARTS_ENGINE_MOOTOOLS)->render();
		$this->assertRegExp('/domready/', $content);
	}

	public function testCustomJquery()
	{
		$content = $this->getChart(new Chart(), Highchart::HIGHCHARTS_ENGINE_JQUERY_CUSTOM_PREFIX, 'testjquery')->render();
		$this->assertRegExp('/testjquery/', $content);
	}

    public function testRender() {
		$content = $this->getChart(new Chart())->render();
        $this->assertRegExp('/new Highcharts\.Chart/', $content);
    }

	public function testTooltip()
	{
		$content = $this->getChart(new Chart())->tooltip->setFormatter("function() { return 'The value for <b>'+ this.x + '</b> is <b>'+ this.y +'</b>'; }")->render();
		$this->assertRegExp('/The value for/', $content);
	}

	private function getChart(Chart $chart, $engine = Highchart::HIGHCHARTS_ENGINE_JQUERY, $custom_prefix = null)
	{
		return new Highchart($chart, $engine, $custom_prefix);
	}

}
