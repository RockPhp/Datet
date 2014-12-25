<?php

class Rock_Datet_DateObjTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var Rock_Datet_DateObj
     */
    public $dateObj;

    public function assertPreConditions()
    {
        $this->assertTrue(
            class_exists($class = 'Rock_Datet_DateObj'),
            'Class not found: '.$class
        );
        $this->assertInstanceOf('Rock_Datet_DateObj', $this->dateObj);
    }
    public function setUp()
    {
        $this->dateObj = new Rock_Datet_DateObj();
    }
    public function tearDown()
    {
        $this->dateObj = null;
    }

    public function testTimeStampIsInt()
    {
        $this->assertInternalType(
            'int',
            $this->dateObj->getTimeStamp()
        );
    }

    public function providerWeekends()
    {
        return array(
            array('20141206', '%Y%m%d'),
            array('20141213', '%Y%m%d'),
            array('20141220', '%Y%m%d'),
            array('20141227', '%Y%m%d'),
        );
    }

    /**
     * @dataProvider providerWeekends
     */
    public function testIsWeekendReturnsTrueForWeekends($date, $format)
    {
        $weekend = new Rock_Datet_DateObj($date, $format);
        $this->assertTrue($weekend->isWeekend());
        $weekend = null;
    }

    public function providerWeekdays()
    {
        return array(
            array('20141208', '%Y%m%d'),
            array('20141215', '%Y%m%d'),
            array('20141222', '%Y%m%d'),
            array('20141229', '%Y%m%d'),
        );
    }

    /**
     * @dataProvider providerWeekdays
     */
    public function testIsWeekendReturnsFalseForWeekdays($date, $format)
    {
        $weekday = new Rock_Datet_DateObj($date, $format);
        $this->assertFalse($weekday->isWeekend());
        $weekday = null;
    }

    public function testGetTimeStampReturnsInt()
    {
        $this->assertInternalType('int', $this->dateObj->getTimeStamp());
    }

    public function testGetFormatReturnsString()
    {
        $this->assertInternalType('string', $this->dateObj->getFormat());
    }
}
