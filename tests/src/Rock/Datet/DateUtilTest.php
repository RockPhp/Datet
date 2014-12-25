<?php

class Rock_Datet_DateUtilTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rock_Datet_DateUtil
     */
    public $dateUtil;

    /**
     * @var Rock_Datet_DateDiff
     */
    public $dateObj;

    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Rock_Datet_DateUtil'),
            'Class not found: '.$class
        );
        $this->assertInstanceOf('Rock_Datet_DateUtil', $this->dateUtil);
    }

    public function setUp()
    {
        $this->dateObj = new Rock_Datet_DateObj();
        $this->dateUtil = new Rock_Datet_DateUtil($this->dateObj);
    }

    public function tearDown()
    {
        $this->dateObj = null;
        $this->dateUtil = null;
    }

    public function testTrue()
    {
        $this->assertTrue(true);
    }
}
