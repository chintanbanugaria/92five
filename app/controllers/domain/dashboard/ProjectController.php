<?php namespace Controllers\Domain\Dashboard;
use \Project as Project;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;
use Illuminate\Database\Eloquent\ModelNotFoundException as ModelNotFoundException;
/**
 * Project Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class ProjectController extends \BaseController{

	protected $project;
	/**
	* Constructor
	*/
	public function __construct()
	{
		$this->project = \App::make('ProjectInterface');
	}
	/**
	* Get projects for current logged in user
	* @return View
	*/
	public function getIndex()
	{
			$userId =  Sentry::getUser()->id;
			$data = $this->project->getProjects($userId);
   		 	return \View::make('dashboard.projects.index')
							->with('data',$data);
	}
	/**
	* Generate the view for the Add project
	* @return View
	*/
	public function getAddProject()
	{
			//Check if the user has permission to create / add project
			if(Sentry::getUser()->hasAccess('project.create'))
			{
				return \View::make('dashboard.projects.add');
			}
			else
			{
				//Not Authorised
				throw new \NotAuthorizedForProject ();
			}

	}
	/**
	* Add Project
	* @return View
	*/
	public function postCreateProject()
	{
			//Get all data
			$data = \Input::all();
			//Get the user id of the currently logged in user
			$createdUserId = Sentry::getUser()->id;
			//Add the dat
			$returnData = $this->project->addProject($data,$createdUserId);
			return \View::make('dashboard.projects.addfile')
							->with('parentType', 'Project')
							->with('parentName', $returnData['project_name'])
							->with('parentId', $returnData['projectId']);
			
			
	}
	/**
	* Add files to the project
	* @return bool
	*/
	public function postAddFiles()
	{
			//Get the file
			$file = \Input::file('file');
			//Get the project Id
			$project_id = \Input::get('project_id');
			//Get the user id of the currently logged in user
			$userId = Sentry::getUser()->id;
			//Upload it to the disk
			$result = \Fileupload::upload($file,$project_id,'project',$userId);
			return $result;
	}
    /**
    * View the specific project
    * @return View
    */
	public function getViewProject($id)
	{
		try
		{
			//Check if project exists
			$project = Project::findOrFail($id);

		}
		catch(ModelNotFoundException $e)
		{
			//Project Not Found
			throw new \ProjectNotFoundException();
		}
		//Get the user id of the currently logged in user
        $userId = Sentry::getUser()->id;
        //Check the permission
        $permission = $this->project->checkPermission($id,$userId,'view');
        if($permission)
        {
       	 	//Get the data
       	 	$returnData = $this->project->getProject($id);
       		return \View::make('dashboard.projects.view')
					->with('project',$returnData['project'])
					->with('users',$returnData['users'])
					->with('files',$returnData['files']);
		}
		else
		{
			//Not Authorised
			throw new \NotAuthorizedForProject ();
		}	
		
	}
	/**
	* Get the project for Edit / Update
	* @param $id // Project Id
	* @return View
	*/
	public function getEditProject($id)
	{
		try
		{
			//Check if project exists
			$project = Project::findOrFail($id);
		}
        catch(ModelNotFoundException $e)
		{
			throw new \ProjectNotFoundException();
		}
		//Get the user id of the currently logged in user
        $userId = Sentry::getUser()->id;
        //Check the permission
        $permission = $this->project->checkPermission($id,$userId,'edit');
        if($permission)
        {
        	//Authorised, get the data
        	$returnData = $this->project->getProjectForEdit($id);
			return \View::make('dashboard.projects.edit')
						->with('project',$returnData['project'])
						->with('users',$returnData['users'])
						->with('emaillist', $returnData['emaillist']);
        }
        else
        {
        	//Not Authorised
        	 throw new \NotAuthorizedForProject ();
        }
	}
	/**
	*	Update project
	* @param $id 
	* @return View
	*/
	public function postEditProject($id)
	{
		
		//Get the user id of the currently logged in user
        $userId = Sentry::getUser()->id;
		$data = \Input::all();
		//udate data
		$returnData = $this->project->updateProject($data,$userId);		
		return \View::make('dashboard.projects.editfile')
					->with('parentType', 'Project')
					->with('parentName',$returnData['projectName'])
					->with('project_id',$returnData['projectId'])
					->with('files',$returnData['files']);
	}
	/**
	* Delete project
	*/
	public function deleteProject()
	{
        //Get the user id of the currently logged in user
        $userId = Sentry::getUser()->id;
        $projectId = \Input::get('projectId');
		$result = $this->project->deleteProject($projectId,$userId);
		if($result)
		{
			return \Redirect::to('dashboard/projects')->with('status','success')->with('message','Project Deleted');
		}
		else
		{
			throw new \SomeThingWentWrongException();
			
		}
		
	}

}