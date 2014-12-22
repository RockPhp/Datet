<?php

class Rock_Datet_DateDiffTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rock_Datet_DateDiff
     */
    public $dateDiff;

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
        $this->dateDiff = new Rock_Datet_DateDiff();
    }
    public function tearDown()
    {
        $this->dateDiff = null;
    }
}
