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

    public function testTrue()
    {
        $this->assertTrue(true);
    }
}
