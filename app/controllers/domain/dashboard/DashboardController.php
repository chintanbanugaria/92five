<?php namespace Controllers\Domain\Dashboard;
use \Log as Log;
use \User as User;
use \Task as Task;
use \Todos as Todos;
use \Input as Input;
use \Project as Project;
use \Response as Response;
use \Exception as Exception;
use \Quicknote as Quicknote;
use \Taskcollabs as TaskUsers;
use \Projectcollabs as ProjectUsers;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;
use Cartalyst\Sentry\Users\UserNotFoundException as UserNotFoundException;
/**
 * Dashboard Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

class DashboardController extends \BaseController{

		
	/**
	*	Dashboard
	*/
	public function getIndex()
	{
		//Get Tasks Data
		$tasks = $this->getTasks();
		
		//Get Projects Data
		$projects = $this->getProjects();
        
		//Get Today's Agenda
        $events = $this->getAgenda();
		
		return \View::make('dashboard.index')
					->with('tasks', $tasks)
                    ->with('events',$events)
				->with('projects',$projects);
	}

	/**
	*	Tasks Data for Dashboard Page
	*/
	public function getTasks()
	{
		try
		{
			//Get the user id of the currently logged in user
			$userId =  Sentry::getUser()->id;
		
			//Get all the task ids assigned to user
			$taskList = TaskUsers::where('user_id',$userId)->lists('task_id');
			
			if($taskList != null)
			{
				//Total Tasks Assigned
				$totalTasks = count($taskList);

				//Total Number of Completed Tasks
				$completedTasks = Task::whereIn('id',$taskList)->where('status','completed')->count();
			
				//Total Number of pending Tasks
				$pendingTasks = $totalTasks - $completedTasks;
			
				//Percentage of Completed Tasks
				$percentage = (int) (($totalTasks - $pendingTasks)*100)/$totalTasks;
			
				//Wrap up all data
				$tasks = array(
						'totalTasks' => $totalTasks,
						'completedTasks' => $completedTasks,
						'pendingTasks' => $pendingTasks,
						'percentage' => $percentage,
				);
						
				return $tasks;
			}
			else
			{
				//Everything Zero
				$tasks = array(
						'totalTasks' => 0,
						'completedTasks' => 0,
						'pendingTasks' => 0,
						'percentage' => 0,
				);
						
				return $tasks;
			}
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for getTasks in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong - in getTasks in Dashboard');
			throw new \SomethingWentWrongException ();
		}

	}

	/**
	*	Project Data for Dashboard Page
	*/
	public function getProjects()
	{
		try
		{
			//Get the user id of the currently logged in user
			$userId =  Sentry::getUser()->id;
						
			//Get the list of projects id collaborated to the current user
			$projectIdsList = ProjectUsers::where('user_id', $userId)->lists('project_id');
			
			if(count($projectIdsList)!=0)
			{
				$data;
				foreach ($projectIdsList as $projectId) 
				{
					//Get the Name and Id of the project
					$tempProject = Project::where('id', $projectId)->get(array('id','project_name'));
					//Total Number of Tasjs
					$totalTask = Task::where('project_id',$projectId)->count();
					//Get all Task Ids associated with the project
					$totalTaskList =  Task::where('project_id',$projectId)->lists('id');
					if(sizeof($totalTaskList) == 0)
					{
						//No tasks so everything is zero
						$arrayProject = (array)json_decode($tempProject,1);
						$arrayProject[0]['remainingTasks'] = 0;
						$arrayProject[0]['percentage'] = 0;
						$arrayProject[0]['total_task'] = 0;
						$data[] = $arrayProject;
					}
					else
					{
						//Get the total number of tasks active and or delayed				
						$totalRemainingTask = Task::whereNested(function($query) use ($projectId){
																$query->where('project_id',$projectId);
																$query->where('status','active');
																})
																->orWhere(function($query) use ($projectId){
																$query->where('project_id',$projectId);
																$query->where('status','delayed');
																})->count();
						
						$arrayProject = (array)json_decode($tempProject,1);
						$arrayProject[0]['remainingTasks'] = $totalRemainingTask;
						//Calculate the percentage for the status bar
						$arrayProject[0]['percentage'] = (($totalTask - $totalRemainingTask)*100)/$totalTask;
						$arrayProject[0]['total_task'] = $totalTask;
						$data[] = $arrayProject;
					}
									
				}

				//Transfer data
				$projects;
				foreach ($data as $key) 
				{
				   	$projects[]=$key[0];
				}

				return $projects; 
			}
			else
			{
				return null;
			}
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for getProjects in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong in getProjects in Dashboard - '.$e->getMesage());
			throw new \SomethingWentWrongException();
		}

	}

	/**
	*	Get To-dos
	*/
	public function getToDos()
	{
		try
		{
			//Get the user id of the currently logged in user
			$userId = (int) Sentry::getUser()->id;
			//Get Todos
			$todos = Todos::where('user_id','=',$userId)->orderBy('created_at','DESC')->get(array('id','text','status'))->toJson();
			return $todos;
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for getTodos in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong in getTodos in Dashboard - '.$e->getMesage());
			throw new \SomethingWentWrongException();
		}
	}

	/**
	* Update To-do
	*/
	public function putToDos($id)
	{
		try
		{
			//Get the user id of the currently logged in user
			$userId = (int) Sentry::getUser()->id;
			$data = Input::json()->all();
			$todos = Todos::where('id','=',$data['id'])->where('user_id','=',$userId)->first();
			$todos->status = $data['status'];
			//update the to-do
			$todos->save();
			return Response::make('Todo Updated !', 200);
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for putTodos in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong in putTodos in Dashboard - '.$e->getMesage());
			throw new \SomethingWentWrongException();
		}
			
	}

	/**
	*	Get Quick note for the use
	*/
	public function getQuickNote()
	{
		try
		{
			//Get the user id of the currently logged in user
			$userId = (int) Sentry::getUser()->id;
			$note = Quicknote::where('user_id','=',$userId)->get(array('id','text'))->first()->toJson();
			return $note;
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for getQuickNote in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong in getQuickNote in Dashboard - '.$e->getMesage());
			throw new \SomethingWentWrongException();
		}
		
	}

	/**
	* Update Quick Note
	*/
	public function putQuickNote()
	{
		try
		{
			//Get the user id of the currently logged in user
			$userId = (int) Sentry::getUser()->id;
			$data = Input::json()->all();
			$note = Quicknote::where('user_id','=',$userId)->first();
			$note->text = $data['text'];
			$note->save();
			return Response::make('Quick Note Updated !', 200);
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for putQuickNote in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong in putQuickNote in Dashboard - '.$e->getMesage());
			throw new \SomethingWentWrongException();
		}
		
	}

	/**
	*	Get all users list
	*/
	public function getUsersList()
	{
		$users = \User::get(array('first_name','last_name','email'))->toJson();
		return $users;
	}

	/**
	*	Get all the userslist collaborated to the project
	*/
	public function getProjectUsersList($id)
	{
		$userList = ProjectUsers::where('project_id',$id)->lists('user_id');
		$users = User::whereIn('id',$userList)->get(array('first_name','last_name','email','id'))->toJson();
		return $users;

	}

	/**
	*	Delete File
	*/
	public function getDeleteFile($id)
	{
		// Get the Id of the file
		$file = \Files::find($id);
		if($file == null)
		{
			//File doesnt Exists
			return Response::json('error', 400);
		}
		else
		{
			if(file_exists($file['file_sys_ref'].$file['file_md5']))
			{
				//Delete the file from the system
				Log::info('File '.$file['file_name'].' deleted by '.Sentry::getUser()->id);
				\File::delete($file['file_sys_ref'].$file['file_md5']);
				$file->forceDelete();
				return Response::json('success', 200);
			}
			else
			{
				Log::error(Sentry::getUser()->id.' tried to delete the file '.$file['file_name'].' but it doesnt exists on the disk !');
				$file->forceDelete();
				throw new \FileNotFoundException();
				
			}
		}
	}
	/**
	* Download a File
	*/
	public function getDownloadFile($md5)
	{
		//Get the file
		$file = \Files::where('key','=', $md5)->first();
		//Check if file exists
		if(file_exists($file['file_sys_ref'].$file['file_md5']))
		{
			return Response::download($file['file_sys_ref'].$file['file_md5'], $file['file_name']);
		}
		else
		{
			Log::error("File ".$file['file_name']." does not exists.");
			throw new \FileNotFoundException();
		}

	}
	/**
	* Get Todays Agenda 
	*/
    public function getAgenda()
    {
        try
		{
			//Get the user id of the currently logged in user
        	$userId =  Sentry::getUser()->id;
        	$day = date("Y-m-d");
        	//Get the data 
        	$data = \App::make('CalendarInterface')->getEvents($userId,$day);
        	$newData =  array();
        	if(sizeof($data) != 0)
        	{

	        	foreach($data as $entry)
	        	{
	        		//Parse the data
	            	$tempFrom = substr($entry['start_time'],0,-3);
	           		$entry['fromClass'] = str_replace(":","-",$tempFrom);
	            	$tempTo =  substr($entry['end_time'],0,-3);
	            	$entry['toClass'] = str_replace(":","-",$tempTo);
	            	$newData [] = $entry;
	        	}
	       	}
	       	return $newData;
    	}
    	catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong - User Not found for getAgenda in Dashboard');
			throw new \UserNotFoundException ();
		}
		catch(Exception $e)
		{
			Log::error('Something Went Wrong in getAgenda in Dashboard - '.$e->getMesage());
			throw new \SomethingWentWrongException();
		}
    }

}