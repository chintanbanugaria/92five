<?php namespace Controllers\Domain\Admin;
/**
 * User Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class UserController extends \BaseController{

	protected $user;
    /**
	 * Constructor
     */
    public function __construct()
	{
		$this->user = \App::make('UserInterface');
	}
	/**
     * Get all users
     * @return View
     */
    public function getAllUsers()
    {
        //Get all data
        $data = $this->user->getAllUsersData();
        return \View::make('dashboard.users.viewall')
                        ->with('data',$data);
    }
    /**
     * Generate View for Add user
     * @return View
     */
    public function getAddUser()
    {
    	return \View::make('dashboard.users.adduser');
    }
    /**
     * Add user with email
     * @return Redirect
     */
    public function postAddUser()
    {
    	//Get  email and role for the new user
        $email = \Input::get('email');
    	$role = \Input::get('role');
        //Sent activation email to the user
    	$result = 	\App::make('AuthController')->{'authRegisterUser'}($email,$role);
        //Notify User
    	if($result)
        {
            return \Redirect::to('dashboard/admin/users')->with('status','success')->with('message','User Created');
        }
        else
        {
             return \Redirect::to('dashboard/admin/users')->with('status','error')->with('message','Something Went Wrong');
        }
    }
    /**
     * Manage Users
     * @param int
     * @return JSON
     */
    public function manageUsers($userId)
    {
        //Get all data
        $data = \Input::json()->all();
        $result = $this->user->manageUsers($data);
       //Display Appropriate Notification
       if($result)
       {
            return \Response::json(array(
                'error' => false),
                200);
        }
        else
        {
            return \Response::json(array(
                'error' => true),
                500);
        }
    }
    /**
     * Generate View for Change Role
     * @param int
     * @return View
     */
    public function getChangeRole($userId)
    {
        $result = $this->user->getChangeRole($userId);
        return \View::make('dashboard.users.editrole')
                    ->with('user',$result);
    }
    /**
     * Update role for user
     * @return Redirect
     */
    public function postChangeRole()
    {
        //get data
        $data = \Input::all();
        if($data['oldrole'] == 'admin')
        {
            //Check if atlease one admin exists
                $adminCheck = $this->user->checkForOtherAdmins($data);
                if(!$adminCheck)
                {
                     throw new \Exception('Atlease one admin needed');
                }
        }
        $result = $this->user->postChangeRole($data);
        //Redirect with proper notifications
        if($result)
        {
            return \Redirect::to('dashboard/admin/users')->with('status','success')->with('message','Role Changed');
        }
        else
        {
             return \Redirect::to('dashboard/admin/users')->with('status','error')->with('message','Something Went Wrong');
        }
        
    }
    /**
     * Delete User
     * @return Redirect
     */
    public function deleteUser()
    {
        //Get the User Id
        $userId = \Input::get('userId');
        //Delete User
        $result = $this->user->deleteUser($userId);
         //Redirect with proper notifications
        if($result)
        {
            return \Redirect::to('dashboard/admin/users')->with('status','success')->with('message','User Deleted');
        }
        else
        {
             return \Redirect::to('dashboard/admin/users')->with('status','error')->with('message','Something Went Wrong');
        }
    }
    /**
     * Generate View for Adding User with Details
     * @return View
     */
    public function getAddUserWithDetails()
    {
        return \View::make('dashboard.users.adduserwithdetails');
    }
    /**
     * Add User with Details
     *@return Redirect
     */
    public function postAddUserWithDetails()
    {
        //Get all data
        $data = \Input::all();
        //Add user
        $result = $this->user->addUserWithDetails($data);
         //Redirect with proper notifications
        if($result)
        {
            return \Redirect::to('dashboard/admin/users')->with('status','success')->with('message','User Created');
        }
        else
        {
             return \Redirect::to('dashboard/admin/users')->with('status','error')->with('message','Something Went Wrong');
        }
    }
    /**
     * Change Email of user
     * @param int
     * @return View
     */
    public function getChangeEmail($userId)
    {
        //Find User
        $user = \User::find($userId);
        //Get old email
        $email = $user->email;
         $breadCrumb = '<a href='.url('dashboard/admin').'>Admin</a> / <a href='.url('dashboard/admin/users').'>Users</a> / Change Email' ;
        return \View::make('dashboard.users.changeemail')
                        ->with('userId',$userId)
                        ->with('oldEmail',$email)
                        ->with('showNote',false)
                        ->with('breadCrumb',$breadCrumb);
    }
    /**
     * Update User's Email
     * @return Redirect
     */
    public function postChangeEmail()
    {
        //Get data
        $data = \Input::all();
        //Change email
        $result = $this->user->changeUserEmail($data);
        //Redirect with proper notifications
         if($result)
        {
            return \Redirect::to('dashboard/admin/users')->with('status','success')->with('message','Email Changed');
        }
        else
        {
             return \Redirect::to('dashboard/admin/users')->with('status','error')->with('message','Something Went Wrong');
        }
    }
    /**
     * Generate View for Change Password for User
     * @param int
     * @return View
     */
    public function getChangePassword($userId)
    {
        $breadCrumb = '<a href='.url('dashboard/admin').'>Admin</a> / <a href='.url('dashboard/admin/users').'>Users</a> / Change Password';
       // var_dump($breadCrumb);
        return \View::make('dashboard.users.changepassword')
                        ->with('userId',$userId)
                        ->with('breadCrumb',$breadCrumb);
    }
    /**
     * Update User's Password
     * @return Redirect
     */
    public function postChangePassword()
    {
        //Get new password and UserId
        $password = \Input::get('password');
        $userId = \Input::get('userId');
        //Update Password
        $result = $this->user->updatePassword($userId,$password);
        //Redirect with proper notifications
        if($result == 'success')
        {
            return \Redirect::to('dashboard/admin/users')->with('status','success')->with('message','Password Updated');
        }
        else
        {
             return \Redirect::to('dashboard/admin/users')->with('status','error')->with('message','Something Went Wrong');
        }
    }
}