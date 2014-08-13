<?php 
use \User as User;
use \UserProfile as UserProfile;
use \SomeThingWentWrongException as SomeThingWentWrongException;
/**
 * Todo Repository.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class UserRepository implements UserInterface{

	public function getUserProfile($userId)
	{
        try
        {
    		$user['mainData'] = User::find($userId)->toArray();
    		$tempprofile = UserProfile::find($userId);
    		if($tempprofile == null)
    		{
    				$user['profile']['about'] = null;
    				$user['profile']['website'] = null;
    				$user['profile']['phone'] = null;
    				$user['profile']['facebook'] = null;
    				$user['profile']['twitter'] = null;
    				$user['profile']['googleplus'] = null;
    		}
    		else
    		{
    			$user['profile'] = $tempprofile->toArray();
    		}
    		return $user;
        }
        catch(\Exception $e)
        {
            \Log::error('Something Went Wrong in User Repository - getUserProfile():'. $e->getMessage());
            throw new SomeThingWentWrongException();
        }
	}
	
	public function changeMyEmail($userId,$newEmail)
	{
		try
        {	
    			$checkEmail = \User::where('email',$newEmail)->get()->toArray();
    			if(sizeof($checkEmail) == 0)
    			{
    				$result = \Email::sendEmailAddressVerifyEmail($userId,$newEmail);
    				return 'success';
    			}
    			else
    			{
    				return 'error';
    			}
        }
        catch(\Exception $e)
        {
            \Log::error('Something Went Wrong in User Repository - changeMyEmail():'. $e->getMessage());
            throw new SomeThingWentWrongException();
        }
	}
	public function updatePassword($userId,$password)
	{
		try
		{
			$user = \Sentry::findUserById($userId);
			$user->password = $password;
			$user->save();
			return 'success';
		}
		catch (\Exception $e)
		{
			  \Log::error('Something Went Wrong in User Repository - updatePassword():'. $e->getMessage());
            throw new SomeThingWentWrongException();
	   	}

	}
	public function getAllUsersData()
    {
       try{
        	$users = array();
             $tempUsers = \User::all()->toArray();
             foreach($tempUsers as $user)
             {
             	$banned = false;
             	$suspended  = false;
             	$loginAttempt = 0;
             	$usersThrottle = \Throttle::where('user_id',$user['id'])->get()->toArray();
             	if(sizeof($usersThrottle) != 0)
             	{
             		foreach($usersThrottle as $userThrottle)
             		{

             			if($userThrottle['banned'] == true)
             			{
             				$banned = true;
             			}
             			if($userThrottle['suspended'] == true)
             			{
             				$suspended = true;
             			}
             			$loginAttempt = $loginAttempt + $userThrottle['attempts'];
             		}

             		$user['banned'] = $banned;
             		$user['suspended'] = $suspended;
             		$user['loginAttempt'] = $loginAttempt;

             	}
                else
                {
                    $user['banned'] = false;
                    $user['suspended'] = false;
                    $user['loginAttempt'] = 0;
                }
                $groupUser = \Sentry::findUserById($user['id']);
                $groups = $groupUser->getGroups()->toArray();
                if(sizeof($groups)!=0)
                {
                 $user['role'] =$groups[0]['name'];
                }
                else
                {
                    $user['role'] = '';
                }
             	$users [] = $user;

             }
             return $users;
        }
       catch (\Exception $e)
		{
			 \Log::error('Something Went Wrong in User Repository - getAllUsersData():'. $e->getMessage());
            throw new SomeThingWentWrongException();
	   	}
    }
    
    public function updateMyDetails($userId,$data)
    {
       try
       {
            $user = \User::find($userId);
            $user->first_name = $data['first_name'];
            $user->last_name = $data['last_name'];
            $user->save();
            $userProfile = \UserProfile::find($userId);
            $userProfile->facebook = $data['facebook'];
            $userProfile->twitter = $data['twitter'];
            $userProfile->googleplus = $data['googleplus'];
            $userProfile->about = $data['about'];
            $userProfile->website = $data['website'];
            $userProfile->phone = $data['phone'];
            $userProfile->save();
            $userProfile = \File::delete(public_path().'/images/profilepics/'.$userId.'.png');
            $imageResult = \App::make('AuthController')->{'createUserImage'}($user->id,$data['first_name'][0],$data['last_name'][0]);
            return 'success';
       }
        catch(\Exception $e)
        {
             \Log::error('Something Went Wrong in User Repository - updateMyDetails():'. $e->getMessage());
            return 'error';    
        }  
    }
    public function manageUsers($data)
    {

        if($data['action'] == 'activate')
        {
            try
            {

                $userId = $data['id'];
                $user = \User::find($userId);
                $user->activated = true;
                $user->activated_at = date_create();
                $user->save();
                return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - manageUsers()-activate:'. $e->getMessage());
                return false;
            }
           
        }
        if($data['action'] == 'deactivate')
        {
           try
           {
                    $userId = $data['id'];
                    $user = \User::find($userId);
                    $user->activated = false;
                    $user->save();
                    return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - manageUsers()-deactivate:'. $e->getMessage());
                return false;
            }
        }

        if($data['action'] == 'unsuspend')
        {
            try
            {
                $user = \Sentry::findThrottlerByUserId($data['id']);
                 if($suspend = $user->isSuspended())
                {
                    $user->unsuspend();
                }
                else
                {
                
                }        
                
                return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - manageUsers()-unsuspend:'. $e->getMessage());
                return false;
            }

        }
        if($data['action'] == 'suspend')
        {
            try
            {
                $user = \Sentry::findThrottlerByUserId($data['id']);
                if($suspend = $user->isSuspended())
                {

                }
                else
                {
                    $user->suspend();
                }                
                return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - manageUsers()-suspend:'. $e->getMessage());
                return false;
            }
        }
        if($data['action'] == 'unbanned')
        {
             try
            {
                $user = \Sentry::findThrottlerByUserId($data['id']);
                if($suspend = $user->isBanned())
                {   
                    $user->unBan();

                }
                else
                {
                    
                }                
                return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - manageUsers()-unbanned:'. $e->getMessage());
                return false;
            }

        }
        if($data['action'] == 'ban')
        {
             try
            {
                $user = \Sentry::findThrottlerByUserId($data['id']);
                if($suspend = $user->isBanned())
                {

                }
                else
                {
                    $user->ban();
                }                
                return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - manageUsers()-ban:'. $e->getMessage());
                return false;
            }
        }
    }
    public function getChangeRole($userId)
    {
         try
         {
             $user = \User::find($userId)->toArray();
             $groupUser = \Sentry::findUserById($user['id']);
             $groups = $groupUser->getGroups()->toArray();
             $user['role'] = $groups[0]['name'];
             return $user;
        }
        catch(\Exception $e)
        {
            \Log::error('Something Went Wrong in User Repository - getChangeRole():'. $e->getMessage());
            throw new \SomeThingWentWrongException();
        }
    }
    public function postChangeRole($data)
    {
        try
        {
            $user = \Sentry::findUserById($data['userid']);
            $oldGroup = \Sentry::findGroupByName($data['oldrole']);
            $user->removeGroup($oldGroup);
            $newGroup = \Sentry::findGroupByName($data['newrole']);
            $user->addGroup($newGroup);
            return true;
        }
        catch(\Exception $e)
        {
            \Log::error('Something Went Wrong in User Repository - postChangeRole():'. $e->getMessage());
            return false;
        }
    }
    public function deleteUser($userId)
    {
        try
        {
            $user = \Sentry::findUserById($userId);
            $user->delete();
            $quicknote = \Quicknote::where('user_id')->forceDelete();
            $userProfile = \File::delete(public_path().'/images/profilepics/'.$userId.'.png');
            return true;
        }
        catch(\Exception $e)
        {
             \Log::error('Something Went Wrong in User Repository - deleteUser():'. $e->getMessage());
            return false;
        }
    }
    public function checkForOtherAdmins($data)
    {
         try
         {  
            $userId = $data['userid'];
            $group = \Sentry::findGroupByName('admin');
            $users = \Sentry::findAllUsersInGroup($group)->toArray();
            if(sizeof($users) == 0)
            {
                    throw new \Exception('this cant be right');
            }
            if(sizeof($users) == 1)
            {
                if($users[0]['id'] == $userId)
                {
                    return false;
                }
            }
            return true;
        }
        catch(\Exception $e)
        {
            \Log::error('Something Went Wrong in User Repository - checkForOtherAdmins():'. $e->getMessage());
        }
    }
    public function addUserWithDetails($data)
    {
        $checkEmail = \User::where('email',$data['email'])->get()->toArray();
        if(sizeof($checkEmail) != 0)
        {
            throw new \Exception('User with Email Already Exists');
        }
        try
        {
            $user = \Sentry:: createUser(array(
                'email'=> $data['email'],
                'password'=>$data['password'],
                'activated'=>true,
                'first_name'=>$data['first_name'],
                'last_name'=>$data['last_name'],
                ));
            $group = \Sentry::findGroupByName($data['role']);
            $user->addGroup($group);
            $quicknote = new \Quicknote;
            $quicknote->user_id = $user->id;
            $quicknote->save();
            $userProfile = new \UserProfile;
            $userProfile->id = $user->id;
            $userProfile->save(); 
            $imageResult = \App::make('AuthController')->{'createUserImage'}($user->id,$data['first_name'][0],$data['last_name'][0]);
            return true;
        }
        catch(\Exception $e)
        {
            \Log::error('Something Went Wrong in User Repository - addUserWithDetails():'. $e->getMessage());
            return false;
        }    

    }
    public function changeUserEmail($data)
    {

            $checkEmail = \User::where('email',$data['newEmail'])->get()->toArray();
            if(sizeof($checkEmail) != 0)
            {
                throw new Exception("Email Already registered.");
            }
            try
            {
                $user = \Sentry::findUserByLogin($data['oldemail']);
                $user->email = $data['newEmail'];
                $user->save();
                return true;
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in User Repository - changeUserEmail():'. $e->getMessage());
                return false;
            }       
    }
}