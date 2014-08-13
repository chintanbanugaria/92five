# Expressive Date

A fluent extension to PHPs DateTime class.

[![Build Status](https://travis-ci.org/jasonlewis/expressive-date.png?branch=master)](https://travis-ci.org/jasonlewis/expressive-date)

## Table of Contents

- <a href="#installation">Installation</a>
    - <a href="#composer">Composer</a>
    - <a href="#manually">Manually</a>
    - <a href="#laravel-4">Laravel 4</a>
- <a href="#usage">Usage</a>
    - <a href="#getting-instances">Getting Instances</a>
    - <a href="#quick-helpers">Quick Helpers</a>
    - <a href="#cloning">Cloning</a>
    - <a href="#manipulating-dates">Manipulating Dates</a>
    - <a href="#differences-between-dates">Differences Between Dates</a>
    - <a href="#comparing-dates">Comparing Dates</a>
    - <a href="#interacting-with-dates">Interacting With Dates</a>
    - <a href="#formatting-dates">Formatting Dates</a>
    - <a href="#working-with-timezones">Working With Timezones</a>
- <a href="#changelog">Changelog</a>
- <a href="#license">License</a>

## Installation

### Composer

Add Expressive Date to your `composer.json` file.

    "jasonlewis/expressive-date": "1.0.*"

Run `composer install` to get the latest version of the package.

### Manually

It's recommended that you use Composer, however you can download and install from this repository.

### Laravel 4

Expressive Date comes with a service provider for Laravel 4. You'll need to add it to your `composer.json` as mentioned in the above steps, then register the service provider with your application.

Open `app/config/app.php` and find the `providers` key. Add `ExpressiveDateServiceProvider` to the array.

You can get an instance of Expressive Date through the applications container.

```php
$date = App::make('date');

// Or if you have access to an instance of the application.
$date = $app['date'];
```

You can also use the other instantiation methods described below.

## Usage

Expressive Date is an extension to PHPs [DateTime](http://www.php.net/manual/en/class.datetime.php) class. This means that if you can't do something with Expressive Date you still have the flexibility of `DateTime` at your disposal.

### Getting Instances

Before you can begin working with dates you'll need to get an instance of `ExpressiveDate`. You have a number of options available to you.

```php
// Instantiate a new instance of Expressive Date.
// This will create an instance and use the current date and time
$date = new ExpressiveDate;

// Use the static make method to get an instance of Expressive Date.
$date = ExpressiveDate::make();
```

Both of these methods accepts two parameters, a time string and a timezone. This is identical to the `DateTime` constructor except the second parameters timezone does not need to be an intance of `DateTimeZone`.

```php
// Pass a valid timezone as the second parameter.
$date = new ExpressiveDate(null, 'Australia/Melbourne');

// Or you can still use a DateTimeZone instance.
$timezone = new DateTimeZone('Australia/Melbourne');

$date = new ExpressiveDate(null, $timezone);
```

Alternatively, you can make a date from existing dates or times.

```php
// You can use existing dates to get an instance of Expressive Date.
$date = ExpressiveDate::makeFromDate(2012, 1, 31);

// If you have the time, you can use that instead.
$date = ExpressiveDate::makeFromTime(14, 30, 0);
```

If you use `null` as any of the parameters then Expressive Date will use the current respective value. The only exception to this is if you supply an hour to `ExpressiveDate::makeFromTime()` but no minute or second, instead of defaulting to the current minute or second it will set them to 0. This mimicks the existing functionality when interacting with dates using PHP. 

### Quick Helpers

There are a couple of quick helper methods available to you when using Expressive Date.

```php
$date = new ExpressiveDate; // Creates an instance that uses current date and time

$date->today(); // Sets to todays date, e.g., 1991-01-31 00:00:00

$date->tomorrow(); // Sets to tomorrows date, e.g., 1991-02-01 00:00:00

$date->yesterday(); // Sets to yesterdays date, e.g., 1991-01-30 00:00:00
```

These helpers also set the time to midnight.

### Cloning

You can clone an instance of `ExpressiveDate` with the `clone()` method.

```php
$date = new ExpressiveDate;

$clone = $date->clone();
```

A clone is identical to the original instance and is useful when you need to compare or manipulate a date without affecting the original instance.

### Manipulating Dates

When working with dates you'll often want to manipulate it in a number of ways. Expressive Date eases this process with a simple and intuitive syntax.

```php
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

$date->addOneDay(); // December 2, 2012 12:00:00 PM
$date->addDays(10); // December 12, 2012 12:00:00 PM
$date->minusOneDay(); // December 11, 2012 12:00:00 PM
$date->minusDays(10); // December 1, 2012 12:00:00 PM

$date->addOneWeek(); // December 8, 2012 12:00:00 PM
$date->addWeeks(10); // February 16, 2013, at 12:00:00 PM
$date->minusOneWeek(); // February 9, 2013 12:00:00 PM
$date->minusWeeks(10); // December 1, 2012 12:00:00 PM

$date->addOneMonth(); // January 1, 2013 12:00:00 PM
$date->addMonths(10); // November 1, 2013 12:00:00 PM
$date->minusOneMonth(); // October 1, 2013 12:00:00 PM
$date->minusMonths(10); // December 1, 2012 12:00:00 PM

$date->addOneYear(); // December 1, 2013 12:00:00 PM
$date->addYears(10); // December 1, 2023 12:00:00 PM
$date->minusOneYear(); // December 1, 2022 12:00:00 PM
$date->minusYears(10); // December 1, 2012 12:00:00 PM

$date->addOneHour(); // December 1, 2012 1:00:00 PM
$date->addHours(10); // December 1, 2012 11:00:00 PM
$date->minusOneHour(); // December 1, 2012 10:00:00 PM
$date->minusHours(10); // December 1, 2012 12:00:00 PM

$date->addOneMinute(); // December 1, 2012 12:01:00 PM
$date->addMinutes(10); // December 1, 2012 12:11:00 PM
$date->minusOneMinute(); // December 1, 2012 12:10:00 PM
$date->minusMinutes(10); // December 1, 2012 12:00:00 PM

$date->addOneSecond(); // December 1, 2012 12:00:01 PM
$date->addSeconds(10); // December 1, 2012 12:00:11 PM
$date->minusOneSecond(); // December 1, 2012 12:00:10 PM
$date->minusSeconds(10); // December 1, 2012 12:00:00 PM
```

You can also set the unit manually using one of the setters.

```php
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

$date->setDay(31); // December 31, 2012 12:00:00 PM
$date->setMonth(1); // January 31, 2012 12:00:00 PM
$date->setYear(1991); // January 31, 1991 12:00:00 PM
$date->setHour(6); // January 31, 1991 6:00:00 AM
$date->setMinute(30); // January 31, 1991 6:30:00 AM
$date->setSecond(53); // January 31, 1991 6:30:53 AM
```

There are also several methods to quick jump to the start or end of a day, month, or week.

```php
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

$date->startOfDay(); // December 1, 2012 12:00:00 AM
$date->endOfDay(); // December 1, 2012 11:59:59 PM

$date->startOfWeek(); // 25th November, 2012 at 12:00 AM
$date->endOfWeek(); // 1st December, 2012 at 11:59 PM

$date->startOfMonth(); // December 1, 2012 12:00:00 AM
$date->endOfMonth(); // December 31, 2012 11:59:59 PM
```

The start and end of the week are influenced by what day you configure to be the start of the week. In America, the start of the week is Sunday and for most other places it's Monday. By default the start of the week is Sunday.

```php
$date = new ExpressiveDate('December 1, 2012 12:00:00 PM');

// Set the week start day to Monday, to set it to Sunday you'd use 0.
$date->setWeekStartDay(1);

// You can also use the actual name of the day so it makes more sense.
$date->setWeekStartDay('monday');

$date->startOfWeek(); // 26th November, 2012 at 12:00 AM
```

Lastly you can set the timestamp directly or set it from a string.

```php
$date = new ExpressiveDate;

$date->setTimestamp(time()); // Set the timestamp to the current time.
$date->setTimestampFromString('31 January 1991'); // Set timestamp from a string.
```

### Differences Between Dates

Getting the difference between two dates is very easy with Expressive Date. Let's see how long it's been since my birthday, which was on the 31st January, 1991.

```php
$date = new ExpressiveDate('January 31, 1991');
$now = new ExpressiveDate('December 1, 2012');

$date->getDifferenceInYears($now); // 21
$date->getDifferenceInMonths($now); // 262
$date->getDifferenceInDays($now); // 7975
$date->getDifferenceInHours($now); // 191400
$date->getDifferenceInMinutes($now); // 11484000
$date->getDifferenceInSeconds($now); // 689040000
```

Wow, I'm over 689040000 seconds old!

In the above example I'm explicitly passing in another instance to compare against. You don't have to, by default it'll use the current date and time.

```php
$date = new ExpressiveDate('January 31, 1991');

$date->getDifferenceInYears(); // Will use the current date and time to get the difference.
```

### Comparing Dates

Being able to compare two dates is important in many applications. Expressive Date allows you to compare two `ExpressiveDate` instances against one another in a variety of ways.

```php
$date = new ExpressiveDate;

$date->equalTo($date->clone()); // true
$date->sameAs($date->clone()->minusOneDay()); // false
$date->notEqualTo($date->clone()); // false
$date->greaterThan($date->clone()->minusOneDay()); // true
$date->lessThan($date->clone()->addOneDay()); // true
$date->greaterOrEqualTo($date->clone()); // true
$date->lessOrEqualTo($date->clone()->minusOneDay()); // false
```

The methods themselves should be self explanatory. The `sameAs()` method is an alias of `equalTo()`.

### Interacting With Dates

Expressive Date provides a number of helpful methods for interacting with your dates and times.

```php
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM');

$date->getDay(); // 1
$date->getMonth(); // 12
$date->getYear(); // 2012
$date->getHour(); // 14
$date->getMinute(); // 30
$date->getSecond(); // 50
$date->getDayOfWeek(); // Saturday
$date->getDayOfWeekAsNumeric(); // 6
$date->getDaysInMonth(); // 31
$date->getDayOfYear(); // 335
$date->getDaySuffix(); // st
$date->getGmtDifference(); // +1100
$date->getSecondsSinceEpoch(); // 1354320000
$date->isLeapYear(); // true
$date->isAmOrPm(); // PM
$date->isDaylightSavings(); // true
$date->isWeekday(); // false
$date->isWeekend(); // true
```

### Formatting Dates

It's now time to display your date and time to everyone. Expressive Date comes with a couple of predefined formatting methods for your convenience.

```php
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM');

$date->getDate(); // 2012-12-01
$date->getDateTime(); // 2012-12-01 14:30:50
$date->getShortDate(); // Dec 1, 2012
$date->getLongDate(); // December 1st, 2012 at 2:30pm
$date->getTime(); // 14:30:50

// You can still define your own formats.
$date->format('jS F, Y'); // 31st January, 2012
```

You can set a default date format on each instance of Expressive Date which will then be used when you cast the object to a string.

```php
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM');

echo $date; // 1st December, 2012 at 2:30pm

$date->setDefaultDateFormat('d M y');

echo $date; // 1 Dec 12
```

Expressive Date also comes with a human readable or relative date method.

```php
$date = new ExpressiveDate('December 1, 2012 2:30:50 PM');

$date->getRelativeDate(); // Would show something similar to: 4 days ago
```

You can also pass in an instance of Expressive Date to compare against, and it's date can also be in the future.

```php
$now = new ExpressiveDate('December 1, 2012 2:30:50 PM');
$future = new ExpressiveDate('December 9, 2012 7:45:32 AM');

$now->getRelativeDate($future); // 1 week from now
```

### Working with Timezones

It's always important to factor in timezones when working with dates and times. Because Expressive Date uses PHPs `DateTime` class it'll default to using the date defined with `date_default_timezone_set()`.

If you need to you can manipulate the timezone on the fly.

```php
$date = new ExpressiveDate;

$date->setTimezone('Australia/Darwin');

// Or use an instance of DateTimeZone.
$timezone = new DateTimeZone('Australia/Darwin');

$date->setTimezone($timezone);
```

You can also get an instance of PHPs `DateTimeZone` if you need it for other manipulations.

```php
$date = new ExpressiveDate;

$timezone = $date->getTimezone();
```

Or you can just get the name of the timezone.

```php
$date = new ExpressiveDate;

$timezone = $date->getTimezoneName(); // Australia/Melbourne
```

## Changelog

### 1.0.2

- Added `copy` method.
- Added docblock for magic method hints.
- Added `startOfWeek`, `endOfWeek`, `setWeekStartDay`, and `getWeekStartDay` methods.
- Allowed `setWeekStartDay` to accept the name of the day as a parameter, e.g., Monday.
- Fixed exceptions being thrown when using floats for manipulation, e.g., `ExpressiveDate::addDays(0.5)`.
- Added `makeFromDate`, `makeFromTime`, and `makeFromDateTime` methods.
- Fixed bug with the week start day being inclusive resulting in 8 day weeks.
- Added `equalTo`, `sameAs`, `greaterThan`, `lessThan`, `greaterOrEqualTo`, and `lessOrEqualTo` methods.

### 1.0.1

- Added the `setDefaultDate` method.
- Added `__toString` method which uses the default date.
- Removed the `String` suffix from date formatting methods.

### 1.0.0

 - Initial release.

## License

Expressive Date is licensed under the 2-clause BSD, see the `LICENSE` file for more details.
