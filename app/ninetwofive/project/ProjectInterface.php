<?php
/**
 * Project Interface.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
interface ProjectInterface{

	//Get all projects for the user
	function getProjects($userId);
	//Add Project with data
	function addProject($data, $createdUserId);
	//Check Permission 
	function checkPermission($projectId,$userId,$action);
	//Get a specific project
	function getProject($projectid);
	//Ger project data for edit
	function getProjectForEdit($projectId);
	//Update data for project
	function updateProject($data,$userId);
	//Delete project
	function deleteProject($projectId,$userId);
}
