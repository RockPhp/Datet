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
            array('20141206', 'Ymd'),
            // array('20141213', 'Ymd'),
            // array('20141220', 'Ymd'),
            // array('20141227', 'Ymd'),
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

    // public function providerWeekdays()
    // {
    //     return array(
    //         array('20141208', 'Ymd'),
    //         array('20141215', 'Ymd'),
    //         array('20141222', 'Ymd'),
    //         array('20141229', 'Ymd'),
    //     );
    // }

    // *
    //  * @dataProvider providerWeekdays
     
    // public function testIsWeekendReturnsFalseForWeekdays($date, $format)
    // {
    //     $weekday = new Rock_Datet_DateObj($date, $format);
    //     $this->assertTrue($weekday->isWeekend);
    //     $weekday = null;
    // }
}
