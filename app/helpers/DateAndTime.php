<?php
/**
 * DateAndTime Class.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class DateAndTime{

		/**
		 * Converts int (Time) to hours and mins
		 * @param int
		 * @return array
		 */
	public static function convertTime($totalTime)
	{
			//Get the fraction
			$fraction = $totalTime - (int)$totalTime;
			//You guys are smart enough to understand the following...
			$total['hours'] = (int)$totalTime;
			if($fraction == 0.25)
			{
				$total['mins'] = 15;
			}
			elseif($fraction == 0.5)
			{
				$total['mins'] = 30;
			}
			elseif($fraction == 0.75)
			{
				$total['mins'] = 45;
			}
			else
			{
				$total['mins'] = 0;
			}
			return $total;
	}
	/**
	 * Generates whole week from a specific date
	 * @param string
	 * @return array
	 */
	public static function getWeek($date)
	{
		$week = array();
		$allmonths = array(1 =>'January','February','March','April','May','June','July','August','September','October','November','December');
		$tempDate = new ExpressiveDate($date);
		$startWeek = $tempDate->startOfWeek()->getDate();
		$currentDay = new ExpressiveDate($startWeek);
		for($i=0; $i<7; $i++)
		{
			$tempday = array();
			$tempday['day'] = $currentDay->getDay();
			$tempday['year'] = $currentDay->getYear();
			$tempday['dayofweek'] = $currentDay->getDayOfWeek();
			$tempday['month'] = $allmonths[(int)$currentDay->getMonth()];
			$tempday['class'] = 'calendar-day-'.$currentDay->getDate();
			$tempday['date'] = $currentDay->getDate();
			$currentDay = $currentDay->addOneDay();
			$week[] = $tempday;

		}
		return $week;
	}
	/**
	 * Generates whole month from a specific date
	 * @param String
	 * @return array
	 */
	public static function getMonthDates($month)
	{
		$day = new ExpressiveDate($month);
		$totalNoOfDays = (int)$day->getDaysInMonth();
		$daysArray = array();
		for($i = 0; $i<$totalNoOfDays; $i++)
		{
			$daysArray [] = $day->getDate();
			$day = $day->addOneDay();
		}
		return $daysArray;
	}



}
