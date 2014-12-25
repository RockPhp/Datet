<?php

class Rock_Datet_DateDiffTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rock_Datet_DateDiff
     */
    public $dateDiff;

    /**
     * @var Rock_Datet_DateDiff
     */
    public $dateObj;

    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Rock_Datet_DateDiff'),
            'Class not found: '.$class
        );
        $this->assertInstanceOf('Rock_Datet_DateDiff', $this->dateDiff);
    }

    public function setUp()
    {
        $this->dateObj = new Rock_Datet_DateObj();
        $this->dateDiff = new Rock_Datet_DateDiff($this->dateObj, $this->dateObj);
    }

    public function tearDown()
    {
        $this->dateObj = null;
        $this->dateDiff = null;
    }

    public function testGetYearsReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getYears());
    }

    public function testGetMonthsReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getMonths());
    }

    public function testGetDaysReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getDays());
    }

    public function testGetHoursReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getHours());
    }

    public function testGetMinutesReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getMinutes());
    }

    public function testGetSecondsReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getSeconds());
    }

    public function testGetPositiveReturnsBoolean()
    {
        $this->assertInternalType('boolean', $this->dateDiff->getPositive());
    }

    public function testGetSecondsTotalReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getSecondsTotal());
    }

    public function testGetDaysTotalReturnsInt()
    {
        $this->assertInternalType('int', $this->dateDiff->getDaysTotal());
    }
}
