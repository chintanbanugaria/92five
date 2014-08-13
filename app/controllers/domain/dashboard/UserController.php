<?php namespace Controllers\Domain\Dashboard;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;

/**
 * Todo Controller.    
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
	 * Get the profile of User
	 * @return View
	 */
	public function myProfile()
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Get Profile
		$data = $this->user->getUserProfile($userId);
		return \View::make('dashboard.users.userprofile')
					->with('data',$data);
	}
	/**
	 * View User Profile
	 * @param int
	 * @return View
	 */
	public function getUser($userId)
	{
		$data = $this->user->getUserProfile($userId);
		return \View::make('dashboard.users.userprofile')
					->with('data',$data);
	}
	/**
	 * Edit User Details
	 * @return View
	 */
	public function editMyDetails()
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Get Profile
		$data = $this->user->getUserProfile($userId);
		return \View::make('dashboard.users.editdetails')
					->with('data',$data);
	}
    /**
     * Update User Details
     * @return Redirect
     */
    public function postEditMyDetails()
    {
		//Get the user id of the currently logged in user
        $userId =  \Sentry::getUser()->id;
        //Get data
        $data = \Input::all();
        //Update User Details
        $result = $this->user->updateMyDetails($userId,$data);
        if($result == 'success')
		{
			return \Redirect::to('dashboard/me')->with('status','success')->with('message','Details Updated');
		}
       if($result == 'error')
		{
			return \Redirect::to('dashboard/me')->with('status','eroor')->with('message','Something Went Wrong !');
		}
        
    }
    /**
     * Change Email
     * @return View
     */
	public function changeEmail()
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		$user = \User::find($userId);
		$email = $user->email;
		$breadCrumb = '<a href='.url('dashboard/me').'>Me</a> / Change My Email' ;
		return \View::make('dashboard.users.changeemail')
						->with('userId',$userId)
						->with('oldEmail',$email)
						->with('showNote',true)
						->with('breadCrumb',$breadCrumb);

	}
	/**
	 * Update User Email
	 * @return Redirect
	 */
	public function postChangeEmail()
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Get new email
		$newEmail = \Input::get('newEmail');
		//Change Email
		$result = $this->user->changeMyEmail($userId,$newEmail);
		if($result == 'success')
		{	//Log out to verify new email address
			\Sentry::logout();
			return \Redirect::to('/login');
		}
		if($result == 'error')
		{
			//Email Already Exists in the database
			\Log::error("Someting Went Wrong: Email Alredy exists.");
			throw new \SomethingWentWrongException();
		}
	}
	/**
	 * Change Password
	 * @return View
	 */
	public function changePassword()
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		$breadCrumb = '<a href='.url('dashboard/me').'>Me</a> / Change My Password' ;
		return \View::make('dashboard.users.changepassword')
						->with('userId',$userId)
						->with('breadCrumb',$breadCrumb);
	}
	/**
	 * Update Password
	 * @return Redirect
	 */
	public function postChangePassword()
	{
		//Get the user id of the currently logged in user
		$userId =  \Sentry::getUser()->id;
		//Get new Password
		$password = \Input::get('password');
		//Update Password
		$result = $this->user->updatePassword($userId,$password);
		return \Redirect::to('dashboard/me')->with('status','success')->with('message','Password Updated');
	}
}