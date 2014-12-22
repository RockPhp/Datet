<?php

class Rock_Datet_DateUtilTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rock_Datet_DateUtil
     */
    public $dateUtil;

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
        $this->dateUtil = new Rock_Datet_DateUtil();
    }
    public function tearDown()
    {
        $this->dateUtil = null;
    }
}
