<?php

class DateTest extends PHPUnit_Framework_TestCase {


	protected $date;


	public function tearDown()
	{
		$this->date = null;
	}


	public function setUp()
	{
		date_default_timezone_set('Australia/Melbourne');

		$this->date = new ExpressiveDate;
	}


	public function testDateIsCreatedFromNow()
	{
		$this->assertEquals(time(), $this->date->getTimestamp());
	}


	public function testDateIsCreatedFromStaticMethod()
	{
		$date = ExpressiveDate::make();
		$this->assertEquals(time(), $date->getTimestamp());
	}


	public function testDateIsCreatedFromDate()
	{
		$date = ExpressiveDate::makeFromDate(2013, 1, 31);
		$this->assertEquals('2013-01-31', $date->getDate());
	}


	public function testDateIsCreatedFromTime()
	{
		$date = ExpressiveDate::makeFromTime(20, null, null);
		$this->assertEquals('20:00:00', $date->getTime());

		$date = ExpressiveDate::makeFromTime(-12, null, 120);
		$this->assertEquals('12:02:00', $date->getTime());

		$date = ExpressiveDate::makeFromTime(12, 30, 125);
		$this->assertEquals('12:32:05', $date->getTime());
	}


	public function testDateIsCreatedFromDateTime()
	{
		$date = ExpressiveDate::makeFromDateTime(2013, 1, 31, 8, null, null);
		$this->assertEquals('2013-01-31 08:00:00', $date->getDateTime());

		$date = ExpressiveDate::makeFromDateTime(2013, 1, 31, -12, null, null);
		$this->assertEquals('2013-01-30 12:00:00', $date->getDateTime());
	}


	public function testDateIsCreatedWithDifferentTimezone()
	{
		$date = new ExpressiveDate(null, 'Europe/Paris');
		date_default_timezone_set('Europe/Paris');
		$this->assertEquals(time(), $date->getTimestamp());

		date_default_timezone_set('Australia/Melbourne');

		$date = new ExpressiveDate(null, new DateTimeZone('Europe/Paris'));
		date_default_timezone_set('Europe/Paris');
		$this->assertEquals(time(), $date->getTimestamp());
	}


	public function testDateIsCreatedWithCustomTimeString()
	{
		$date = new ExpressiveDate('31 January 1991');
		$this->assertEquals('31/01/1991', $date->format('d/m/Y'));

		$date = new ExpressiveDate('+1 day');
		$this->assertEquals(time() + 86400, $date->getTimestamp());

		$date = new ExpressiveDate('-1 day');
		$this->assertEquals(time() - 86400, $date->getTimestamp());
	}


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testCannotCreateDateWithInvalidTimezone()
	{
		$date = new ExpressiveDate(null, 'Australia/JasonsPlace');
	}


	public function testUseTomorrowsDateAndTime()
	{
		$this->assertEquals(strtotime('tomorrow'), $this->date->tomorrow()->getTimestamp());
	}


	public function testUseYesterdaysDateAndTime()
	{
		$this->assertEquals(strtotime('yesterday'), $this->date->yesterday()->getTimestamp());
	}


	public function testStartOfDay()
	{
		$this->assertEquals(strtotime('today'), $this->date->startOfDay()->getTimestamp());
	}


	public function testEndOfDay()
	{
		$this->assertEquals(strtotime('tomorrow -1 second'), $this->date->endOfDay()->getTimestamp());
	}


	public function testStartOfMonth()
	{
		$this->assertEquals(strtotime('January 1'), $this->date->setDay(31)->setMonth(1)->startOfMonth()->getTimestamp());
	}


	public function testEndOfMonth()
	{
		$this->assertEquals(strtotime('February 1 -1 second'), $this->date->setMonth(1)->setDay(1)->endOfMonth()->getTimestamp());
	}


	public function testDayOfWeekAsNumber()
	{
		$date = new ExpressiveDate('17 March 2013');
		$this->assertEquals(0, $date->setWeekStartDay(0)->getDayOfWeekAsNumeric());
		$this->assertEquals(6, $date->setWeekStartDay(1)->getDayOfWeekAsNumeric());

		$this->assertEquals(1, $date->setDay(18)->setWeekStartDay(0)->getDayOfWeekAsNumeric());
		$this->assertEquals(0, $date->setDay(18)->setWeekStartDay(1)->getDayOfWeekAsNumeric());

		$this->assertEquals(6, $date->setDay(23)->setWeekStartDay(0)->getDayOfWeekAsNumeric());
		$this->assertEquals(5, $date->setDay(23)->setWeekStartDay(1)->getDayOfWeekAsNumeric());
	}


	public function testSetDayOfWeekFromString()
	{
		$date = new ExpressiveDate('17 March 2013');
		$this->assertEquals(0, $date->setWeekStartDay('sunday')->getDayOfWeekAsNumeric());
		$this->assertEquals(6, $date->setWeekStartDay('monday')->getDayOfWeekAsNumeric());
	}


	public function testStartOfWeek()
	{
		$date = new ExpressiveDate('17 March 2013');
		$date->setWeekStartDay(0);

		$this->assertEquals('2013/03/17', $date->copy()->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/17', $date->copy()->setDay(19)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/17', $date->copy()->setDay(23)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/24', $date->copy()->setDay(24)->startOfWeek()->format('Y/m/d'));

		$date = new ExpressiveDate('18 March 2013');
		$date->setWeekStartDay(1);

		$this->assertEquals('2013/02/25', $date->copy()->setDay(1)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/18', $date->copy()->setDay(18)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/18', $date->copy()->setDay(19)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/18', $date->copy()->setDay(23)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/18', $date->copy()->setDay(24)->startOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/25', $date->copy()->setDay(25)->startOfWeek()->format('Y/m/d'));
	}


	public function testEndOfWeek()
	{
		$date = new ExpressiveDate('17 March 2013');
		$date->setWeekStartDay(0);

		$this->assertEquals('2013/03/23', $date->copy()->endOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/23', $date->copy()->setDay(19)->endOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/23', $date->copy()->setDay(23)->endOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/30', $date->copy()->setDay(24)->endOfWeek()->format('Y/m/d'));

		$date = new ExpressiveDate('18 March 2013');
		$date->setWeekStartDay(1);

		$this->assertEquals('2013/03/24', $date->copy()->setDay(18)->endOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/24', $date->copy()->setDay(24)->endOfWeek()->format('Y/m/d'));
		$this->assertEquals('2013/03/31', $date->copy()->setDay(25)->endOfWeek()->format('Y/m/d'));
	}


	public function testAddingDays()
	{
		$this->assertEquals(strtotime('+1 day'), $this->date->copy()->addOneDay()->getTimestamp());
		$this->assertEquals(strtotime('+4 days'), $this->date->copy()->addDays(4)->getTimestamp());
	}


	public function testSubtractingDays()
	{
		$this->assertEquals(strtotime('-1 day'), $this->date->copy()->minusOneDay()->getTimestamp());
		$this->assertEquals(strtotime('-4 days'), $this->date->copy()->minusDays(4)->getTimestamp());
	}


	public function testAddingMonths()
	{
		$this->assertEquals(strtotime('+1 month'), $this->date->copy()->addOneMonth()->getTimestamp());
		$this->assertEquals(strtotime('+4 months'), $this->date->copy()->addMonths(4)->getTimestamp());
	}


	public function testSubtractingMonths()
	{
		$this->assertEquals(strtotime('-1 month'), $this->date->copy()->minusOneMonth()->getTimestamp());
		$this->assertEquals(strtotime('-4 months'), $this->date->copy()->minusMonths(4)->getTimestamp());
	}


	public function testAddingYears()
	{
		$this->assertEquals(strtotime('+1 year'), $this->date->copy()->addOneYear()->getTimestamp());
		$this->assertEquals(strtotime('+4 years'), $this->date->copy()->addYears(4)->getTimestamp());
	}


	public function testSubtractingYears()
	{
		$this->assertEquals(strtotime('-1 year'), $this->date->copy()->minusOneYear()->getTimestamp());
		$this->assertEquals(strtotime('-4 years'), $this->date->copy()->minusYears(4)->getTimestamp());
	}


	public function testAddingHours()
	{
		$this->assertEquals(strtotime('+1 hour'), $this->date->copy()->addOneHour()->getTimestamp());
		$this->assertEquals(strtotime('+4 hours'), $this->date->copy()->addHours(4)->getTimestamp());
	}


	public function testSubtractingHours()
	{
		$this->assertEquals(strtotime('-1 hour'), $this->date->copy()->minusOneHour()->getTimestamp());
		$this->assertEquals(strtotime('-4 hours'), $this->date->copy()->minusHours(4)->getTimestamp());
	}


	public function testAddingMinutes()
	{
		$this->assertEquals(strtotime('+1 minute'), $this->date->copy()->addOneMinute()->getTimestamp());
		$this->assertEquals(strtotime('+4 minutes'), $this->date->copy()->addMinutes(4)->getTimestamp());
	}


	public function testSubtractingMinutes()
	{
		$this->assertEquals(strtotime('-1 minute'), $this->date->copy()->minusOneMinute()->getTimestamp());
		$this->assertEquals(strtotime('-4 minutes'), $this->date->copy()->minusMinutes(4)->getTimestamp());
	}


	public function testAddingSeconds()
	{
		$this->assertEquals(strtotime('+1 second'), $this->date->copy()->addOneSecond()->getTimestamp());
		$this->assertEquals(strtotime('+4 seconds'), $this->date->copy()->addSeconds(4)->getTimestamp());
	}


	public function testSubtractingSeconds()
	{
		$this->assertEquals(strtotime('-1 second'), $this->date->copy()->minusOneSecond()->getTimestamp());
		$this->assertEquals(strtotime('-4 seconds'), $this->date->copy()->minusSeconds(4)->getTimestamp());
	}


	public function testAddingWeeks()
	{
		$this->assertEquals(strtotime('+1 week'), $this->date->copy()->addOneWeek()->getTimestamp());
		$this->assertEquals(strtotime('+4 weeks'), $this->date->copy()->addWeeks(4)->getTimestamp());
	}


	public function testSubtractingWeeks()
	{
		$this->assertEquals(strtotime('-1 week'), $this->date->copy()->minusOneWeek()->getTimestamp());
		$this->assertEquals(strtotime('-4 weeks'), $this->date->copy()->minusWeeks(4)->getTimestamp());
	}


	public function testAddingDayFractions()
	{
		$this->assertEquals(strtotime('+12 hours'), $this->date->copy()->addDays(0.5)->getTimestamp());
		$this->assertEquals(strtotime('+18 hours'), $this->date->copy()->addDays(0.75)->getTimestamp());
	}


	public function testSubtractingDayFractions()
	{
		$this->assertEquals(strtotime('-12 hours'), $this->date->copy()->minusDays(0.5)->getTimestamp());
		$this->assertEquals(strtotime('-18 hours'), $this->date->copy()->minusDays(0.75)->getTimestamp());
	}


	public function testAddingMonthFractions()
	{
		$this->assertEquals(strtotime('+7 days'), $this->date->copy()->addMonths(0.25)->getTimestamp());
		$this->assertEquals(strtotime('+7 weeks'), $this->date->copy()->addMonths(1.75)->getTimestamp());
	}


	public function testSubtractingMonthFractions()
	{
		$this->assertEquals(strtotime('-7 days'), $this->date->copy()->minusMonths(0.25)->getTimestamp());
		$this->assertEquals(strtotime('-7 weeks'), $this->date->copy()->minusMonths(1.75)->getTimestamp());
	}


	public function testAddingYearFractions()
	{
		$this->assertEquals(strtotime('+3 months'), $this->date->copy()->addYears(0.25)->getTimestamp());
		$this->assertEquals(strtotime('+15 months'), $this->date->copy()->addYears(1.25)->getTimestamp());
	}


	public function testSubtractingYearFractions()
	{
		$this->assertEquals(strtotime('-3 months'), $this->date->copy()->minusYears(0.25)->getTimestamp());
		$this->assertEquals(strtotime('-15 months'), $this->date->copy()->minusYears(1.25)->getTimestamp());
	}


	public function testAddingHourFractions()
	{
		$this->assertEquals(strtotime('+30 minutes'), $this->date->copy()->addHours(0.5)->getTimestamp());
		$this->assertEquals(strtotime('+75 minutes'), $this->date->copy()->addHours(1.25)->getTimestamp());
	}


	public function testSubtractingHourFractions()
	{
		$this->assertEquals(strtotime('-30 minutes'), $this->date->copy()->minusHours(0.5)->getTimestamp());
		$this->assertEquals(strtotime('-105 minutes'), $this->date->copy()->minusHours(1.75)->getTimestamp());
	}


	public function testAddingMinuteFractions()
	{
		$this->assertEquals(strtotime('+54 seconds'), $this->date->copy()->addMinutes(0.9)->getTimestamp());
		$this->assertEquals(strtotime('+12 seconds'), $this->date->copy()->addMinutes(0.2)->getTimestamp());
	}


	public function testSubtractingMinuteFractions()
	{
		$this->assertEquals(strtotime('-24 seconds'), $this->date->copy()->minusMinutes(0.4)->getTimestamp());
		$this->assertEquals(strtotime('-42 seconds'), $this->date->copy()->minusMinutes(0.7)->getTimestamp());
	}


	public function testSettingTimezoneDuringRuntime()
	{
		$this->date->setTimezone('Europe/Paris');
		$this->assertEquals(new DateTimeZone('Europe/Paris'), $this->date->getTimezone());
	}


	public function testSetTimestampFromString()
	{
		$this->date->setTimestampFromString('Next week');
		$this->assertEquals(strtotime('Next week'), $this->date->getTimestamp());
	}


	public function testCanCheckIfDateIsWeekday()
	{
		$this->assertFalse($this->date->copy()->setTimestampFromString('Sunday')->isWeekday());
		$this->assertTrue($this->date->copy()->setTimestampFromString('Monday')->isWeekday());
	}


	public function testCanCheckIfDateIsWeekend()
	{
		$this->assertTrue($this->date->copy()->setTimestampFromString('Sunday')->isWeekend());
		$this->assertFalse($this->date->copy()->setTimestampFromString('Monday')->isWeekend());
	}

	public function testGetDateDifferenceInYears()
	{
		$past = new ExpressiveDate('January 2010');
		$future = new ExpressiveDate('January 2013');
		$this->assertEquals(-3, $future->getDifferenceInYears($past));
		$this->assertEquals(3, $past->getDifferenceInYears($future));
	}


	public function testGetDateDifferenceInMonths()
	{
		$past = new ExpressiveDate('January 2012');
		$future = new ExpressiveDate('December 2013');
		$this->assertEquals(-22, $future->getDifferenceInMonths($past));
		$this->assertEquals(22, $past->getDifferenceInMonths($future));
	}


	public function testGetDateDifferenceInDays()
	{
		$past = new ExpressiveDate('January 12');
		$future = new ExpressiveDate('February 15');
		$this->assertEquals(-34, $future->getDifferenceInDays($past));
		$this->assertEquals(34, $past->getDifferenceInDays($future));
	}


	public function testGetDateDifferenceInHours()
	{
		$past = new ExpressiveDate('-10 hours');
		$future = new ExpressiveDate('+1 hour');
		$this->assertEquals(-11, $future->getDifferenceInHours($past));
		$this->assertEquals(11, $past->getDifferenceInHours($future));
	}


	public function testGetDateDifferenceInMinutes()
	{
		$past = new ExpressiveDate('-10 minutes');
		$future = new ExpressiveDate('+1 minute');
		$this->assertEquals(-11, $future->getDifferenceInMinutes($past));
		$this->assertEquals(11, $past->getDifferenceInMinutes($future));
	}


	public function testGetDateDifferenceInSeconds()
	{
		$past = new ExpressiveDate('-1 day');
		$future = new ExpressiveDate('+1 day');
		$this->assertEquals(86400 * 2 * -1, $future->getDifferenceInSeconds($past));
		$this->assertEquals(86400 * 2, $past->getDifferenceInSeconds($future));
	}


	public function testGetDateAsRelativeDate()
	{
		$this->date->minusOneDay();
		$this->assertEquals('1 day ago', $this->date->getRelativeDate());
		$this->date->minusDays(2);
		$this->assertEquals('3 days ago', $this->date->getRelativeDate());
		$this->date->addDays(4);
		$this->assertEquals('1 day from now', $this->date->getRelativeDate());
		$this->date->addMonths(4);
		$this->assertEquals('4 months from now', $this->date->getRelativeDate());
		$this->date->minusMonths(5)->minusOneYear();
		$this->assertEquals('1 year ago', $this->date->getRelativeDate());
		$this->date->minusYears(10);
		$this->assertEquals('11 years ago', $this->date->getRelativeDate());
	}


	public function testGetDateString()
	{
		$this->assertEquals('1991-01-31', $this->date->setTimestampFromString('31 January 1991')->getDate());
	}


	public function testGetDateTimeString()
	{
		$this->assertEquals('1991-01-31 00:00:00', $this->date->setTimestampFromString('31 January 1991')->getDateTime());
	}


	public function testGetShortDateString()
	{
		$this->assertEquals('Jan 31, 1991', $this->date->setTimestampFromString('31 January 1991')->getShortDate());
	}


	public function testGetLongDateString()
	{
		$this->assertEquals('January 31st, 1991 at 12:00am', $this->date->setTimestampFromString('31 January 1991')->getLongDate());
	}


	public function testGetTimeString()
	{
		$this->assertEquals('00:00:00', $this->date->setTimestampFromString('31 January 1991')->getTime());
	}


	public function testGetDayOfWeek()
	{
		$this->assertEquals('Thursday', $this->date->setTimestampFromString('31 January 1991')->getDayOfWeek());
	}


	public function testGetDayOfWeekAsNumeric()
	{
		$this->assertEquals(4, $this->date->setTimestampFromString('31 January 1991')->getDayOfWeekAsNumeric());
	}


	public function testGetDaysInMonth()
	{
		$this->assertEquals(31, $this->date->setTimestampFromString('31 January 1991')->getDaysInMonth());
	}


	public function testGetDayOfYear()
	{
		$this->assertEquals(30, $this->date->setTimestampFromString('31 January 1991')->getDayOfYear());
	}


	public function testGetDaySuffix()
	{
		$this->assertEquals('st', $this->date->setTimestampFromString('31 January 1991')->getDaySuffix());
	}


	public function testIsLeapYear()
	{
		$this->assertFalse($this->date->setTimestampFromString('31 January 1991')->isLeapYear());
	}


	public function testIsAmOrPm()
	{
		$this->assertEquals('AM', $this->date->setTimestampFromString('31 January 1991')->isAmOrPm());
	}


	public function testIsDaylightSavings()
	{
		$this->assertTrue($this->date->setTimestampFromString('31 January 1991')->isDaylightSavings());
	}


	public function testGetGmtDifference()
	{
		$this->assertEquals('+1100', $this->date->setTimestampFromString('31 January 1991')->getGmtDifference());
	}


	public function testSecondsSinceEpoch()
	{
		$this->date->setTimestampFromString('31 January 1991');
		$this->assertEquals(strtotime('31 January 1991') - strtotime('January 1 1970 00:00:00 GMT'), $this->date->getSecondsSinceEpoch());
	}


	public function testGetTimezoneName()
	{
		$date = new ExpressiveDate('31 January 1991');
		$this->assertEquals('Australia/Melbourne', $this->date->setTimestampFromString('31 January 1991')->getTimezoneName());
	}


	public function testGetDefaultDateFormat()
	{
		$this->assertEquals('31st January, 1991 at 4:00pm', $this->date->setTimestampFromString('31 January 1991 16:00:00')->getDefaultDate());
	}


	public function testSetDefaultDateFormat()
	{
		$this->date->setDefaultDateFormat('j F');
		$this->assertEquals('31 January',$this->date->setTimestampFromString('31 January 1991 16:00:00')->getDefaultDate());
	}


	public function testDefaultDateUsedOnObjectEcho()
	{
		$this->assertEquals('31st January, 1991 at 4:00pm', $this->date->setTimestampFromString('31 January 1991 16:00:00'));
	}


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testGettingInvalidDateAttributeThrowsException()
	{
		$this->date->getInvalidDateAttribute();
	}


	/**
	 * @expectedException InvalidArgumentException
	 */
	public function testSettingInvalidDateAttributeThrowsException()
	{
		$this->date->setInvalidDateAttribute('foo');
	}


	public function testCompareDatesEqualTo()
	{
		$this->assertTrue($this->date->equalTo($this->date->copy()));
		$this->assertFalse($this->date->sameAs($this->date->copy()->addOneDay()));
	}


	public function testCompareDatesGreaterThan()
	{
		$this->assertTrue($this->date->greaterThan($this->date->copy()->minusOneDay()));
		$this->assertFalse($this->date->greaterThan($this->date->copy()));
		$this->assertFalse($this->date->greaterThan($this->date->copy()->addOneDay()));
	}


	public function testCompareDatesLessThan()
	{
		$this->assertTrue($this->date->lessThan($this->date->copy()->addOneDay()));
		$this->assertFalse($this->date->lessThan($this->date->copy()));
		$this->assertFalse($this->date->lessThan($this->date->copy()->minusOneDay()));
	}


	public function testCompareDatesGreaterThanOrEqualTo()
	{
		$this->assertTrue($this->date->greaterOrEqualTo($this->date->copy()->minusOneDay()));
		$this->assertTrue($this->date->greaterOrEqualTo($this->date->copy()));
		$this->assertFalse($this->date->greaterOrEqualTo($this->date->copy()->addOneDay()));
	}


	public function testCompareDatesLessThanOrEqualTo()
	{
		$this->assertTrue($this->date->lessOrEqualTo($this->date->copy()->addOneDay()));
		$this->assertTrue($this->date->lessOrEqualTo($this->date->copy()));
		$this->assertFalse($this->date->lessOrEqualTo($this->date->copy()->minusOneDay()));
	}


	public function testCopy()
	{
		$this->assertEquals($this->date, $this->date->copy());
	}

	
}