<?php namespace Controllers\Domain\Dashboard;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;

/**
 * Calendar Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

class CalendarController extends \BaseController{

	protected $event;

	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->event = \App::make('CalendarInterface');
	}
	/**
	* Get the event dates and events for the currently logged in user
	* @return View
	*/
	public function getIndex()
	{

			//Get the user id of the currently logged in user
			$userId =  \Sentry::getUser()->id;
			//Current Date
			$day = date("Y-m-d");
			//Get events for current date
			$events = $this->event->getEvents($userId,$day);
			//Get all  event dates for the user
			$eventDates = $this->event->getEventDates($userId);
			$todaysDate = new \ExpressiveDate();
		    return \View::make('dashboard.calendar.view')
		   				->with('todaysDate',$todaysDate)
		   				->with('eventDates',$eventDates)
		   				->with('events', $events);
		
	}
	/**
	*	Add Event
	* @return Redirect
	*/
	public function addEvent()
	{
		//Get all the data
		$data = \Input::all();
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Add event
		$result = $this->event->addEvent($data,$userId);
		return \Redirect::to('dashboard/calendar')->with('status','success')->with('message','Entry Added');
	  
	}
	/**
	* Get Events for a custom day for currently looged in user
	* @return JSON
	*/
	public function getEvents($day)
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Get the events
		$events =  $this->event->getEvents($userId,$day);
		$jsonEvents = json_encode($events);
		return  $jsonEvents;
		
	}
	/**
	*  Delete Event
	*  @return Redirect 
	*/
	public function deleteEvent()
	{
		$eventId = \Input::get('deleteEventId');
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Check permission
		$checkpermission = $this->event->checkPermission($eventId,$userId);
		if($checkpermission)
		{
			//Authorized, Delete Event
			$result = $this->event->deleteEvent($eventId,$userId);
			if($result == 'success')
			{
				return \Redirect::to('dashboard/calendar')->with('status','success')->with('message','Entry Deleted');
			}
			else
			{
				//Something went wrong
				return \Redirect::to('dashboard/calendar')->with('status','error')->with('message','Something Went Wrong. Please try again.');
			}
		}
		else
		{
			throw new \NotAuthorizedForEventException();
		}
	}
	/**
	*  View for Edit Event
	*  @return View
	*/
	public function getEditEvent($id)
	{
		try
		{
			$event = \Events::findOrFail($id);
		}
		catch(ModelNotFoundException $e)
		{
			throw new \EventNotFoundException();
		}
		$emaillist = null;
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Check Permission
		$checkpermission = $this->event->checkPermission($id,$userId);
		if($checkpermission)
		{
			//Authorized, Get Event
			$event = $this->event->getEvent($id);
			foreach ($event['users'] as $user)
		 	{
				if($emaillist == null)
				{
					$emaillist = $user['email'];
				}
				else
				{
					$emaillist = $emaillist.','.$user['email'];
				}
				
			}
			//Wrap Up and generate View	
			return \View::make('dashboard.calendar.edit')
					->with('emaillist',$emaillist)
					->with('event',$event);
		}
		else
		{
			throw new \NotAuthorizedForEventException();
		}
	}
	/**
	* Update Event
	* @return Redirect
	*/
	public function postEditEvent($id)
	{
		//Get all the data
		$data = \Input::all();
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//update Event
		$result = $this->event->editEvent($data,$userId);
		if($result == 'success')
		{
			//Success, Done
			return \Redirect::to('dashboard/calendar')->with('status','success')->with('message','Entry Updated');
		}
		else
		{
			//Error while updating, Notify User
			return \Redirect::to('dashboard/calendar')->with('status','error')->with('message','Something Went Wrong. Please try again.');
		}
	}
	/**
	* Get all events created by a Currently Logged on User
	* @return View
	*/
	public function getEventsCreatedByMe()
	{
		$userId = \Sentry::getUser()->id;
		$events = $this->event->getEventsCreatedByUser($userId);
        return \View::make('dashboard.calendar.createdbyme')
                    ->with('events',$events);
	}
}