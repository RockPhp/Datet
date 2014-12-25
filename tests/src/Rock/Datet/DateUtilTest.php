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

    public function testSetNovaDataChangesDateObj()
    {
        $dateObj1 = new Rock_Datet_DateObj('01/01/2001');
        $dateUtil1 = new Rock_Datet_DateUtil($dateObj1);
        $dateUtil2 = clone $dateUtil1;
        $this->assertEquals($dateUtil1, $dateUtil2);

        $dateObj2 = new Rock_Datet_DateObj('02/02/2002');
        $this->assertNotEquals($dateObj1, $dateObj2);

        $dateUtil2->setNovaData($dateObj2);
        $this->assertNotEquals($dateUtil1, $dateUtil2);
    }
}
