<?php 

namespace Laravel\BaseModule\Tests;

use Laravel\BaseModule\Calculator;
use PHPUnit\Framework\TestCase;

class CalculatorTest extends TestCase 
{
	/** 
	 * @test 
	 */
	public function itSums()
	{
		$calculator = new Calculator();
		$sum = $calculator->sum(2 , 2);

		$this->assertSame(4, $sum);
	}
	
}