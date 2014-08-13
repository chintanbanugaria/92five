<?php namespace Controllers\Domain\Dashboard;
use \Task as Task;
use \Project as Project;
use \Projectcollabs as ProjectUsers;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
/**
 * Task Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

class TaskController extends \BaseController{

	protected $tasks;
	/**
	* Constructo
	*/
	public function __construct()
	{
		$this->tasks = \App::make('TaskInterface');
		                      
	}
	/**
	* Get all assigned task for the logged in user
	* @return View
	*/
	public function getIndex()
	{
		//Get the user id of the currently logged in user
		$user_id =  Sentry::getUser()->id;
		//Get the tasks
		$userTasks = $this->tasks->all($user_id);		
		//Manipulation
		$projects = $userTasks['projects'];
		$projectName = $userTasks['name_proj'];
		unset($userTasks['projects']);
		unset($userTasks['name_proj']);
        return \View::make('dashboard.tasks.list')
						->with('projects',$projects)
						->with('tasks',$userTasks)
						->with('projectName',$projectName);
	}
	/**
	* Update the status of the task
	* @return JSON object
	*/
	public function updateStatus($id)
	{
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Get all the data
		$data = \Input::json()->all();
		//Update the status
		$result =  $this->tasks->updateStatus($data,$userId);
		if($result == 'success')
		{
			//Task updated. Good to go
			return \Response::json('success', 200);
		}
		else
		{
			//Something went wrong
			return \Response::json('error', 500);
		}		
	}
	/**
	* Get projects for specific task
 	* @return View
 	*
 	*/
	public function getProjectsTasks($projectId)
	{
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		try
		{
			//Check if project exists
			$project = Project::findOrFail($projectId);

		}
		catch(ModelNotFoundException $e)
		{
			//Project Not Found
			throw new \ProjectNotFoundException();
		}
		//Get tasks
		$data = $this->tasks->getProjectTasks($projectId, $userId);
		//Manipulation
		$projects = $data['projects'];
		$projectName = $data['name_proj'];
		unset($data['projects']);
		unset($data['name_proj']);
		return \View::make('dashboard.tasks.list')
						->with('projects',$projects)
						->with('tasks',$data)
						->with('projectName',$projectName);
	}
	/**
	* Generate Add Task View
	* @return View
	*/
	public function getAddTasks()
	{
		
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Get the project List
		$projectslist = ProjectUsers::where('user_id', $userId)->lists('project_id');
		 if(sizeof($projectslist) != 0)
		 {
		 	//Get the list of projects
		 	$projects = \Project::whereIn('id', $projectslist)->orderBy('project_name')->get(array('id','project_name'))->toArray();
			return \View::make('dashboard.tasks.add')
					->with('projects',$projects);
		}
		else
		{
			//No Projects
			$projects = null;
			return \View::make('dashboard.tasks.add')
					->with('projects',$projects);

		}
	}
	/**
	* Add Task Data
	* @return JSON
	*/
	public function postAddTask()
	{
		//Get all the data
		$data = \Input::json()->all();
		//Get the user id of the currently logged in user	
		$userId = Sentry::getUser()->id;
		//Add data
		$result = $this->tasks->addTask($data, $userId);
		if($result['status'] == 'success')
		{
				//Everything went well
				return \Response::json(array(
		        'error' => false,
		        'id' => $result['id'],
		        'status'=>'add'),
		        200);
		}
		else
		{		//Something went wrong
				return \Response::json(array(
				        'error' => true),
				        500);
		}		
	}
	/**
	* Add Sub Task
	* @return JSON
	*/
	public function postAddSubTask()
	{
		//Get all data
		$data = \Input::json()->all();	
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		//Add Subtask
		$result = $this->tasks->addSubTask($data, $userId);
		if($result['status'] == 'success')
		{
				//Everything went well
				return \Response::json(array(
		        'error' => false,
		        'id' => $result['id']),
		        200);

		}
		else
		{
				//Something went wrong
				return \Response::json(array(
				'error' => true),
				500);

		}
	}
	/**
	* Delete Sub Task
	* @return JSON
	*/
	public function deleteSubTask($id)
	{
		//Detle sub task
		$result = $this->tasks->deleteSubTask($id);
		if($result == 'success')
		{
			//Everything went wll
			return \Response::json(array(
        	'error' => false),
       		200);
		}
		else
		{
			//Something went wrong
			return \Response::json(array(
		    'error' => true),
		     500);
		}
	}
	/**
	* View for Add Files
	* @return View
	*/
	public function getAddFiles($taskId)
	{
		//Check if Task Exists
		try
		{
			$task = Task::findOrFail($taskId);
		}
		catch(ModelNotFoundException $e)
		{
			throw new \TaskNotFoundException();
		}
		//Get the user id of the currently logged in user	
		$userId = Sentry::getUser()->id;
		//Check Permission
		$result = $this->tasks->checkPermission($taskId, $userId);
		if($result == 'success')
		{
			//Authorized
			$taskName= Task::where('id','=',$taskId)->pluck('name');
			return \View::make('dashboard.projects.addfile')
							->with('parentType', 'Task')
							->with('parentName', $taskName)
							->with('parentId', $taskId);
		}
		else
		{
			//Not Authorized
			throw new \NotAuthorizedForTaskException();
		}	
	}
	/**
	* Upload files and add it to the task
	* @return JSON
	*/
	public function postAddFiles($taskId)
	{
			//Get the file
			$file = \Input::file('file');
			//Get the user id of the currently logged in user	
			$userId = Sentry::getUser()->id;
			//Upload the file
			$result = \Fileupload::upload($file,$taskId,'task',$userId);
			return $result;
	}

	/**
	* View the task
	* @return View
	*/
	public function getViewTask($taskId)
	{
		//Check if Task Exists
		try
		{
			$task = Task::findOrFail($taskId);
		}
		catch(ModelNotFoundException $e)
		{
			throw new \TaskNotFoundException();
		}
		//Get the user id of the currently logged in user	
		$userId = Sentry::getUser()->id;
		//Check the permission
		$result = $this->tasks->checkPermission($taskId, $userId);
		if($result == 'success')
		{
			//Authorized
			$data = $this->tasks->viewTask($taskId);
            $subTasks = $this->tasks->subTasks($taskId);
            return \View::make('dashboard.tasks.view')
					->with('task', $data[0])
                    ->with('subtasks',$subTasks);
		}
		else
		{
			//Not Authorized
			throw new \NotAuthorizedForTaskException();	
		}
	}
	/**
	* View for Task Editing
	* @param TaskId
	* @return View
	*/
	public function getEditTask($taskId)
	{
		try
		{
			$task = Task::findOrFail($taskId);
		}
		catch(ModelNotFoundException $e)
		{
			throw new \TaskNotFoundException();
		}
		//Get the user id of the currently logged in user	
		$userId = Sentry::getUser()->id;
		//Check permission
		$result = $this->tasks->checkPermission($taskId, $userId);
		if($result == 'success')
		{
			//Authorized, Get the tasks
			$data = $this->tasks->viewTask($taskId);
			//Get the Subtasks
			$subTasks = $this->tasks->subTasks($taskId);
			//List of projects of the user
			$projectslist = ProjectUsers::where('user_id', $userId)->lists('project_id');
		 	if(sizeof($projectslist)!= 0)
		 	{
		 		$projects = Project::whereIn('id', $projectslist)->orderBy('project_name')->get(array('id','project_name'))->toArray();
		 	}
		 	else
		 	{
		 		$projects = null;
		 	}
		 	//Exisiting Users
			$emaillist = null;
			foreach ($data[0]['users'] as $user)
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
			//Return View	
			return \View::make('dashboard.tasks.edit')
						->with('task', $data[0])
						->with('projects',$projects)
						->with('emailList', $emaillist)
						->with('subTasks', $subTasks);
		}
		else
		{
			//Not Authorized
			throw new \NotAuthorizedForTaskException();
		}
	}
	/**
	* Update the task
	* @return JSON
	*/
	public function postEditTask()
	{

		//Get all the data
		$data = \Input::json()->all();	
		//Get the user id of the currently logged in user
		$userId = Sentry::getUser()->id;
		$result = $this->tasks->updateTask($data, $userId);
		//Get the user id of the currently logged in user
		if($result['status'] == 'success')
		{
			//Updated Successfully
			return \Response::json(array(
			'id' => $result['id'],
			'status' => 'update',
		    'error' => false),
		     200);
        }
		else
		{
			//Something went wrong
				return \Response::json(array(
				        'error' => true),
				        500);
		}
	}
	/**
	* Edit files View
	* @return View
	*/
	public function getEditFiles($taskId)
	{
		try
		{
			$task = Task::findOrFail($taskId);
		}
		catch(ModelNotFoundException $e)
		{
			throw new \TaskNotFoundException();
		}
		//Get Files
		$files = $this->tasks->getFiles($taskId);
		$taskName = $this->tasks->getName($taskId);
		return \View::make('dashboard.projects.editfile')
					->with('parentType', 'Task')
					->with('parentName', $taskName)
					->with('files',$files)
					->with('project_id',$taskId);
	}
	/**
	* Delete Task
	* @return  Redirect
	*/
	public function getDeleteIt()
	{
		//Get the Task Id
		$taskId = \Input::get('taskId');
		//Get the UserId of the currently logged on user
		$userId = Sentry::getUser()->id;
		//Delete Task
		$result = $this->tasks->deleteTask($taskId,$userId);
		if($result == 'success')
		{
			//Done
			return \Redirect::to('dashboard/tasks')->with('status','success')->with('message','Task Deleted');

		}
		else
		{
			//Not Done
			return \Redirect::to('dashboard/tasks')->with('status','error')->with('message','Something Went Wrong');
		}
	}
	/**
	* Update the sub task
	* @return JSON
	*/
	public function updateSubTask($id)
	{
		//Get the update data
		$data = \Input::json()->all();
		//Update Sub Task
		$result = $this->tasks->updateSubTask($data['id'],$data['status']);
		if($result == 'success')
		{
			//Done
			return \Response::json(array(
		    'error' => false),
		     200);

		}
		else
		{
				//Something went wrong
				return \Response::json(array(
				'error' => true),
				 500);
		}
	}

}



