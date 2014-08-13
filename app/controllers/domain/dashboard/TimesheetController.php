<?php namespace Controllers\Domain\Dashboard;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;

/**
 * Timesheet Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

class TimesheetController extends \BaseController{

		protected $timesheet;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->timesheet = \App::make('TimesheetInterface');
	}
	/**
	* Get all entries for the current day for logged in user
	* @return View
	*/
	public function getIndex()
	{
		
		//Get the user id of the currently logged in user
        $userId =  Sentry::getUser()->id;
        //Current Date
		$day = date("Y-m-d");
        //Get tasks list for the user
		$tasks = $this->timesheet->getIndex($userId);
        //Get the entries
		$entries = $this->timesheet->getEntries($day,$userId);
        //Current Week
		$week = $this->timesheet->getWeek($day);
		return \View::make('dashboard.timesheet.view')
						->with('week',$week)
						->with('selectedDate',$day)
						->with('entries', $entries)
						->with('tasks',$tasks);
	}
	/**
	* Get entries of the dat for the currently logged in user
	*	@param Date
	*	@return JSON
	*/
    
	public function getEntries($day)
	{
		//Get the user id of the currently logged in user
		$userId =  Sentry::getUser()->id;
		//Get Data
		$entriesArray = $this->timesheet->getEntries($day,$userId);
		//Encode to JSON format
		$entriesJson = json_encode($entriesArray);
		return $entriesJson;
	}
	/**
	* Add Entry for the currently logged in user
	* @return Redirect
	*/
	public function addEntry()
	{
		//Get all data
		$data = \Input::all();
		//Get the user id of the currently logged in user
		$userId =  Sentry::getUser()->id;
		//Add Data
		$result = $this->timesheet->addEntry($data,$userId);
		//Redirect with appropriate message to the user
		if($result == 'success')
		{
			return \Redirect::to('dashboard/timesheet')->with('status','success')->with('message','Entry Added');
		}
		else
		{
			return \Redirect::to('dashboard/timesheet')->with('status','error')->with('message','Something Went Wrong. Please try again.');
		}

	}
	/**
	* Delete Timesheet Entry
	* @return Redirect
	*/
	public function deleteEntry()
	{
		//Get Entry Id 
		$entryId = \Input::get('entryId');
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Check if the user has the permission
		$checkpermission = $this->timesheet->checkPermission($entryId,$userId);
		if($checkpermission)
		{
			//Delete Entry
			$result = $this->timesheet->deleteEntry($entryId);
			//Redirect user with appropriate message
			if($result == true)
			{
				return \Redirect::to('dashboard/timesheet')->with('status','success')->with('message','Entry Deleted');
			}
			else
			{
				return \Redirect::to('dashboard/timesheet')->with('status','error')->with('message','Something Went Wrong. Please try again.');
			}
		}
		else
		{
			//Not Authorised
			throw new \NotAuthorizedForTimesheetEntryException();
		}
	}
	/**
	* Get entries for selected date
	* @return View
	*/
	public function getDateEntries()
	{
		//Get Date
		$dateSubmit = \Input::get('eventDate_submit');
		//Get Week
		$week = $this->timesheet->getWeek($dateSubmit);
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Get Tasks List
		$tasks = $this->timesheet->getIndex($userId);
		//Get Entries
		$entries = $this->timesheet->getEntries($dateSubmit,$userId);
		return \View::make('dashboard.timesheet.view')
					->with('week',$week)
					->with('tasks',$tasks)
					->with('selectedDate',$dateSubmit)
					->with('entries', $entries);
	}
	/**
	* Get View for Edit Entry
	* @param int
	* @return View
	*/
	public function getEditEntries($id)
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Check Permission
		$checkpermission = $this->timesheet->checkPermission($id,$userId);
		if($checkpermission)
		{		//Authorisex
				//Get Entry from the Database
				$entry = $this->timesheet->getEntry($id);
				//Get Tasks List
				$tasks = $this->timesheet->getIndex($userId);
				return \View::make('dashboard.timesheet.edit')
						->with('tasks',$tasks)
						->with('entry',$entry[0]);
		}
		else
		{
			//Not Authorised
			throw new \NotAuthorizedForTimesheetEntryException();
		}
	}
	/**
	* Update Timesheet Entry
	* @return Redirect
	*/
	public function postEditEntry()
	{
		//Get all Data
		$data = \Input::all();
		//Update Entry
		$result = $this->timesheet->editEntry($data);
		//Redirect User with appropriate message
		if($result == 'success')
		{
			return \Redirect::to('dashboard/timesheet')->with('status','success')->with('message','Entry Updated');
		}
		else
		{
			return \Redirect::to('dashboard/timesheet')->with('status','error')->with('message','Something Went Wrong. Please try again.');
		}
	}
}