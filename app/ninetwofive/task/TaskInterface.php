<?php 
/**
 * Task Interface.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

interface TaskInterface{

	//Get All Tasks
	public function all($userid);
	//Get all Tasks for a Project
	public function getProjectTasks($projectId, $userId);
	//Update status 
	public function updateStatus($data, $userId);
	//Add new Task
	public function addTask($data, $userId);
	//Add New Subtask
	public function addSubTask($data, $userId);
	//Delete Sub Task
	public function deleteSubTask($id);
	//Check permission 
	public function checkPermission($taskId, $userId);
	//View the Task
	public function viewTask($taskId);
	//Get all the sub tasks for a task
	public function subTasks($taskId);
	//Update Task
	public function updateTask($taskData, $updateUserId);
	//Get Files for Task
	public function getFiles($taskId);
	//Get the name of the Task
	public function getName($taskId);
	//Delete Task
	public function deleteTask($taskId,$userId);
	//Update SubTask
	public function updateSubTask($id,$status);


}