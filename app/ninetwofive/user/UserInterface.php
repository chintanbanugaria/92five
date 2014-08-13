<?php
/**
 * User Interface.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

interface UserInterface{

	//Get User Profile
    public function getUserProfile($userId);
    //Update User Profile
    public function updateMyDetails($userId,$data);
    //Change User Email
	public function changeMyEmail($userId,$newEmail);
    //Update User Password
	public function updatePassword($userId,$password);
    //Get All Users
    public function getAllUsersData();
    //Manage Users
    public function manageUsers($data);
    //Change Role of User
    public function getChangeRole($userId);
    public function postChangeRole($data);
    //Delete User
    public function deleteUser($userId);
    //Check whether other user with admin role exists
    public function checkForOtherAdmins($data);
    //Add User with Details
    public function addUserWithDetails($data);
    //Change Email - From Admin
    public function changeUserEmail($data);
}