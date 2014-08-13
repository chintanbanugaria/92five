<?php
use \Projectcollabs as ProjectUsers;
use \Project as Project;
use \Task as Task;
use  \Taskcollabs as TaskUser;
use \User as User;
use \Fileref as FileReference;
use \Files as Files;
/**
 * Project Repository.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class ProjectRepository implements ProjectInterface{

	/**
	* Get projects in which user is collaborated
	*/
	public function getProjects($userId)
	{
			//Get the list of ProjectIds
			$projectsList = ProjectUsers::where('user_id', $userId)->lists('project_id');
   		 	if($projectsList == null)
   		 	{
   		 		//Return what you got !
   		 		return null;
   		 	}
   		 	else
   		 	{
				$data = array();
				foreach ($projectsList as $key) 
				{
					//Get the project
					$projects = Project::where('id', $key)->get(array('id','project_name','start_date','end_date','status','completed_on'));
											
					//Get the Tasks List
					$totalTaskList = Task::where('project_id','=',$key)->whereNotNull('project_id')->lists('id');
											
					if(sizeof($totalTaskList) == 0)
					{
						//No Tasks. Everything is Zero
						$arrayProjects = (array)json_decode($projects,1);
						$arrayProjects[0]['overall_task'] = 0;
						$arrayProjects[0]['overall_rem_task'] = 0;
						$arrayProjects[0]['my_total_task'] = 0;
						$arrayProjects[0]['my_rem_task'] = 0;
						$arrayProjects[0]['percentage'] = 0;
						$data[] = $arrayProjects;

					}
					else
					{
						//List our the tasks whose status is active or delayed					
						$totalUncomplTaskList =  Task::whereNested(function($query) use ($key){
														$query->where('project_id',$key);
														$query->where('status','active');
														})
														->orWhere(function($query) use ($key){
														$query->where('project_id',$key);
														$query->where('status','delayed');
														})->lists('id');

						//Count the tasks assigned to the user
						$totalMyTask = TaskUser::whereIn('task_id',$totalTaskList)->where('user_id',$userId)->count();
												
						if(sizeof($totalUncomplTaskList) == 0)
						{
							$totalMyTaskRamining = 0;
						}
						else
						{
							//Count the tasks assigned to the user and which are incompleted
							$totalMyTaskRamining =  TaskUser::whereIn('task_id',$totalUncomplTaskList)->where('user_id',$userId)->count();
						}
						
						//Wrap Up Data					
						$arrayProjects = (array)json_decode($projects,1);
						$arrayProjects[0]['overall_task'] = count($totalTaskList);
						$arrayProjects[0]['overall_rem_task'] = count($totalUncomplTaskList);
						$arrayProjects[0]['my_total_task'] = $totalMyTask;
						$arrayProjects[0]['my_rem_task'] = $totalMyTaskRamining;
						$arrayProjects[0]['percentage'] = ((count($totalTaskList) - count($totalUncomplTaskList))*100)/count($totalTaskList);
						$data[] = $arrayProjects;
					}
												
				}
				//Shuffle data 	   		 	
				$tempData;
										
				foreach ($data as $key)
				{
					$tempData[]=$key[0];
				}
										
				$projs = array();
										
				foreach ($tempData as $key => $row) 
				{
					$projs[$key]  = $row['project_name']; 
					// of course, replace 0 with whatever is the date field's index			
				}

				
				//Sort the data			   		 	
				usort($tempData, $this->sortOut('project_name'));
					
				//Return final data
				return $tempData;

			}
	}

	/**
	*Sorting function. No need to be public or protected
	*/
	private function sortOut() 
	{
		    // Normalize criteria up front so that the comparer finds everything tidy
		    $criteria = func_get_args();
		    foreach ($criteria as $index => $criterion) {
		        $criteria[$index] = is_array($criterion)
		            ? array_pad($criterion, 3, null)
		            : array($criterion, SORT_ASC, null);
		    }

		    return function($first, $second) use (&$criteria) {
		        foreach ($criteria as $criterion) {
		            // How will we compare this round?
		            list($column, $sortOrder, $projection) = $criterion;
		            $sortOrder = $sortOrder === SORT_DESC ? -1 : 1;

		            // If a projection was defined project the values now
		            if ($projection) {
		                $lhs = call_user_func($projection, $first[$column]);
		                $rhs = call_user_func($projection, $second[$column]);
		            }
		            else {
		                $lhs = $first[$column];
		                $rhs = $second[$column];
		            }

		            // Do the actual comparison; do not return if equal
		            if ($lhs < $rhs) {
		                return -1 * $sortOrder;
		            }
		            else if ($lhs > $rhs) {
		                return 1 * $sortOrder;
		            }
		        }

		        return 0; // tiebreakers exhausted, so $first == $second
		   	 };
	}
	/**
	* Add Project
	*/
	public function addProject($data,$createdUserId)
	{
			//Seperate email list of collaborator and get corresponding user Ids
			$email  = $data['tagsinput'];
			$emails =  preg_split("/[\s,]+/", $email);
			$usersIdList = \User::whereIn('email',$emails)->lists('id');
			
			//Hit the database with new data
			$project = new Project;
			$project->project_name = $data['project_name'];
			$project->description = $data['description'];
			$project->note = $data['note'];
            $tempStartDate =\DateTime::createFromFormat('j F, Y',$data['startdate']);
            $tempEndDate = \DateTime::createFromFormat('j F, Y',$data['enddate']);
			$project->start_date = $tempStartDate->format('Y-m-d');
			$project->end_date = $tempEndDate->format('Y-m-d');
			$project->status = 'active';
			$project->project_client = $data['project_client'];
			$project->folder = str_random(8);
			$project->updated_by = $createdUserId;
			$project->save();
			//Get the newly generated ProjectId
			$projectId = $project->id;

			//Add the collaborators
			foreach ($usersIdList as $userId) 
			{
				$projectcollabs = new ProjectUsers;
				$projectcollabs->user_id = $userId;
				$projectcollabs->project_id = $projectId;
				$projectcollabs->save();	
								
			}
			//Prepare the data for the Add file view
			$returnData['project_name'] = $data['project_name'];
			$returnData['projectId'] = $projectId;
			//Send it back
			return $returnData;	
	}
	/**
	* Check permission
	*/
	public function checkPermission($projectId,$userId,$action)
	{
		$checkUser = ProjectUsers::where('project_id','=',$projectId)->where('user_id','=',$userId)->get();
		if(sizeof($checkUser) != 0)
		{
			if($action == 'view')
			{
				//Authorized
				return true;
			}
			elseif($action == 'edit')
			{
				$user = Sentry::getUserProvider()->findById($userId);
				if($user->hasAccess('project.update'))
				{
					//Authorized
					return true;
				}
				else
				{
					//Not authorized
					return false;
				}
			}
		}
		else
		{
			//Not Authorized
			return false;
		}
	}
	/**
	*	Get Project
	*/
	public function getProject($projectId)
	{
		//Get the data from project table
		$project = Project::find($projectId);
		//Total Tasks List
		$totalTaskList = Task::where('project_id',$projectId)->lists('id');
		if($totalTaskList == null)
		{
			//No Tasks for the project
			$project['total_tasks'] = 0;
			$project['uncompl_tasks'] = 0;
			$project['percentage'] = 0;
		}
		else
		{
			//Get the IDs of the Tasks which are active or delayed
			$totalUncomplTaskList = Task::whereNested(function($query) use ($projectId){
											$query->where('project_id',$projectId);
											$query->where('status','active');
											})
											->orWhere(function($query) use ($projectId){
											$query->where('project_id',$projectId);
											$query->where('status','delayed');
											})->lists('id');

			//Manipulation
			$percentage = ((count($totalTaskList) - count($totalUncomplTaskList))*100)/count($totalTaskList);
			$project['total_tasks'] = count($totalTaskList);
			$project['uncompl_tasks'] = count($totalUncomplTaskList);
			$project['percentage'] = $percentage;

		}
		//Get the users collaborated to the project
		$projectUserIdList = ProjectUsers::where('project_id',$projectId)->lists('user_id');
		$users= User::whereIn('id',$projectUserIdList)->get(array('id','first_name','last_name'))->toArray();
		//Get the files attached with project
		$files;
		$filesId = FileReference::where('parent_id',$projectId)->where('parent_type','project')->lists('attachment_id');
		if($filesId == null)
		{
			//No Files
			$files = null;
		}
		
		else
		{	
			//Get the files
			$files = Files::whereIn('id',$filesId)->get(array('file_name','file_sys_ref','key','size','uploaded_date','uploaded_by'))->toArray();
			
		}
		//Wrapup  data
		$returnData['project'] = $project;
		$returnData['users'] = $users;
		$returnData['files'] = $files;
		//Shoot it back
		return $returnData;
		
	}
	/**
	* Get Project for Edit
	*/
	public function getProjectForEdit($projectId)
	{
			//Users email list
			$emailList = null;
			//Get the project
			$project = Project::find($projectId);
			//Users Id List
			$projectUserIdList = ProjectUsers::where('project_id',$projectId)->lists('user_id');
			$users= User::whereIn('id',$projectUserIdList)->get(array('id','first_name','last_name','email'))->toArray();
			foreach ($users as $user)
		 	{
				if($emailList == null)
				{
					$emailList = $user['email'];
				}
				else
				{
					$emailList = $emailList.','.$user['email'];
				}
				
			}	
			//Wrap up data
			$returnData['project'] = $project;
			$returnData['users'] = $users;
			$returnData['emaillist'] = $emailList;
			//Shoot it back
			return $returnData;	
	}
	/**
	*  Update the project
	*/
	public function updateProject($data,$userId)
	{

		//Find the project and update the fileds
		$project = Project::find($data['projectid']);
		$project->project_name = $data['project_name'];
		$project->description = $data['description'];
		$project->status = $data['status'];
        $tempStartDate =\DateTime::createFromFormat('j F, Y',$data['startdate']);
        $tempEndDate = \DateTime::createFromFormat('j F, Y',$data['enddate']);
        $project->start_date = $tempStartDate->format('Y-m-d');
        $project->end_date = $tempEndDate->format('Y-m-d');
		$project->project_client = $data['project_client'];
		$project->note = $data['note'];
		//If the project is marked completed fill the respective fields of database
		if($data['status'] == 'completed')
		{
			$project->completed_on = date_create();
			$project->mark_completed_by = $userId;
			$project->updated_by = $userId;
			$project->save();
		}
		
		else
		{

			$project->updated_by = $userId;
			$project->save();

		}
		//Remove all the Collaborators of the project
		$prjtUsrs = ProjectUsers::where('project_id',$data['projectid'])->forceDelete();
		//New list of emails of collaborators 
		$email  = $data['tagsinput'];
		$emails =  preg_split("/[\s,]+/", $email);
		//Get the user Ids of the new collaborators
		$userIdList = \User::whereIn('email',$emails)->lists('id');
		//Add  collaborators
		foreach ($userIdList as $usrId) 
		{
			$projectcollabs = new \Projectcollabs;
			$projectcollabs->user_id = $usrId;
			$projectcollabs->project_id = $data['projectid'];
			$projectcollabs->save();	
								
		}

		//Get the project name and Id for the next view
		$projectName = $data['project_name'];
		$projectId = $data['projectid'];
		$files;
		$filesId = FileReference::where('parent_id',$projectId)->where('parent_type','project')->lists('attachment_id');
		if($filesId == null)
		{
			$files = null;
		}
		else
		{	
			$files = Files::whereIn('id',$filesId)->get(array('file_name','id','key','size','uploaded_date','uploaded_by'))->toArray();
			
		}
		//Wrap up data
		$returnData['projectName'] = $projectName;
		$returnData['projectId'] = $projectId;
		$returnData['files'] = $files;
		//Shoot back
		return $returnData;	
	}
	/**
	* Delete project
	*/
	public function deleteProject($projectId,$userId)
	{
		//Get the task Ids of the project
		$tasks = \Task::where('project_id',$projectId)->lists('id');
		if($tasks == null)
		{
			//No Tasks. Delete data and users from the database
			$projectUsers = ProjectUsers::where('project_id',$projectId)->delete();
			$project = Project::find($projectId);
			$project->deleted_by = $userId;
			$project->save();
			$project->delete();
			return true;
		}
		else
		{
			//Delete all users and data for all tasks of the project. Also delete all the users and data for the project
			$projectUsers = ProjectUsers::where('project_id',$projectId)->delete();
			$taskUsers = TaskUser::whereIn('task_id',$tasks)->delete();
			//$tasks = Task::where('project_id',$projectId)->delete();
			foreach($tasks as $taskId)
			{
				$task = \Task::find($taskId);
				$task->deleted_by = $userId;
				$task->save();
				$task->delete();
			}

			$project = Project::find($projectId);
			$project->deleted_by = $userId;
			$project->save();
			$project->delete();
			return true;
		}

	}
}
