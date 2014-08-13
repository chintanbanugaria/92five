<?php
use \Projectcollabs as ProjectUsers;
use \Project as Project;
use \Task as Task;
use \Taskcollabs as TaskUser;
use \User as User;
use \Fileref as FileReference;
use \Files as Files;
use \Timesheet as Timesheet;
use \SomeThingWentWrongException as SomeThingWentWrongException;
/**
 * Report Repository.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

class ReportRepository implements ReportInterface{

	
	public function getTasks($userId)
	{	
		//Get Tasks
		$tasks = $tasks = User::find($userId)->tasks()->orderBy('name')->get()->toArray();
		return $tasks;
	}
	public function getProjects($userId)
	{
		//Get Projects
		$projectslist = ProjectUsers::where('user_id', $userId)->lists('project_id');
		if(sizeof($projectslist) == 0)
		{
			$projects = null;
		}
		else
		{
			$projects = Project::whereIn('id', $projectslist)->orderBy('project_name')->get(array('id','project_name'))->toArray();
		}
		return $projects;
	}

	public function generateWeeklyReport($dates, $userId)
	{
		try
		{
			//Initialize the variables
			$data = array();
			$tasksId = array();
			$totalTimeSpent = 0;
			$otherTaskTotalTime = 0;
			$onlyTasksId = array();
			foreach ($dates as $date)
			{
				//Get all entries 
				$tempData  = Timesheet::where('date',$date)->where('user_id',$userId)->get()->toArray();
				//Temp Variable
				$newTempData = array();
				foreach($tempData as $entry)
				{
					//Calculate Total Time
					$totalTimeSpent = $totalTimeSpent + $entry['total_time_spent'];
					//If Timesheet Entry is without any assigned task
					if($entry['task_id'] != null)
					{
						$tempTaskEntry['taskId'] = $entry['task_id'];
						$tempTaskEntry['entryId'] = $entry['id'];
						$tasksId [] = $tempTaskEntry;
						$onlyTasksId [] = $entry['task_id'];
						$entry['task'] = \Task::find($entry['task_id'])->toArray();
					}
					else
					{
						$otherTaskTotalTime = $otherTaskTotalTime + $entry['total_time_spent'];
					}
					//Transfer Data
					$newTempData[] = $entry;
				}
				//Transfer Data
				$data [] = $newTempData;
			}
			//Convert total time to hours and mins
			$tempTotalTime = \DateAndTime::convertTime($totalTimeSpent);
			//Get all Task's Id
			$taskId = array_unique($onlyTasksId);
			$newTask = array();
			$tasks = array();
			$projectTaskId = array();
			$onlyProjId = array();
			//Calculation of Total Time for all Tasks
			foreach ($taskId as $tId)
			{
				$tempAddTime = 0;
				foreach ($tasksId as $tempKey)
				 {
					if($tempKey['taskId'] == $tId)
					{
						$tempEntry  = Timesheet::find($tempKey['entryId']);
						$tempAddTime = $tempAddTime + $tempEntry->total_time_spent;
					}
				}
				$tempTask = Task::find($tId);
				$taskName = $tempTask->name;
				//Add time to the pertaining project
				if($tempTask->project_id != null)
				{
					$tempProjTask['projectId'] = $tempTask->project_id;
					$tempProjTask['taskId'] = $tId;
					$projectTaskId [] = $tempProjTask;
					$onlyProjId [] = $tempTask->project_id;
				}
				//Data for each Task and total hours and mins
				$tempTime = \DateAndTime::convertTime($tempAddTime);
				$newTask['id'] = $tId;
				$newTask['name'] = $taskName;
				$newTask['total_time'] = $tempAddTime;
				$newTask['hours'] = $tempTime['hours'];
				$newTask['mins'] = $tempTime['mins'];
				$tasks[] = $newTask;

			}
			//Calculation of Total Time for all Projects
			$projId = array_unique($onlyProjId);
			$projects = array();
			foreach ($projId as $pId)
			 {
			 	$projectTime = 0;
				foreach ($projectTaskId as $pTId)
				{
					if($pTId['projectId'] == $pId)
					{
						foreach ($tasks as $task)
			 	 		{
			 					if($task['id'] == $pTId['taskId'])
			 					{
			 						$projectTime = $projectTime + $task['total_time'];
			 					}
			 			}
					}
				}
				//Data for each Project and total hours and mins
			 	$tempProjTime = \DateAndTime::convertTime($projectTime);
			 	$tempProj = Project::find($pId);
			 	$newProject['id'] = $pId;
			 	$newProject['name'] = $tempProj->project_name;
			 	$newProject['totalTime'] = $projectTime;
			 	$newProject['hours'] = $tempProjTime['hours'];
			 	$newProject['mins'] = $tempProjTime['mins'];
				$projects [] = $newProject;

			}
			//Final Assignment and Warp up data
			$returnData['projects'] = $projects;
			$returnData['tasks'] = $tasks;
			$returnData['totalTime'] = $tempTotalTime;
			$returnData['totalTimeSpent'] = $totalTimeSpent;
			$returnData['otherTasksTime'] = \DateAndTime::convertTime($otherTaskTotalTime);
			$returnData['otherTasksTimeSpent'] = $otherTaskTotalTime;
			$returnData['entries'] = $data;
			return $returnData;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Report Repository - generateWeeklyReport():'. $e->getMessage());
			throw new SomeThingWentWrongException();	
		}

	}
	public function generateWeeklyTaskReport($dates,$taskId,$userId)
	{
		try
		{	
				//variables
				$totalTimeSpent = 0;
				$dayTime = array();
				$entries = array();
				//Get the entries and calculate total time
				foreach ($dates as $date)
				{
					//Entries
					$tempData  = Timesheet::where('date',$date)->where('task_id',$taskId)->where('user_id',$userId)->get()->toArray();
					$tempDayTime = 0;
					foreach($tempData as $entry)
					{
						$totalTimeSpent = $totalTimeSpent + $entry['total_time_spent'];
						$tempDayTime = $tempDayTime + $entry['total_time_spent'];
					}
					$dayTime [] = $tempDayTime;
					$entries[] = $tempData;
				}
				//Wrapup data
				$chartdata = json_encode($dayTime,JSON_NUMERIC_CHECK);
				$returnData['entries'] = $entries;
				$returnData['totalTime'] = \DateAndTime::convertTime($totalTimeSpent);
				$returnData['chartData'] =$chartdata;
				$returnData['task'] = Task::find($taskId)->toArray();
				return $returnData;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Report Repository - generateWeeklyTaskReport():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}

	}

	public function generateWeeklyProjectReport($dates,$projectId,$userId)
	{
		try
		{		
				//List all Tasks associated with the project
				$tasksId = Task::where('project_id',$projectId)->lists('id');
				$entries = array();
				$taskEntryArray = array();
				$totalTimeSpent = 0;
				$dayTime = array();
				$onlyTasksId = array();
				if(sizeof($tasksId) != 0)
				{
					
					foreach ($dates as $date)
					{
						$tempData  = Timesheet::where('date',$date)->whereIn('task_id',$tasksId)->where('user_id',$userId)->get()->toArray();
						$tempDayTime = 0;
						$tempEntryArray = array();
						//Total Time
						foreach($tempData as $entry)
						{
							$tempTaskEntry['taskId'] = $entry['task_id'];
							$tempTaskEntry['entryId'] = $entry['id'];
							$taskEntryArray [] = $tempTaskEntry;
							$onlyTasksId [] = $entry['task_id'];
							$totalTimeSpent = $totalTimeSpent + $entry['total_time_spent'];
							$tempDayTime = $tempDayTime + $entry['total_time_spent'];
							$entry['task'] = \Task::find($entry['task_id'])->toArray();
							$tempEntryArray [] = $entry;
						}
						$entries [] = $tempEntryArray;
						$dayTime [] = $tempDayTime;
					}
					$allTasksId = array_unique($onlyTasksId);
					$tasks = array();
					$tempTaskArray = array();

					//Calculate total time for each task
					foreach ($allTasksId as $tId)
					{

						$tempTaskTime = 0;
						foreach($taskEntryArray as $te)
						{
							if($te['taskId'] == $tId)
							{
								$tempEntry = \Timesheet::find($te['entryId']);
								$tempTaskTime = $tempTaskTime + $tempEntry->total_time_spent;
							}
						}
						//Convert Time and Wrapup data
						$tempTask = \Task::find($tId);
						$tempTaskName = $tempTask->name;
						$tempTaskHours = \DateAndTime::convertTime($tempTaskTime);
						$temptasks['id'] = $tId;
						$temptasks['name'] = $tempTaskName;
						$temptasks['total_time'] = $tempTaskTime;
						$temptasks['hours'] = $tempTaskHours['hours'];
						$temptasks['mins'] = $tempTaskHours['mins'];
						$tasks  [] = $temptasks;
					}
				}
				//No Tasks
				else
				{
					$tasks = array();
					$taskTimeArray = array();
					$taskNameArray = array();
					$entries = array();
					$dayTime = array();
					for($i=0; $i<sizeof($dates); $i++)
					{
						$entries[] = null;
						$dayTime [] = 0;
					}
				}
				//Wrapup data
				$tempProject = \Project::find($projectId);
				$returnData['projectName'] = $tempProject->project_name;
				$returnData['entries'] = $entries;
				$returnData['tasks'] = $tasks;
				$returnData['totalTime'] = \DateAndTime::convertTime($totalTimeSpent);
				$returnData['dayTime'] = $dayTime;
		 		return $returnData;
		 }
		 catch(\Exception $e)
		 {
		 	\Log::error('Something Went Wrong in Report Repository - generateWeeklyProjectReport():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		 }
	}

	public function generateProjectReport($projectId,$userId)
	{
		try
		{
				$tasks;
				//Get Project
				$project = Project::find($projectId)->toArray();
				//Get Task List
				$total_task_list = Task::where('project_id',$projectId)->lists('id');
				if($total_task_list == null)
				{
					//No Tasks, everything zero
					$project['total_tasks'] = 0;
					$project['uncompl_tasks'] = 0;
					$project['percentage'] = 0;
					$project['compl_tasks'] = 0;
					$project['active_tasks'] = 0;
					$project['delay_tasks'] = 0;
				}
				else
				{
					//List out the Id's of active / delayed tasks
					$total_uncompl_task_list = Task::whereNested(function($query) use ($projectId){
																				$query->where('project_id',$projectId);
																				$query->where('status','active');
																			})
																			->orWhere(function($query) use ($projectId){
																				$query->where('project_id',$projectId);
																				$query->where('status','delayed');
																			})->lists('id');
					//Calculation 
					$percentage = ((count($total_task_list) - count($total_uncompl_task_list))*100)/count($total_task_list);
					$project['total_tasks'] = count($total_task_list);
					$project['uncompl_tasks'] = count($total_uncompl_task_list);
					$project['percentage'] = $percentage;
					$project['compl_tasks'] = count($total_task_list) - count($total_uncompl_task_list);
					$project['delay_tasks'] = Task::whereIn('id',$total_task_list)->where('status','delayed')->count();
					$project['active_tasks'] = Task::whereIn('id',$total_task_list)->where('status','active')->count();
					$tasksList = Task::whereIn('id',$total_task_list)->get(array('name','status'))->toArray();
					$project['taskList'] = $tasksList;
					//Check if User is admin, manager or leader.
					$user = \Sentry::getUserProvider()->findById($userId);
					$adminGroup = \Sentry::getGroupProvider()->findByName('admin');
					$managerGroup = \Sentry::getGroupProvider()->findByName('manager');
					$leaderGroup = \Sentry::getGroupProvider()->findByName('leader');
					if($user->inGroup($adminGroup) or $user->inGroup($managerGroup) or $user->inGroup($leaderGroup))
					{		
							//If the user is admin, manager or leader show all the tasks of the project
							$taskInterface = \App::make('TaskInterface');
							foreach($total_task_list as $taskId)
							{
								$tempTaskArray = array();
								$tempTaskArray['task'] = $taskInterface->viewTask($taskId);
								$tempTaskArray['userTime'] = static::userTimeForTask($taskId);
								$tempTaskArray['subtasks'] = $taskInterface->subTasks($taskId);
								$tasks [] = $tempTaskArray;
							}
							$project['tasks'] = $tasks;
		                    $project['users'] = static::userTimeForProject($projectId);
					}
					else
					{    //Else show only those tasks in which user is asignee
		                $taskList = TaskUser::where('user_id',$userId)->whereIn('task_id',$total_task_list)->lists('task_id');
						if(sizeof($taskList) !=  0)
		                {
		                    $taskInterface = \App::make('TaskInterface');
		                    foreach($taskList as $taskId)
							{
								$tempTaskArray = array();
								$tempTaskArray['task'] = $taskInterface->viewTask($taskId);
								$tempTaskArray['subtasks'] = $taskInterface->subTasks($taskId);
								$tasks [] = $tempTaskArray;
							}
							$project['tasks'] = $tasks;
		                }
		                else
		                {
		                    $project['tasks'] = null;
		                }
					}
		        } 
		        //Get all the files 
		        $filesId = FileReference::where('parent_id',$projectId)->where('parent_type','project')->lists('attachment_id');
				if($filesId == null)
				{
						$files = null;
				}
				else
				{	
						$filesJson = \Files::whereIn('id',$filesId)->get(array('file_name','file_sys_ref','key','size','uploaded_date','uploaded_by'))->toArray();
						$files = $filesJson;
				}
				$project['files'] = $files;
				//Retrun everything in array
				return $project;
			}
			catch(\Exception $e)
			{
				\Log::error('Something Went Wrong in Report Repository - generateProjectReport():'. $e->getMessage());
				throw new SomeThingWentWrongException();
			}
	}
	//Calculates the total time spent by users on a particular task
	public static function userTimeForTask($taskId)
	{
		try
		{
			$userTime = array();
			$userIdList = TaskUser::where('task_id',$taskId)->lists('user_id');
			foreach($userIdList as $userId)
			{
				$userTimeTemp = array();
				$timeList = Timesheet::where('user_id',$userId)->where('task_id',$taskId)->lists('total_time_spent');
				$totalTime = 0;
				if(sizeof($timeList) != 0)
				{
					foreach ($timeList as $time) 
					{
						$totalTime = $totalTime + $time;
					}
				}
				$user = \User::find($userId);
				$userTimeTemp['userName'] = $user->first_name . $user->last_name;
				$userTimeTemp['totalTime'] = \DateAndTime::convertTime($totalTime);
				$userTime [] = $userTimeTemp;
			}
			return $userTime;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Report Repository - userTimeForTask():'. $e->getMessage());
				throw new SomeThingWentWrongException();
		}
	}
	//Calculates the total time spent by users on a particular Project
	public static function userTimeForProject($projectId)
	{
		try
		{
	        $users;
	        $userIdList = \Projectcollabs::where('project_id',$projectId)->lists('user_id');
	        $taskIdList = \Task::where('project_id',$projectId)->lists('id');
	        foreach($userIdList as $userId)
	        {
	            $tempUserData;
	            $timeList = \Timesheet::whereIn('task_id',$taskIdList)->where('user_id',$userId)->lists('total_time_spent');
	            $totalTime = 0;
	            foreach($timeList as $time)
	            {
	                $totalTime = $totalTime + $time;
	            }
	            $user = \User::find($userId);
	            $tempUserData['userName'] = $user->first_name . $user->last_name;
	            $tempUserData['userId'] = $userId;
	            $tempUserData['totalTime'] = \DateAndTime::convertTime($totalTime);
	            $users [] = $tempUserData;
	        }
			return $users;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Report Repository - userTimeForProject():'. $e->getMessage());
				throw new SomeThingWentWrongException();
		}
	}
}
