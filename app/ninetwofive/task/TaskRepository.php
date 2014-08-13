<?php 
require_once(app_path().'/models/Subtask.php');
use \Exception as Exception;
use \SomeThingWentWrongException as SomeThingWentWrongException;
/**
 * Task Repository.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class TaskRepository implements TaskInterface{

	public function all($userId)
	{
		try
		{
			// Find all the tasks associated with userid
			$data = null;
	        $tasks = \User::find($userId)->tasks()->orderBy('name')->get()->toArray();
			if(sizeof($tasks) == 0)
			{
				//If there are no tasks return Null
				$data = null;
			}
			$data = static::makeTasks($tasks);
			$projectsList = \Projectcollabs::where('user_id', $userId)->lists('project_id');
			if(sizeof($projectsList) == 0)
			{
				$projects = null;
			}
			else
			{
				$projects = \Project::whereIn('id', $projectsList)->orderBy('project_name')->get(array('id','project_name'))->toArray();
			}
			$data['projects'] = $projects;
			$data['name_proj'] = 'All';
			return $data;
		}
		catch(Exception $e)
		{
			\Log::error('Something went wrong in Task Repository - all():'.$e->getMessage());
			throw new SomeThingWentWrongException();
		}
	}	
	public function getProjectTasks($projectId, $userId)
	{
		try
		{
			$tresPass = \Projectcollabs::where('user_id', $userId)->where('project_id',$projectId)->get();
			if(sizeof($tresPass) != 0)
			{
			 	$tempuser = \Sentry::getUserProvider()->findById($userId);
			 	$admin = \Sentry::getGroupProvider()->findByName('admin');
			 	$manager = \Sentry::getGroupProvider()->findByName('manager');
			 	$leader = \Sentry::getGroupProvider()->findByName('leader');
			 	$user = \Sentry::getGroupProvider()->findByName('user');
			 	if($tempuser->inGroup($admin) or $tempuser->inGroup($manager) or $tempuser->inGroup($leader))
			 	{
			 		$tasks = \Task::where('project_id',$projectId)->get()->toArray();
			 		$data = $this->makeTasks($tasks);
			 		$projectslist = \Projectcollabs::where('user_id', $userId)->lists('project_id');
			 		$projects = \Project::whereIn('id', $projectslist)->orderBy('project_name')->get(array('id','project_name'))->toArray();
			 		$data['projects'] = $projects;
			 		$data['name_proj'] = \Project::where('id',$projectId)->pluck('project_name');
			 		return $data;
			 	}
			 	elseif($tempuser->inGroup($user))
			 	{
			 	
			 		$tasksId = \Taskcollabs::where('user_id', $userId)->lists('task_id');
			 		$tasks = \Task::whereIn('id', $tasksId)->where('project_id', $projectId)->get()->toArray();
			 		$data = $this->makeTasks($tasks);
			 		$projectslist = \Projectcollabs::where('user_id', $userId)->lists('project_id');
			 		$projects = \Project::whereIn('id', $projectslist)->orderBy('project_name')->get(array('id','project_name'))->toArray();
			 		$data['projects'] = $projects;
			 		$data['name_proj'] = \Project::where('id',$projectId)->pluck('project_name');
			 		return $data;
			 	}
			}
			else
			{
				throw new \NotAuthorizedForProject();
				
			}
		}
		catch(\NotAuthorizedForProject $e)
		{
			throw new \NotAuthorizedForProject();
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong in Task Repository - getProjectTasks():'. $e->getMessage());
			throw new SomeThingWentWrongException();	
		}
		
	}

	public function makeTasks($tasks)
	{
		try
		{
			$data = array();
			foreach($tasks as $task)
			{
				if($task['status'] == 'delayed')
				{
						$today = new ExpressiveDate();
						$enddate = new ExpressiveDate($task['end_date']);
						$task['num_status'] =(int) $today->getDifferenceInDays($enddate);
						if($task['num_status'] > 0)
						{
							$task['status'] = 'active';
							$tempTask = \Task::find($task['id']);
							$tempTask->status = 'active';
							$tempTask->save();
						}
						else
						{
							$task['status_desc'] = abs($task['num_status']).' days passed since End date';
						}
				}
				elseif($task['status'] == 'active')
				{
					if($task['end_date'] != null)
					{
						$today = new ExpressiveDate();
						$enddate = new ExpressiveDate($task['end_date']);
						$task['num_status'] =(int) $today->getDifferenceInDays($enddate);
						if((int)$task['num_status'] <= 0)
						{
							$tempTask = \Task::find($task['id']);
							$tempTask->status = 'delayed';
							$tempTask->update();
							$task['status_desc'] = abs($task['num_status']).' days passed since End date';
							$task['num_status'] = 'Delayed';
							$task['status'] = 'delayed';
						}

					}
					else
					{
						$task['num_status'] = 'Active';
					}
				}
				
				if($task['project_id'] == null)
				{
					$task['project_name'] = null;
				}
				else
				{
					$project = \Project::find($task['project_id']);
					$task['project_name'] = $project->project_name;
				}

				$tempUpdatedAt = new ExpressiveDate($task['updated_at']);
				$task['updated_at'] = $tempUpdatedAt->format('jS F, Y \a\\t g:ia');
				$task ['totalsubtasks'] =   $subtasks = \Task::find($task['id'])->subtasks()->get()->count();
				if($task ['totalsubtasks'] == 0)
				{
					$task ['rem_subtasks'] = 0;
					$task['subTaskPercentage'] = 0;
				}
				else
				{
					$task ['rem_subtasks'] =   $subtasks = \Task::find($task['id'])->subtasks()->where('status', '=', 'active')->orWhere('status','=','delayed')->get()->count();
					$task['subTaskPercentage'] = (int)(($task ['totalsubtasks'] - $task ['rem_subtasks'])*100)/$task ['totalsubtasks'];
				}
				
				$task['users'] = \Task::find($task['id'])->users()->orderBy('first_name')->get()->toArray();
				$task['files'] = \Fileref::where('parent_id','=',$task['id'])->where('parent_type','=','task')->get()->count();
				$data[] = $task;
			}

			return $data;
		}
		catch(Exception $e)
		{
			\Log::error('Something went wrong in Task Repository - makeTasks():'.$e->getMessage());
			throw new \SomeThingWentWrongException();
		}

	}

	public function updateStatus($data, $userId)
	{
		try
		{
			$task = \Task::findOrFail($data['id']);
		
			if($data['status'] == 'completed')
			{
				$task->status = 'completed';
				$task->completed_on = date('Y-m-d H:i:s');
				$task->updated_by = $userId;
				$task->save();

			}
			elseif($data['status'] == 'active')
			{

				$task->status = 'active';
				$task->completed_on = null;
				$task->updated_by = $userId;
				$task->save();
			}

			return 'success';
		}
		catch(Exception $e)
		{
			\Log::error('Somthing Went Wrong in Task Repository - updateStatus():'.$e->getMessage());
			return 'error';
		}
	}
	public function addTask($data, $createdUserId)
	{
		try{

			$email  = $data['users'];
			$emails =  preg_split("/[\s,]+/", $email);
			$usersId = \User::whereIn('email',$emails)->lists('id');
			$task = new \Task;
			$task->name = $data['task_name'];
			$task->status = 'active';
			$task->note = $data['note'];
			$task->folder = str_random(8);
			if($data['project'] == 'null')
			{
				$task->project_id = null;
			}
			else
			{

					$task->project_id = (int) $data['project'];

			}
			$tempStartDate =\DateTime::createFromFormat('j F, Y',$data['startdate']);
            $tempEndDate = \DateTime::createFromFormat('j F, Y',$data['enddate']);
            $task->start_date = $tempStartDate->format('Y-m-d');
			$task->end_date = $tempEndDate->format('Y-m-d');
           
			$task->updated_by = (int) $createdUserId;
			$task->save();
			$taskId = $task->id;
			foreach ($usersId as $userId) 
			{
				$taskCollabs = new \Taskcollabs;
				$taskCollabs->task_id = $taskId;
				$taskCollabs->user_id = $userId;
				$taskCollabs->updated_by = $createdUserId;
				$taskCollabs->save();
			}
			$result['status'] = 'success';
			$result['id'] = $taskId;
			return $result;	
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong -  Task Repository - addTask() : '.$e->getMessage());
			$result['status'] = 'error';
			return $result;
		}

	}
	public function addSubTask($data, $createdUserId)
	{
		try{

			$subTask = new \SubTask;
			$subTask->text = $data['subtask'];
			$subTask->status = 'active';
			$subTask->task_id = (int)$data['taskId'];
			$subTask->updated_by = $createdUserId;
			$subTask->save();
			$result['status'] = 'success';
			$result['id'] = $subTask->id;
			return $result;

		}
		catch(Exceptioin $e)
		{
			\Log::error('Something Went Wrong -  Task Repository - addSubTask() : '.$e->getMessage());
			$result['status'] = 'error';
			return $result;
		}
	
	}

	public function deleteSubTask($id)
	{
		try
		{

			$subTask = \SubTask::find($id);
			$subTask->forceDelete();
			return 'success';
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong -  Task Repository - deleteSubTask() : '.$e->getMessage());
			return 'error';
		}
	}

	public function checkPermission($taskId, $userId)
	{
		try 
		{
					
			$createdUserId = \Task::where('id','=',$taskId)->pluck('updated_by');
			if($createdUserId == $userId)
			{
				return 'success';
			}
			$userCollab = \Taskcollabs::where('task_id','=',$taskId)->where('user_id','=',$userId)->get();
			if(sizeof($userCollab) != 0)
			{
				return 'success';
			}
			elseif(sizeof($userCollab) == 0)
			{
					$projectId = \Task::where('id','=',$taskId)->pluck('project_id');
					if($projectId == null)
					{
						return 'error';
					}
					else
					{
						 $tempuser = \Sentry::getUserProvider()->findById($userId);
						 $admin = \Sentry::getGroupProvider()->findByName('admin');
						 $manager = \Sentry::getGroupProvider()->findByName('manager');
						 $leader = \Sentry::getGroupProvider()->findByName('leader');
						 if($tempuser->inGroup($admin) or $tempuser->inGroup($manager) or $tempuser->inGroup($leader))
						 {
						 		$projectCollabs = \Projectcollabs::where('project_id','=',$projectId)->where('user_id','=',$userId)->get();
						 		if(sizeof($projectCollabs) != 0)
						 		{
						 			return 'success';
						 		}
						 		else
						 		{
						 			return 'error';
						 		}
						 }
						 else
						 {
						 	return 'error';
						 }
					}
			}
		} 
		catch (Exception $e) 
		{
			\Log::error('Something Went Wrong - Task Repository - checkPermission():'.$e->getMessage());
			return 'error';
		}
	}
	public function viewTask($taskId)
	{
		try 
		{
			$task = \Task::where('id','=',$taskId)->get()->toArray();
			$data = $this->makeTasks($task);
			$filesId = \Fileref::where('parent_id',$taskId)->where('parent_type','task')->lists('attachment_id');
			if($filesId == null)
			{
				$files = null;
			}
			
			else
			{	
				$filesJson = \Files::whereIn('id',$filesId)->get(array('file_name','file_sys_ref','key','size','uploaded_date','uploaded_by'))->toArray();
				$files = $filesJson;
			}
			$data[0]['files'] = $files;
			return $data;
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong - Task Repository - viewTask():'.$e->getMessage());
			throw new \SomeThingWentWrongException();
		}
	}

	public function subTasks($taskId)
	{

		try
		{
			$subTasks = \SubTask::where('task_id',$taskId)->get(array('id','text','status'))->toArray();
			return $subTasks;
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong - Task Reposiroty - subTasks(): '.$e->getMessage());
		}

	}

	public function updateTask($data, $updateUserId)
	{

		try
		{

			$email  = $data['users'];
			$emails =  preg_split("/[\s,]+/", $email);
			$usersId = \User::whereIn('email',$emails)->lists('id');
			$task = \Task::find((int)$data['taskId']);
			$task->name = $data['task_name'];
			$task->note = $data['note'];
			if($data['project'] == 'null')
			{
				$task->project_id = null;
			}
			else
			{

					$task->project_id = (int) $data['project'];

			}
			\Log::info($data['startdate']);
			$tempStartDate =\DateTime::createFromFormat('j F, Y',$data['startdate']);
            $tempEndDate = \DateTime::createFromFormat('j F, Y',$data['enddate']);
            $task->start_date = $tempStartDate->format('Y-m-d');
			$task->end_date = $tempEndDate->format('Y-m-d');
			$task->updated_by = (int) $updateUserId;
			$task->save();
			$taskcollabs = \Taskcollabs::where('task_id',(int)$data['taskId'])->forceDelete();
			foreach ($usersId as $userId) {
				$taskCollabs = new \Taskcollabs;
				$taskCollabs->task_id = (int)$data['taskId'];
				$taskCollabs->user_id = $userId;
				$taskCollabs->updated_by = $updateUserId;
				$taskCollabs->save();

			}

			$result['status'] = 'success';
			$result['id'] = $task->id;
			return $result;	

		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong in Task Repository - updateTask():'.$e->getMessage());
			$result['status'] = 'error';
			return $result;

		}


	}
	public function getFiles($taskId)
	{
		try
		{
			$files;
			$filesId = \Fileref::where('parent_id',$taskId)->where('parent_type','task')->lists('attachment_id');
			if($filesId == null)
			{
				$files = null;
			}
			else
			{	
				$files = \Files::whereIn('id',$filesId)->get(array('file_name','id','key','size','uploaded_date','uploaded_by'))->toArray();
				//$files = $filesJson;
			}
				return $files;
		}
		catch(Exception $e)
		{
			\Log::error('Someting Went Wrong in Task Reposiroty - getFiles():'.$e->getMessage());
		}
	}
	public function getName($taskID)
	{
		$taskName = \Task::where('id',$taskID)->pluck('name');
		return $taskName;
	}

	public function deleteTask($taskId,$userId)
	{
		try
		{

			$task = \Task::find($taskId);
			$task->deleted_by = $userId;
			$task->save();
			$task->delete();
			$taskcollabs = \Taskcollabs::where('task_id',$taskId)->delete();
			return 'success';

		}
		catch (\Exception $e)
		{
			\Log::error('Someting Went Wrong in Task Repository - deleteTask():'.$e->getMessage());
			return 'error';
		}

	}
	public function updateSubTask($id,$status)
	{
		try
		{
			$subTask = \SubTask::find($id);
			$subTask->status = $status;
			$subTask->save();
			return 'success';

		}
		catch(\Exception $e)
		{
			\Log::error('Someting Went Wrong in Task Repository - updateSubTask():'.$e->getMessage());
			return 'error';
		}

	}

}