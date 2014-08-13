<?php namespace Controllers\Domain\Dashboard;

use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;
/**
 * Report Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class ReportController extends \BaseController{

	protected $report;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->report = \App::make('ReportInterface');
	}
	/**
	*  Get the Index Page for Reports
	*  @return View
	*  
	*/
	public function getIndex()
	{
	 	//Get the user id of the currently logged in user
		$userId =  Sentry::getUser()->id;
		//Get Tasks for the user
	 	$tasks = $this->report->getTasks($userId);
	 	//Get Projects for the user
	 	$projects = $this->report->getProjects($userId);
	   	return \View::make('dashboard.reports.index')
	    					->with('tasks',$tasks)
	    					->with('projects',$projects);
	}
	/**
	*  Get the weekly report of the user
	*  @return View
	*/
	public function postWeekly()
	{
		//Get the user id of the currently logged in user
		$userId =  Sentry::getUser()->id;
		//Get the date of the week
		$date = \Input::get('date_submit');
		//Get Week
		$week = \DateAndTime::getWeek($date);
		//Seperate the dates
		$dates = array();
		foreach ($week as $day)
		{
			$dates [] = $day['date'];
		}
		//Get the data
		$data = $this->report->generateWeeklyReport($dates,$userId);
		return \View::make('dashboard.reports.weeklyall')
					->with('dates',$dates)
					->with('week',$week)
					->with('data',$data);
	}
	/**
	*  Get the weekly report for the user for a task
	*  @return View 
	*/
	public function postWeeklyTask()
	{
		//Get the user id of the currently logged in user
		$userId =  Sentry::getUser()->id;
		//Get the date
		$date = \Input::get('weektaskdate_submit');
		//Get the Task Id
		$taskId = \Input::get('task');
		//Get the week
		$week = \DateAndTime::getWeek($date);
		//Seperate the dates from the week
		$dates =  array();
		foreach ($week as $day )
		 {
			$dates [] = $day['date'];
		}
		//Get data
		$data = $this->report->generateWeeklyTaskReport($dates,$taskId,$userId);
		//Format week data
		$tempDates = array();
		foreach ($dates as $day)
		 {

		 	$tempDay = new \ExpressiveDate($day);
			$tempDates [] = $tempDay->format('jS F, Y');

		}
		//Chart Data
		$chartWeek = json_encode($tempDates);
		return \View::make('dashboard.reports.weeklytask')
						->with('dates',$dates)
						->with('week',$week)
						->with('data',$data)
						->with('chartWeek',$chartWeek);

	}
	/**
	*Generate the Weekly Project Report for the user
	*@return View
	*/
	public function postWeeklyProject()
	{
		//Get the user id of the currently logged in user
		$userId =  Sentry::getUser()->id;
		//Get the date
		$date = \Input::get('weekprojectdate_submit');
		//Get the project Id
		$projectId = \Input::get('project');
		//Geneerate Week 
		$week = \DateAndTime::getWeek($date);
		$dates =  array();
		foreach ($week as $day )
		 {
			$dates [] = $day['date'];
		}
		//Get Data
		$data = $this->report->generateWeeklyProjectReport($dates,$projectId,$userId);
		$tempDates = array();
		foreach ($dates as $day) 
		 {

		 	$tempDay = new \ExpressiveDate($day);
			$tempDates [] = $tempDay->format('jS F, Y');

		}
		//Chart Labels
		$chartWeek = json_encode($tempDates);
		//Chart Data
		$chartWeekData = json_encode($data['dayTime'],JSON_NUMERIC_CHECK);
		return \View::make('dashboard.reports.weeklyproject')
					->with('dates',$dates)
					->with('week',$week)
					->with('data',$data)
					->with('chartWeek',$chartWeek)
					->with('chartWeekData',$chartWeekData);

	

	}
	/**
	* Generate the Monthly Report for the User
	* @return View
	*/
	public function postMonthly()
	{
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Get the selected date of the month
		$selectedMonth = \Input::get('monthall_submit');
		//Generate month from the selected date
		$daysArray = \DateAndTime::getMonthDates($selectedMonth);
		//Get the datt
		$data = $this->report->generateWeeklyReport($daysArray,$userId);
		//Manipulation for View
		$tempDate = new \ExpressiveDate($selectedMonth);
		$year = $tempDate->getYear();
		$month = $tempDate->getMonth();
		$totalNoOfDays = (int)$tempDate->getDaysInMonth();
		$allmonths = array(1 =>'January','February','March','April','May','June','July','August','September','October','November','December');
		$firstName = Sentry::getUser()->first_name;
		$lastName = Sentry::getUser()->last_name;
		return \View::make('dashboard.reports.monthlyall')
						->with('totalDays',$totalNoOfDays)
						->with('name',$firstName.$lastName)
						->with('dates',$daysArray)
						->with('year',(int)$year)
						->with('month',$allmonths[(int)$month])
						->with('data',$data);
	}
	/**
	*  Generate the Monthly Task Report for the user
	*  @return View
	*/
	public function postMonthlyTask()
	{
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Get the selected date of the month
		$selectedMonth = \Input::get('monthtaskdate_submit');
		//Get the Task Id
		$taskId = \Input::get('monthtask');
		//Generate the Month from the date
		$daysArray = \DateAndTime::getMonthDates($selectedMonth);
		//Get the data
		$data = $this->report->generateWeeklyTaskReport($daysArray,$taskId,$userId);
		//Manipulation for View
		$tempDate = new \ExpressiveDate($selectedMonth);
		$year = $tempDate->getYear();
		$month = $tempDate->getMonth();
		$totalNoOfDays = (int)$tempDate->getDaysInMonth();
		$allmonths = array(1 =>'January','February','March','April','May','June','July','August','September','October','November','December');
		$tempDates = array();
		foreach ($daysArray as $day) 
		 {

		 	$tempDay = new \ExpressiveDate($day);
			$tempDates [] = $tempDay->format('jS F, Y');

		}
		//Chart Labels
		$chartWeek = json_encode($tempDates);
		$firstName = Sentry::getUser()->first_name;
		$lastName = Sentry::getUser()->last_name;
		return \View::make('dashboard.reports.monthlytask')
					->with('data',$data)
					->with('name',$firstName.$lastName)
					->with('totalDays',$totalNoOfDays)
					->with('dates',$daysArray)
					->with('year',(int)$year)
					->with('month',$allmonths[(int)$month])
					->with('chartWeek',$chartWeek);

	}
	/**
	* Generate the Monthly Project Report for the user
	* @return Viuew
	*/
	public function postMonthlyProject()
	{
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Get the selected date for the month
		$selectedMonth = \Input::get('monthprojectdate_submit');
		//Get the project Id
		$projectId = \Input::get('monthproject');
		//Genrate Month from the date
		$daysArray = \DateAndTime::getMonthDates($selectedMonth);
		//Get data
		$data = $this->report->generateWeeklyProjectReport($daysArray,$projectId,$userId);
		//Manipulation for View
		$tempDates = array();
		foreach ($daysArray as $day) 
		 {

		 	$tempDay = new \ExpressiveDate($day);
			$tempDates [] = $tempDay->format('jS F, Y');

		}
		//Chart Labels
		$chartWeek = json_encode($tempDates);
		$tempDate = new \ExpressiveDate($selectedMonth);
		$year = $tempDate->getYear();
		$month = $tempDate->getMonth();
		$totalNoOfDays = (int)$tempDate->getDaysInMonth();
		//Manipulation for View
		$allmonths = array(1 =>'January','February','March','April','May','June','July','August','September','October','November','December');
		$chartWeekData = json_encode($data['dayTime'],JSON_NUMERIC_CHECK);
		$firstName = Sentry::getUser()->first_name;
		$lastName = Sentry::getUser()->last_name;
		return \View::make('dashboard.reports.monthlyproject')
						->with('data',$data)
					->with('name',$firstName.$lastName)
					->with('totalDays',$totalNoOfDays)
					->with('dates',$daysArray)
					->with('year',(int)$year)
					->with('month',$allmonths[(int)$month])
					->with('chartWeek',$chartWeek)
					->with('chartWeekData',$chartWeekData);

	}
	/**
	* Project Report
	* @return View
	*/
	public function postProjectReport()
	{
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Get the Project Id
		$projectId = \Input::get('projectid');
		//Get Data
		$data = $this->report->generateProjectReport($projectId,$userId);
		return \View::make('dashboard.reports.projectreport')
					->with('project',$data);

	}
	/**
	* Generate the Monthly Project Report for Selected User
	* @return View
	*/
	public function postUserProjectReport()
	{
		//Get the selected UserId
		$userId = \Input::get('userprojectreportid');
		//Get Details of User
		$user = \User::find($userId);
		$firstName = $user->first_name;
		$lastName = $user->last_name;
		//Get selected Project Id
		$projectId = \Input::get('projectmonth');
		//Get the selected Date for the month
		$selectedMonth = \Input::get('userprojectdate_submit');
		//Generate Month from the date
		$daysArray = \DateAndTime::getMonthDates($selectedMonth);
		//Get Data
		$data = $this->report->generateWeeklyProjectReport($daysArray,$projectId,$userId);
		//Manipulation for View
		$tempDates = array();
		foreach ($daysArray as $day) 
		 {

		 	$tempDay = new \ExpressiveDate($day);
			$tempDates [] = $tempDay->format('jS F, Y');

		}
		//Manipulation for Charts
		$chartWeek = json_encode($tempDates);
		$tempDate = new \ExpressiveDate($selectedMonth);
		$year = $tempDate->getYear();
		$month = $tempDate->getMonth();
		$totalNoOfDays = (int)$tempDate->getDaysInMonth();
		$allmonths = array(1 =>'January','February','March','April','May','June','July','August','September','October','November','December');
		$chartWeekData = json_encode($data['dayTime'],JSON_NUMERIC_CHECK);
		return \View::make('dashboard.reports.monthlyproject')
						->with('data',$data)
					->with('name',$firstName.$lastName)
					->with('totalDays',$totalNoOfDays)
					->with('dates',$daysArray)
					->with('year',(int)$year)
					->with('month',$allmonths[(int)$month])
					->with('chartWeek',$chartWeek)
					->with('chartWeekData',$chartWeekData);
	}
}
