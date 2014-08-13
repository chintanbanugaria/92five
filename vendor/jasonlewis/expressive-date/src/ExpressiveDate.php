<?php

/**
 *  @method int getDay() Get day of month.
 *  @method int getMonth() Get the month.
 *  @method int getYear() Get the year.
 *  @method int getHour() Get the hour.
 *  @method int getMinute() Get the minutes.
 *  @method int getSecond() Get the seconds.
 *  @method string getDayOfWeek() Get the day of the week, e.g., Monday.
 *  @method int getDayOfWeekAsNumeric() Get the numeric day of week.
 *  @method int getDaysInMonth() Get the number of days in the month.
 *  @method int getDayOfYear() Get the day of the year.
 *  @method string getDaySuffix() Get the suffix of the day, e.g., st.
 *  @method bool isLeapYear() Determines if is leap year.
 *  @method string isAmOrPm() Determines if time is AM or PM.
 *  @method bool isDaylightSavings() Determines if observing daylight savings.
 *  @method int getGmtDifference() Get difference in GMT.
 *  @method int getSecondsSinceEpoch() Get the number of seconds since epoch.
 *  @method string getTimezoneName() Get the timezone name.
 *  @method setDay(int $day) Set the day of month.
 *  @method setMonth(int $month) Set the month.
 *  @method setYear(int $year) Set the year.
 *  @method setHour(int $hour) Set the hour.
 *  @method setMinute(int $minute) Set the minutes.
 *  @method setSecond(int $second) Set the seconds.
 */

class ExpressiveDate extends DateTime {

	/**
	 * Default date format used when casting object to string.
	 *
	 * @var string
	 */
	protected $defaultDateFormat = 'j F, Y';

	/**
	 * Starting day of the week, where 0 is Sunday and 1 is Monday.
	 *
	 * @var int
	 */
	protected $weekStartDay = 0;

	/**
	 * Create a new ExpressiveDate instance.
	 *
	 * @param  string  $time
	 * @param  string|DateTimeZone  $timezone
	 * @return void
	 */
	public function __construct($time = null, $timezone = null)
	{
		$timezone = $this->parseSuppliedTimezone($timezone);

		parent::__construct($time, $timezone);
	}

	/**
	 * Make and return new ExpressiveDate instance.
	 *
	 * @param  string  $time
	 * @param  string|DateTimeZone  $timezone
	 * @return ExpressiveDate
	 */
	public static function make($time = null, $timezone = null)
	{
		return new static($time, $timezone);
	}

	/**
	 * Make and return a new ExpressiveDate instance with defined year, month, and day.
	 * 
	 * @param  int  $year
	 * @param  int  $month
	 * @param  int  $day
	 * @param  string|DateTimeZone  $timezone
	 * @return ExpressiveDate
	 */
	public static function makeFromDate($year = null, $month = null, $day = null, $timezone = null)
	{
		return static::makeFromDateTime($year, $month, $day, null, null, null, $timezone);
	}

	/**
	 * Make and return a new ExpressiveDate instance with defined hour, minute, and second.
	 * 
	 * @param  int  $hour
	 * @param  int  $minute
	 * @param  int  $second
	 * @param  string|DateTimeZone  $timezone
	 * @return ExpressiveDate
	 */
	public static function makeFromTime($hour = null, $minute = null, $second = null, $timezone = null)
	{
		return static::makeFromDateTime(null, null, null, $hour, $minute, $second, $timezone);
	}

	/**
	 * Make and return a new ExpressiveDate instance with defined year, month, day, hour, minute, and second.
	 * 
	 * @param  int  $year
	 * @param  int  $month
	 * @param  int  $day
	 * @param  int  $hour
	 * @param  int  $minute
	 * @param  int  $second
	 * @param  string|DateTimeZone  $timezone
	 * @return ExpressiveDate
	 */
	public static function makeFromDateTime($year = null, $month = null, $day = null, $hour = null, $minute = null, $second = null, $timezone = null)
	{
		$date = new static(null, $timezone);

		$date->setDate($year ?: $date->getYear(), $month ?: $date->getMonth(), $day ?: $date->getDay());

		// If no hour was given then we'll default the minute and second to the current
		// minute and second. If a date was given and minute or second are null then
		// we'll set them to 0, mimicking PHPs behaviour.
		if (is_null($hour))
		{
			$minute = $minute ?: $date->getMinute();
			$second = $second ?: $date->getSecond();
		}
		else
		{
			$minute = $minute ?: 0;
			$second = $second ?: 0;
		}

		$date->setTime($hour ?: $date->getHour(), $minute, $second);

		return $date;

	}

	/**
	 * Parse a supplied timezone.
	 *
	 * @param  string|DateTimeZone  $timezone
	 * @return DateTimeZone
	 */
	protected function parseSuppliedTimezone($timezone)
	{
		if ($timezone instanceof DateTimeZone or is_null($timezone))
		{
			return $timezone;
		}

		try
		{
			$timezone = new DateTimeZone($timezone);
		}
		catch (Exception $error)
		{
			throw new InvalidArgumentException('The supplied timezone ['.$timezone.'] is not supported.');
		}

		return $timezone;
	}

	/**
	 * Use the current date and time.
	 *
	 * @return ExpressiveDate
	 */
	public function now()
	{
		$this->setTimestamp(time());

		return $this;
	}

	/**
	 * Use today's date and time at midnight.
	 *
	 * @return ExpressiveDate
	 */
	public function today()
	{
		$this->now()->setHour(0)->setMinute(0)->setSecond(0);

		return $this;
	}

	/**
	 * Use tomorrow's date and time at midnight.
	 *
	 * @return ExpressiveDate
	 */
	public function tomorrow()
	{
		$this->now()->addOneDay()->startOfDay();

		return $this;
	}

	/**
	 * Use yesterday's date and time at midnight.
	 *
	 * @return ExpressiveDate
	 */
	public function yesterday()
	{
		$this->now()->minusOneDay()->startOfDay();

		return $this;
	}

	/**
	 * Use the start of the day.
	 *
	 * @return ExpressiveDate
	 */
	public function startOfDay()
	{
		$this->setHour(0)->setMinute(0)->setSecond(0);

		return $this;
	}

	/**
	 * Use the end of the day.
	 *
	 * @return ExpressiveDate
	 */
	public function endOfDay()
	{
		$this->setHour(23)->setMinute(59)->setSecond(59);

		return $this;
	}

	/**
	 * Use the start of the week.
	 *
	 * @return ExpressiveDate
	 */
	public function startOfWeek()
	{
		$this->minusDays($this->getDayOfWeekAsNumeric())->startOfDay();

		return $this;
	}

	/**
	 * Use the end of the week.
	 *
	 * @return ExpressiveDate
	 */
	public function endOfWeek()
	{
		$this->addDays(6 - $this->getDayOfWeekAsNumeric())->endOfDay();

		return $this;
	}

	/**
	 * Use the start of the month.
	 *
	 * @return ExpressiveDate
	 */
	public function startOfMonth()
	{
		$this->setDay(1)->startOfDay();

		return $this;
	}

	/**
	 * Use the end of the month.
	 *
	 * @return ExpressiveDate
	 */
	public function endOfMonth()
	{
		$this->setDay($this->getDaysInMonth())->endOfDay();

		return $this;
	}

	/**
	 * Add one day.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneDay()
	{
		return $this->modifyDays(1);
	}

	/**
	 * Add a given amount of days.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addDays($amount)
	{
		return $this->modifyDays($amount);
	}

	/**
	 * Minus one day.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneDay()
	{
		return $this->modifyDays(1, true);
	}

	/**
	 * Minus a given amount of days.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusDays($amount)
	{
		return $this->modifyDays($amount, true);
	}

	/**
	 * Modify by an amount of days.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyDays($amount, $invert = false)
	{
		if ($this->isFloat($amount))
		{
			return $this->modifyHours($amount * 24, $invert);
		}

		$interval = new DateInterval("P{$amount}D");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Add one month.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneMonth()
	{
		return $this->modifyMonths(1);
	}

	/**
	 * Add a given amount of months.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addMonths($amount)
	{
		return $this->modifyMonths($amount);
	}

	/**
	 * Minus one month.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneMonth()
	{
		return $this->modifyMonths(1, true);
	}

	/**
	 * Minus a given amount of months.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusMonths($amount)
	{
		return $this->modifyMonths($amount, true);
	}

	/**
	 * Modify by an amount of months.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyMonths($amount, $invert = false)
	{
		if ($this->isFloat($amount))
		{
			return $this->modifyWeeks($amount * 4, $invert);
		}

		$interval = new DateInterval("P{$amount}M");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Add one year.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneYear()
	{
		return $this->modifyYears(1);
	}

	/**
	 * Add a given amount of years.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addYears($amount)
	{
		return $this->modifyYears($amount);
	}

	/**
	 * Minus one year.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneYear()
	{
		return $this->modifyYears(1, true);
	}

	/**
	 * Minus a given amount of years.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusYears($amount)
	{
		return $this->modifyYears($amount, true);
	}

	/**
	 * Modify by an amount of Years.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyYears($amount, $invert = false)
	{
		if ($this->isFloat($amount))
		{
			return $this->modifyMonths($amount * 12, $invert);
		}

		$interval = new DateInterval("P{$amount}Y");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Add one hour.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneHour()
	{
		return $this->modifyHours(1);
	}

	/**
	 * Add a given amount of hours.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addHours($amount)
	{
		return $this->modifyHours($amount);
	}

	/**
	 * Minus one hour.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneHour()
	{
		return $this->modifyHours(1, true);
	}

	/**
	 * Minus a given amount of hours.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusHours($amount)
	{
		return $this->modifyHours($amount, true);
	}

	/**
	 * Modify by an amount of hours.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyHours($amount, $invert = false)
	{
		if ($this->isFloat($amount))
		{
			return $this->modifyMinutes($amount * 60, $invert);
		}

		$interval = new DateInterval("PT{$amount}H");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Add one minute.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneMinute()
	{
		return $this->modifyMinutes(1);
	}

	/**
	 * Add a given amount of minutes.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addMinutes($amount)
	{
		return $this->modifyMinutes($amount);
	}

	/**
	 * Minus one minute.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneMinute()
	{
		return $this->modifyMinutes(1, true);
	}

	/**
	 * Minus a given amount of minutes.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusMinutes($amount)
	{
		return $this->modifyMinutes($amount, true);
	}

	/**
	 * Modify by an amount of minutes.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyMinutes($amount, $invert = false)
	{
		if ($this->isFloat($amount))
		{
			return $this->modifySeconds($amount * 60, $invert);
		}

		$interval = new DateInterval("PT{$amount}M");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Add one second.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneSecond()
	{
		return $this->modifySeconds(1);
	}

	/**
	 * Add a given amount of seconds.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addSeconds($amount)
	{
		return $this->modifySeconds($amount);
	}

	/**
	 * Minus one second.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneSecond()
	{
		return $this->modifySeconds(1, true);
	}

	/**
	 * Minus a given amount of seconds.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusSeconds($amount)
	{
		return $this->modifySeconds($amount, true);
	}

	/**
	 * Modify by an amount of seconds.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifySeconds($amount, $invert = false)
	{
		$interval = new DateInterval("PT{$amount}S");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Add one week.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addOneWeek()
	{
		return $this->modifyWeeks(1);
	}

	/**
	 * Add a given amount of weeks.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function addWeeks($amount)
	{
		return $this->modifyWeeks($amount);
	}

	/**
	 * Minus one week.
	 *
	 * @return ExpressiveDate
	 */
	public function minusOneWeek()
	{
		return $this->modifyWeeks(1, true);
	}

	/**
	 * Minus a given amount of weeks.
	 *
	 * @param  int  $amount
	 * @return ExpressiveDate
	 */
	public function minusWeeks($amount)
	{
		return $this->modifyWeeks($amount, true);
	}

	/**
	 * Modify by an amount of weeks.
	 *
	 * @param  int  $amount
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyWeeks($amount, $invert = false)
	{
		if ($this->isFloat($amount))
		{
			return $this->modifyDays($amount * 7, $invert);
		}

		$interval = new DateInterval("P{$amount}W");

		$this->modifyFromInterval($interval, $invert);

		return $this;
	}

	/**
	 * Modify from a DateInterval object.
	 *
	 * @param  DateInterval  $interval
	 * @param  bool  $invert
	 * @return ExpressiveDate
	 */
	protected function modifyFromInterval($interval, $invert = false)
	{
		if ($invert)
		{
			$this->sub($interval);
		}
		else
		{
			$this->add($interval);
		}

		return $this;
	}

	/**
	 * Set the timezone.
	 *
	 * @param  string|DateTimeZone  $timezone
	 * @return ExpressiveDate
	 */
	public function setTimezone($timezone)
	{
		$timezone = $this->parseSuppliedTimezone($timezone);

		parent::setTimezone($timezone);

		return $this;
	}

	/**
	 * Sets the timestamp from a human readable string.
	 *
	 * @param  string  $string
	 * @return ExpressiveDate
	 */
	public function setTimestampFromString($string)
	{
		$this->setTimestamp(strtotime($string));

		return $this;
	}

	/**
	 * Determine if day is a weekday.
	 *
	 * @return bool
	 */
	public function isWeekday()
	{
		$day = $this->getDayOfWeek();

		return ! in_array($day, array('Saturday', 'Sunday'));
	}

	/**
	 * Determine if day is a weekend.
	 *
	 * @return bool
	 */
	public function isWeekend()
	{
		return ! $this->isWeekday();
	}

	/**
	 * Get the difference in years.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getDifferenceInYears($compare = null)
	{
		if ( ! $compare)
		{
			$compare = new ExpressiveDate(null, $this->getTimezone());
		}

		return $this->diff($compare)->format('%r%y');
	}

	/**
	 * Get the difference in months.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getDifferenceInMonths($compare = null)
	{
		if ( ! $compare)
		{
			$compare = new ExpressiveDate(null, $this->getTimezone());
		}

		$difference = $this->diff($compare);

		list($years, $months) = explode(':', $difference->format('%y:%m'));

		return (($years * 12) + $months) * $difference->format('%r1');
	}

	/**
	 * Get the difference in days.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getDifferenceInDays($compare = null)
	{
		if ( ! $compare)
		{
			$compare = new ExpressiveDate(null, $this->getTimezone());
		}

		return $this->diff($compare)->format('%r%a');
	}

	/**
	 * Get the difference in hours.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getDifferenceInHours($compare = null)
	{
		return $this->getDifferenceInMinutes($compare) / 60;
	}

	/**
	 * Get the difference in minutes.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getDifferenceInMinutes($compare = null)
	{
		return $this->getDifferenceInSeconds($compare) / 60;
	}

	/**
	 * Get the difference in seconds.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getDifferenceInSeconds($compare = null)
	{
		if ( ! $compare)
		{
			$compare = new ExpressiveDate(null, $this->getTimezone());
		}

		$difference = $this->diff($compare);

		list($days, $hours, $minutes, $seconds) = explode(':', $difference->format('%a:%h:%i:%s'));

		// Add the total amount of seconds in all the days.
		$seconds += ($days * 24 * 60 * 60);

		// Add the total amount of seconds in all the hours.
		$seconds += ($hours * 60 * 60);

		// Add the total amount of seconds in all the minutes.
		$seconds += ($minutes * 60);

		return $seconds * $difference->format('%r1');
	}

	/**
	 * Get a relative date string, e.g., 3 days ago.
	 *
	 * @param  ExpressiveDate  $compare
	 * @return string
	 */
	public function getRelativeDate($compare = null)
	{
		if ( ! $compare)
		{
			$compare = new ExpressiveDate(null, $this->getTimezone());
		}

		$units = array('second', 'minute', 'hour', 'day', 'week', 'month', 'year');
		$values = array(60, 60, 24, 7, 4.35, 12);

		// Get the difference between the two timestamps. We'll use this to cacluate the
		// actual time remaining.
		$difference = abs($compare->getTimestamp() - $this->getTimestamp());

		for ($i = 0; $i < count($values) and $difference >= $values[$i]; $i++)
		{
			$difference = $difference / $values[$i];
		}

		// Round the difference to the nearest whole number.
		$difference = round($difference);

		if ($compare->getTimestamp() < $this->getTimestamp())
		{
			$suffix = 'from now';
		}
		else
		{
			$suffix = 'ago';
		}

		// Get the unit of time we are measuring. We'll then check the difference, if it is not equal
		// to exactly 1 then it's a multiple of the given unit so we'll append an 's'.
		$unit = $units[$i];

		if ($difference != 1)
		{
			$unit .= 's';
		}

		return $difference.' '.$unit.' '.$suffix;
	}

	/**
	 * Get a date string in the format of 2012-12-04.
	 *
	 * @return string
	 */
	public function getDate()
	{
		return $this->format('Y-m-d');
	}

	/**
	 * Get a date and time string in the format of 2012-12-04 23:43:27.
	 *
	 * @return string
	 */
	public function getDateTime()
	{
		return $this->format('Y-m-d H:i:s');
	}

	/**
	 * Get a date string in the format of Jan 31, 1991.
	 *
	 * @return string
	 */
	public function getShortDate()
	{
		return $this->format('M j, Y');
	}

	/**
	 * Get a date string in the format of January 31st, 1991 at 7:45am.
	 *
	 * @return string
	 */
	public function getLongDate()
	{
		return $this->format('F jS, Y \a\\t g:ia');
	}

	/**
	 * Get a date string in the format of 07:42:32.
	 *
	 * @return string
	 */
	public function getTime()
	{
		return $this->format('H:i:s');
	}

	/**
	 * Get a date string in the default format.
	 *
	 * @return string
	 */
	public function getDefaultDate()
	{
		return $this->format($this->defaultDateFormat);
	}

	/**
	 * Set the default date format.
	 *
	 * @param  string  $format
	 * @return ExpressiveDate
	 */
	public function setDefaultDateFormat($format)
	{
		$this->defaultDateFormat = $format;

		return $this;
	}

	/**
	 * Set the starting day of the week, where 0 is Sunday and 1 is Monday.
	 *
	 * @param int|string $weekStartDay
	 * @return void
	 */
	public function setWeekStartDay($weekStartDay)
	{
		if (is_numeric($weekStartDay))
		{
			$this->weekStartDay = $weekStartDay;
		}
		else
		{
			$this->weekStartDay = array_search(strtolower($weekStartDay), array('sunday', 'monday'));
		}

		return $this;
	}

	/**
	 * Get the starting day of the week, where 0 is Sunday and 1 is Monday
	 *
	 * @return int
	 */
	public function getWeekStartDay()
	{
		return $this->weekStartDay;
	}

	/**
	 * Get a date attribute.
	 *
	 * @param  string  $attribute
	 * @return mixed
	 */
	protected function getDateAttribute($attribute)
	{
		switch ($attribute)
		{
			case 'Day':
				return $this->format('d');
				break;
			case 'Month':
				return $this->format('m');
				break;
			case 'Year':
				return $this->format('Y');
				break;
			case 'Hour':
				return $this->format('G');
				break;
			case 'Minute':
				return $this->format('i');
				break;
			case 'Second':
				return $this->format('s');
				break;
			case 'DayOfWeek':
				return $this->format('l');
				break;
			case 'DayOfWeekAsNumeric':
				return (7 + $this->format('w') - $this->getWeekStartDay()) % 7;
				break;
			case 'DaysInMonth':
				return $this->format('t');
				break;
			case 'DayOfYear':
				return $this->format('z');
				break;
			case 'DaySuffix':
				return $this->format('S');
				break;
			case 'GmtDifference':
				return $this->format('O');
				break;
			case 'SecondsSinceEpoch':
				return $this->format('U');
				break;
			case 'TimezoneName':
				return $this->getTimezone()->getName();
				break;
		}

		throw new InvalidArgumentException('The date attribute ['.$attribute.'] could not be found.');
	}

	/**
	 * Syntactical sugar for determining if date object "is" a condition.
	 * 
	 * @param  string  $attribute
	 * @return mixed
	 */
	protected function isDateAttribute($attribute)
	{
		switch ($attribute)
		{
			case 'LeapYear':
				return (bool) $this->format('L');
				break;
			case 'AmOrPm':
				return $this->format('A');
				break;
			case 'DaylightSavings':
				return (bool) $this->format('I');
				break;
		}

		throw new InvalidArgumentException('The date attribute ['.$attribute.'] could not be found.');
	}

	/**
	 * Set a date attribute.
	 *
	 * @param  string  $attribute
	 * @return mixed
	 */
	protected function setDateAttribute($attribute, $value)
	{
		switch ($attribute)
		{
			case 'Day':
				return $this->setDate($this->getYear(), $this->getMonth(), $value);
				break;
			case 'Month':
				return $this->setDate($this->getYear(), $value, $this->getDay());
				break;
			case 'Year':
				return $this->setDate($value, $this->getMonth(), $this->getDay());
				break;
			case 'Hour':
				return $this->setTime($value, $this->getMinute(), $this->getSecond());
				break;
			case 'Minute':
				return $this->setTime($this->getHour(), $value, $this->getSecond());
				break;
			case 'Second':
				return $this->setTime($this->getHour(), $this->getMinute(), $value);
				break;
		}

		throw new InvalidArgumentException('The date attribute ['.$attribute.'] could not be set.');
	}

	/**
	 * Alias for ExpressiveDate::equalTo()
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function sameAs(ExpressiveDate $date)
	{
		return $this->equalTo($date);
	}

	/**
	 * Determine if date is equal to another Expressive Date instance.
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function equalTo(ExpressiveDate $date)
	{
		return $this == $date;
	}

	/**
	 * Determine if date is not equal to another Expressive Date instance.
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function notEqualTo(ExpressiveDate $date)
	{
		return ! $this->equalTo($date);
	}

	/**
	 * Determine if date is greater than another Expressive Date instance.
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function greaterThan(ExpressiveDate $date)
	{
		return $this > $date;
	}

	/**
	 * Determine if date is less than another Expressive Date instance.
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function lessThan(ExpressiveDate $date)
	{
		return $this < $date;
	}

	/**
	 * Determine if date is greater than or equal to another Expressive Date instance.
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function greaterOrEqualTo(ExpressiveDate $date)
	{
		return $this >= $date;
	}

	/**
	 * Determine if date is less than or equal to another Expressive Date instance.
	 * 
	 * @param  ExpressiveDate  $date
	 * @return bool
	 */
	public function lessOrEqualTo(ExpressiveDate $date)
	{
		return $this <= $date;
	}

	/**
	 * Dynamically handle calls for date attributes and testers.
	 *
	 * @param  string  $method
	 * @param  array  $parameters
	 * @return mixed
	 */
	public function __call($method, $parameters)
	{
		if (substr($method, 0, 3) == 'get' or substr($method, 0, 3) == 'set')
		{
			$attribute = substr($method, 3);
		}
		elseif (substr($method, 0, 2) == 'is')
		{
			$attribute = substr($method, 2);

			return $this->isDateAttribute($attribute);
		}

		if ( ! isset($attribute))
		{
			throw new InvalidArgumentException('Could not dynamically handle method call ['.$method.']');
		}

		if (substr($method, 0, 3) == 'set')
		{
			return $this->setDateAttribute($attribute, $parameters[0]);
		}

		// If not setting an attribute then we'll default to getting an attribute.
		return $this->getDateAttribute($attribute);
	}

	/**
	 * Return the default date format when casting to string.
	 *
	 * @return string
	 */
	public function __toString()
	{
		return $this->getDefaultDate();
	}

	/**
	 * Determine if a given amount is a floating point number.
	 * 
	 * @param  int|float  $amount
	 * @return bool
	 */
	protected function isFloat($amount)
	{
		return is_float($amount) and intval($amount) != $amount;
	}

	/**
	 * Return copy of expressive date object
	 *
	 * @return ExpressiveDate
	 */
	public function copy()
	{
		return clone $this;
	}

}