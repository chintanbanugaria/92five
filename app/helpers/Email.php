<?php
/**
 *  Email Class.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class Email{


	/**
	 * Sends Forgot Password Email
	 * @param string
	 * @return bool
	 */
	public static function sendForgotPasswordEmail($email)
	{
		try
		{
		    // Find the user using the user email address
		    $user = Sentry::getUserProvider()->findByLogin($email);

		    // Get the password reset code
		    $resetCode = $user->getResetPasswordCode();

		    //send this code to your user via email.
		    $name = $user->first_name.' '.$user->last_name;
		    $link = (string)url().'/auth/recoverpassword?password_reset_token='.$resetCode.'&email='.$email;
		    $data = array(
		    	'name' => $name,
		    	'link' => $link,
		    		);
		    Mail::queue('emails.auth.forgotpassword', $data, function($message) use ($user)
			{
			    $message->to($user->email)->subject('Forgot Password Assistance');
			});
			return true;

		}
		catch (Cartalyst\Sentry\Users\UserNotFoundException $e)
		{
		    	return Redirect::to('login')->with('message','error104');
		}
		catch (Cartalyst\Sentry\Users\UserNotActivatedException $e)
		{
			return Redirect::to('login')->with('message','error103');
		}
		catch (Cartalyst\Sentry\Users\UserSuspendedException $e)
		{
			return Redirect::to('login')->with('message','error105');
		}
		catch (Cartalyst\Sentry\Users\UserBannedException $e)
		{
			return Redirect::to('login')->with('message','error102');
		}			
	}
	/**
	 * Send User Actication Email
	 * @param string, string
	 * @return bool
	 */
	public static function sendUserActivationEmail($email,$role)
	{
			$tempPassword = Str::random(9);
			try 
			{

				$user = Sentry::register(array(
        		'email'    => $email,
        		'password' => $tempPassword,
    			));
    			$activationCode = $user->getActivationCode();	
    			$group = Sentry::findGroupbyName($role);
    			$user->addGroup($group);	    		
				$link = (string)url().'/auth/activateuser?activation_token='.$activationCode.'&email='.$email;
				$data = array(
			    	'link' => $link,
			    		);
				Mail::queue('emails.auth.activateuser', $data, function($message) use ($email)
				{
				    $message->to($email)->subject('Invitation to Join 92five app');
				});
				return true;
			}
			catch (Exception $e)
			{
   				Log::error('Something went Wrong in Email Class - sendUserActivationEmail():'.$e->getMessage());
   				return false;
			}
	}
	/**
	 * Send Address Verify Email
	 * @param int, string
	 * @return bool
	 */
	public static function sendEmailAddressVerifyEmail($userId, $newEmail)
	{
		try
		{	
			$tempLink = Str::random(64);
			$user = \User::find($userId);
			$name = $user->first_name.' '.$user->last_name;
			$link = (string)url().'/auth/verifyemail?token='.$tempLink.'&email='.$newEmail;
			$data = array(
		    	'link' => $link,
		    	'name' => $name,
		    		);
			Mail::queue('emails.auth.emailverify', $data, function($message) use ($newEmail)
			{
			    $message->to($newEmail)->subject('Email Verification');
			});
			$user = \User::find($userId);
			$user->email_verify_code = $tempLink;
			$user->email = $newEmail;
			$user->activated = false;
			$user->save();
			return true;
		}
		catch(Exception $e)
		{
			Log::error('Something went Wrong in Email Class - sendEmailAddressVerifyEmail():'.$e->getMessage());
   			return false;
		}

	}

}