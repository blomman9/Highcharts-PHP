<?php

require 'src/highcharts.php';

class Highcharts_Test extends PHPUnit_Framework_TestCase {

    /**
    * @var Highcharts
    */
    private $highcharts;

    /**
    * Set up
    */
    public function setUp() {
        $chart = new HighchartsChart();
        $this->highcharts = new Highcharts($chart);
    }

    /**
    * Cleanup
    */
    public function tearDown() {
        unset($this->highcharts);
    }
    
    public function testHighchartsHasAttributes() {
        $this->assertClassHasAttribute('title', 'Highcharts');
        $this->assertClassHasAttribute('series', 'Highcharts');
        $this->assertClassHasAttribute('xAxis', 'Highcharts');
        $this->assertClassHasAttribute('yAxis', 'Highcharts');
    }

    public function testRender() {
        $content = $this->highcharts->render();
        $this->assertRegExp('/new Highcharts\.Chart/', $content);
    }

}
