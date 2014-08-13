<?php 
use \Timesheet as Timesheet;
use \SomeThingWentWrongException as SomeThingWentWrongException;
/**
 * Timesheet Repository.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class TimesheetRepository implements TimesheetInterface{


	public function getIndex($userId)
	{
		//Get Tasks
		$tasks = \User::find($userId)->tasks()->orderBy('name')->get()->toArray();
		return $tasks;
	}
	
	public function addEntry($data, $userId)
	{	try
		{
				$result = static::convertTime($data['starttime_submit'],$data['endtime_submit']);
				//New instance of Timesheet
				$timesheetEntry = new Timesheet;
				//Assign data
				$timesheetEntry->title = $data['title'];
				$timesheetEntry->date = $data['date_submit'];
				if($data['task'] == 'others')
				{
					$timesheetEntry->task_id = null;
				}
				else
				{
					$timesheetEntry->task_id = $data['task'];

				}
				$timesheetEntry->total_time_spent = $result['totalHours'];
				$timesheetEntry->total_hours = $result['hours'];
				$timesheetEntry->total_minutes = $result['mins'];
				$timesheetEntry->start_time = $data['starttime_submit'];
				$timesheetEntry->end_time = $data['endtime_submit'];
				if($data['details'] == '')
				{
					$timesheetEntry->details = null;
				}
				else
				{
					$timesheetEntry->details = $data['details'];

				}
				if($data['remarks'] == '')
				{
					$timesheetEntry->remarks = null;
				}
				else
				{
					$timesheetEntry->remarks = $data['remarks'];

				}
				$timesheetEntry->user_id = $userId;
				$timesheetEntry->updated_by = $userId;
				$timesheetEntry->save();
				return 'success';
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Timesheet Repository - addEntry():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}
	}
	public function getEntries($day, $userId)
	{
		try
		{
				//Get the entries
				$tempEntries = Timesheet::where('date',$day)->where('user_id',$userId)->get()->toArray();
				$finalEntries = array();
				//Get Task Name
				foreach ($tempEntries as $entry) 
				{
				
					if($entry['task_id'] != null)
					{
						$entry['task'] = \Task::find($entry['task_id'])->toArray();

					}
					else
					{
						$entry['task'] = null;
					}
					
					$finalEntries[] = $entry;
				}
				return $finalEntries;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Timesheet Repository - getEntries():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}
	}
	public function deleteEntry($id)
	{
		try
		{
			$result = Timesheet::where('id',$id)->forceDelete();
			return true;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Timesheet Repository - deleteEntry():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}
		
	}
	public function getWeek($date)
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
	public function getEntry($id)
	{
		$entry = \Timesheet::where('id',$id)->get(array('id','title','task_id','date','start_time','end_time','details','remarks'))->toArray();
		return $entry;
	}

	public function convertTime($startTime,$endTime)
	{
				$data= array();
				$time1 = strtotime($startTime);  
				$time2 = strtotime($endTime);  
				$result = ($time2 - $time1);
				if($result < 0)
				{
					throw new Exception("Start Time cannot be later than End Time", 1);
				}
				$data['hours'] = floor($result / 3600);
				$data['mins'] = floor(($result - ($data['hours']*3600)) / 60);
				$intMins = 0;
				if($data['mins'] == 15)
				{
					$intMins = 0.25;
				}
				if($data['mins'] == 30)
				{
					$intMins = 0.50;
				}
				if($data['mins'] == 45)
				{
					$intMins = 0.75;
				}

				$data['totalHours'] = $data['hours'] + $intMins;
				return $data;
	}
	public function editEntry($data)
	{
		try
		{
		
            
					$entry = \Timesheet::find($data['entryid']);
					$entry->title = $data['title'];
                    $tempDate =\DateTime::createFromFormat('j F, Y',$data['date']);
					$entry->date = $tempDate->format('Y-m-d');
					if($data['starttime_submit'] != '' && $data['endtime_submit'] != '')
					{
							$result = static::convertTime($data['starttime_submit'],$data['endtime_submit']);
							$entry->total_time_spent = $result['totalHours'];
							$entry->total_hours = $result['hours'];
							$entry->total_minutes = $result['mins'];
							$entry->start_time = $data['starttime_submit'];
							$entry->end_time = $data['endtime_submit'];
					}
					else if($data['starttime_submit'] != '')
					{
							$result = static::convertTime($data['starttime_submit'],$entry->end_time);
							$entry->total_time_spent = $result['totalHours'];
							$entry->total_hours = $result['hours'];
							$entry->total_minutes = $result['mins'];
							$entry->start_time = $data['starttime_submit'];
							
					}
					else if($data['endtime_submit'] != '')
					{
							$result = static::convertTime($entry->start_time,$data['endtime_submit']);
							$entry->total_time_spent = $result['totalHours'];
							$entry->total_hours = $result['hours'];
							$entry->total_minutes = $result['mins'];
							$entry->end_time = $data['endtime_submit'];
					}
					else
					{
						// Do nothing
					}
					if($data['task'] == 'others')
					{
						$entry->task_id = null;
					}
					else
					{
						$entry->task_id = $data['task'];

					}
					if($data['details'] == '')
					{
						$entry->details = null;
					}
					else
					{
						$entry->details = $data['details'];

					}
					if($data['remarks'] == '')
					{
						$entry->remarks = null;
					}
					else
					{
						$entry->remarks = $data['remarks'];

					}
					$entry->save();
					return 'success';
		}
		catch(\Exception $e)
		{
			\Log::error("Something Went Wrong in Timesheet Repository - editEntry():".$e->getMessage());
			return 'error';
		}
	}
	public function checkPermission($entryId,$userId)
	{
		$entry = \Timesheet::find($entryId);
		if($entry->user_id == $userId)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
}