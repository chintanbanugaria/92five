<?php
use Cartalyst\Sentry\Users\WrongPasswordException as WrongPasswordException;
use Cartalyst\Sentry\Users\UserNotFoundException as UserNotFoundException;
use Cartalyst\Sentry\Users\UserNotActivatedException as UserNotActivatedException;
use Cartalyst\Sentry\Throttling\UserSuspendedException as UserSuspendedException;
use Cartalyst\Sentry\Throttling\UserBannedException as UserBannedException;
/**
 * Authentication Controller.
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/

class AuthController extends BaseController{

	/** 
	*	Check the credentials of the user
	*/

	public function authLogin()
	{
			
		$email = Input::get('loginEmail');
		$password = Input::get('loginPass');
		try
		{
    		// Set login credentials
    		$credentials = array(
        		'email'    => $email,
       			'password' => $password,
    		);

    		// Try to authenticate the user
    		$user = Sentry::authenticate($credentials, true);
    		return View::make('login.splash');
		}

		//Different Exceptions to Display appropriate error message on the login screen
		
		catch (WrongPasswordException $e)
		{
			 return Redirect::to('login')->with('message','error101');
		}
		catch (UserNotFoundException $e)
		{
			return Redirect::to('login')->with('message','error104');
		}
		catch (UserNotActivatedException $e)
		{
			return Redirect::to('login')->with('message','error103');
		}
		catch (UserSuspendedException $e)
		{
			return Redirect::to('login')->with('message','error105');
		}
		catch (UserBannedException $e)
		{
			return Redirect::to('login')->with('message','error102');
		}			
	}

	/** 
	*	Forgot Password Link 
	*/
	public function authForgotPassword()
	{
		//Get the email from the user
		$email = Input::get('recoverEmail');
		try
		{
			//Check if the user exists
			$user = Sentry::findUserByLogin($email);
			
			// Send the forgot password link to the user
			$result = Email::sendForgotPasswordEmail($email);
			
			if($result)
			{
				//Email Sent. Notify the user.
				return Redirect::to('login')->with('message','success101');	
			
			}
		}
		catch(UserNotFoundException $e)
		{
			return Redirect::to('login')->with('message','error104');
		}
	}

	/**
	*	Check for the forgot password token and generate the forgot password form
	*/
	public function authRecoverPassword()
	{
		
		$token = $_GET['password_reset_token'];
		$email = $_GET['email'];
		try
		{
			$user = Sentry::getUserProvider()->findByLogin($email);

    		// Check if the reset password code is valid
    		if ($user->checkResetPasswordCode($token))
    		{
				return View::make('login.recoverpassword')
									->with('email',$email)
									->with('token',$token);
			}
			else
			{
					Log::error('Something Went Wrong Exception - Invalid Recover Password Token for email '.$email);
					throw new SomeThingWentWrongException();

			}	
		}
		catch(UserNotFoundException $e)
		{
			return Redirect::to('login')->with('message','error104');
		}								
	}

	/**
	*	Update Password 
	*/
	public function authUpdatePassword()
	{
		$email = Input::get('email');
		$token = Input::get('token');
		$password = Input::get('password');
		try
		{
			$user = Sentry::getUserProvider()->findByLogin($email);
		
			//Update Password for the user
			if ($user->attemptResetPassword($token, $password))
        	{
            	return Redirect::to('login')->with('message','success104');
        	}
        	else
        	{
            	Log::error('Something Went Wrong Exception - Update Password failed for '.$email);
					throw new SomeThingWentWrongException();
        	}

    	}
    	catch(UserNotFoundException $e)
		{
			return Redirect::to('login')->with('message','error104');
		}	
	}

	/**
	*	Register User with Email
	*/
	public function authRegisterUser($email,$role)
	{
		//Send the Actication Link to the user via Email
		$result = Email::sendUserActivationEmail($email,$role);

		if($result)
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	*	Check for the actication code and generate new user form
	*/
	public function authActivateUser()
	{
		try
		{
			$token = $_GET['activation_token'];
			$email = $_GET['email'];
			$user = Sentry::getUserProvider()->findByActivationCode($token);
			if($user->email == $email)
			{
				return View::make('login.register')
						     ->with('email',$email)
							->with('token', $token);
			}
			else
			{
				Log::error('Something Went Wrong Exception - Invalid Aactivaton Token for email '.$email);
				throw new SomeThingWentWrongException();
			}
		}
		catch(UserNotFoundException $e)
		{
			Log::error('Something Went Wrong Exception - Invalid Aactivaton Token for email '.$e->getMessage());
				throw new SomeThingWentWrongException();
		}

	}

	/**
	*  Verify the Email if the user has changed the email in the application
	*/
	public function authVerifyEmail()
	{
		$token = $_GET['token'];
		$email = $_GET['email'];
		try
		{
			//Check if user exists
			$user =  Sentry::findUserByLogin($email);
			
			//Verify the code
			if($user->email_verify_code == $token)
			{
				//Acticate User
				$user->activated = true;
				$user->save();
				return Redirect::to('login')->with('message','success102');
			}
			else
			{
				//Display the appropriate error message to the user
				return Redirect::to('login')->with('message','error103');
			}
		}
		catch(UserNotFoundException $e)
		{
			return Redirect::to('login')->with('message','error104');
		}	
	}

	/**
	*	Create User
	*/
	public function authCreateUser()
	{
		$data = Input::all();
		try
		{
		    // Find the user using the user id
		    $user = Sentry::getUserProvider()->findByLogin($data['email']);

		    // Attempt to activate the user
			$result = $user->attemptActivation($data['token']);
			
			//Assign the data
			$user->password = $data['password'];
			$user->first_name = ucfirst($data['first_name']);
			$user->last_name = ucfirst($data['last_name']);
				
			//Generate the profile pic
			$result = static::createUserImage($user->id, $user->first_name, $user->last_name);
				
			// Create a row for user in Quick Note Table
			$quicknote = new Quicknote;
			$quicknote->user_id = $user->id;
			$quicknote->save();

			//Create a row for user in User Profile Table
			$userProfile = new UserProfile;
			$userProfile->id = $user->id;
			$userProfile->save();					    
						    
			//Update the user and save all data
			if ($user->save())
			{
				//Redirect the user to the login page with appropriate display message
				return Redirect::to('login')->with('message','success103');
			}
			else
			{
					Log::error('Something Went Wrong Exception - Creating User for email '.$data['email']);
					throw new SomeThingWentWrongException();
			}
		}
		catch (UserNotFoundException $e)
		{
			throw new UserNotFoundException();
		}
		catch (UserAlreadyActivatedException $e)
		{
			Log::error('Something Went Wrong Exception - User is already activated for email '.$data['email']);
			throw new SomeThingWentWrongException();
		}
	}
	/**
	*	Generate the profile pic for the user
	*/
	public static function createUserImage($userId,$firstName,$lastName)
	{
		// Height and Width of the image
		try
		{
			$width = 128;
			$height = 128;

			//GD library's functions
			$image = imageCreate($width, $height);
			$background = imageColorAllocate($image, 42, 109, 26);  //Use different combination of RGB Values for different Shades of Green
			$fontColor = imageColorAllocate($image, 255, 255, 255); //Font Color is Kept White
			$font = 'assets/css/fonts/Lato-Lig-webfont.ttf'; // Path fot ttf file
			imagettftext($image, 64, 0, 10, 90, $fontColor, $font, $firstName[0].$lastName[0]); //[Source_Image,Font_Size,Angle,X_Co-ordinate,y_Co-ordinate,Font_color,Fonts,TEXT]
			imagepng($image,'assets/images/profilepics/'.$userId.'.png'); // Save the png image
			return true;
		}
		catch(Exception $e)
		{
			Log::error('create user image error for '.$firstName.' '.$lastName.'error: '.$e->getMessage());
			throw new SomeThingWentWrongException();
		}
	}

}