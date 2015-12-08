<?php
namespace vakata\random\test;

class StorageTest extends \PHPUnit_Framework_TestCase
{
	protected static $storage = null;

	public static function setUpBeforeClass() {
	}
	public static function tearDownAfterClass() {
	}
	protected function setUp() {
	}
	protected function tearDown() {
	}

	public function testString() {
		for ($i = 1; $i <= 100; $i++) {
			$this->assertEquals($i, strlen(\vakata\random\Generator::string($i)));
		}
		for ($i = 1; $i <= 100; $i++) {
			$this->assertEquals(false, preg_match('([^abc])', \vakata\random\Generator::string($i, 'abc')));
		}
	}
	public function testInt() {
		$this->assertEquals(3, \vakata\random\Generator::number(3,3));
		for ($i = 1; $i < 100; $i++) {
			$this->assertEquals(true, in_array(\vakata\random\Generator::number(1,2,3), [1,2,3]));
		}
	}
}
