<?php

class UserRepositoryTest extends \TestCase
{
    public function testAddUserWithDetailsDuplicatedEmail()
    {
        $alice = $this->generateAdminUser();
        $repo = new UserRepository();

        $data = array(
            'first_name' => 'Alice',
            'last_name' => 'NotExample',
            'email' => 'alice@example.com',
            'password' => 'sharedsecret',
            'role' => 'admin',
        );

        $exceptionGood = false;
        try {
            $result = $repo->addUserWithDetails($data);
        } catch (Exception $e) {
            $this->assertEquals('User with Email Already Exists', $e->getMessage());
            $exceptionGood = true;
        }
        $this->assertTrue($exceptionGood);
    }

    public function testAddUserNoData()
    {
        $repo = new UserRepository();
        $data = array();

        $result = $repo->addUserWithDetails($data);
        $this->assertFalse($result);
    }

    public function testAddUserBadData()
    {
        $alice = $this->generateAdminUser();
        $repo = new UserRepository();

        $data = array(
            'email' => 'leonidas@sparta.net',
        );
        $result = $repo->addUserWithDetails($data);
        $this->assertFalse($result);
    }

    public function testAddUserGoodData()
    {
        $oldQuickNoteCount = \Quicknote::all()->count();
        $oldUserProfileCount = \UserProfile::all()->count();

        $repo = new UserRepository();
        $data = array(
            'first_name' => 'Alice',
            'last_name' => 'Example',
            'email' => 'alice@example.com',
            'password' => 'bruceschneier',
            'role' => 'manager'
        );

        $result = $repo->addUserWithDetails($data);
        $this->assertTrue($result);
        $user = \User::where('email','=',$data['email'])->first();

        $this->assertEquals($data['first_name'], $user->first_name);
        $this->assertEquals($data['last_name'], $user->last_name);
        $this->assertEquals(true, $user->activated);

        $newQuickNoteCount = \Quicknote::all()->count();
        $newUserProfileCount = \UserProfile::all()->count();
        $this->assertEquals($oldQuickNoteCount + 1, $newQuickNoteCount);
        $this->assertEquals($oldUserProfileCount +1, $newUserProfileCount);
    }

    public function testDeactivateActivateRoundTrip()
    {
        $alice = $this->generateAdminUser();
        $aliceId = $alice->id;
        $this->assertTrue($alice->activated);
        unset($alice);

        $repo = new UserRepository();
        $data = array(
            'action' => 'deactivate',
            'id' => $aliceId
        );

        $result = $repo->manageUsers($data);
        $this->assertTrue($result);

        $alice = \User::find($aliceId)->first();
        $this->assertFalse($alice->activated);
        unset($alice);

        $data['action'] = 'activate';
        $result = $repo->manageUsers($data);
        $this->assertTrue($result);
        $alice = \User::find($aliceId)->first();
        $this->assertTrue($alice->activated);
    }

    public function testSuspendUnsuspendRoundTrip()
    {
        $fullThrottle = new Cartalyst\Sentry\Throttling\Eloquent\Throttle();
        $fullThrottle->attempts = 0;
        $fullThrottle->suspended = 0;
        $fullThrottle->banned = 0;

        $alice = $this->generateAdminUser();
        $aliceId = $alice->id;
        $fullThrottle->user_id = $aliceId;
        $fullThrottle->save();

        $alice = \Sentry::findThrottlerByUserId($aliceId);
        $this->assertFalse($alice->isSuspended());
        unset($alice);

        $repo = new UserRepository();
        $data = array(
            'action' => 'suspend',
            'id' => $aliceId
        );

        $result = $repo->manageUsers($data);
        $this->assertTrue($result);

        $alice = \Sentry::findThrottlerByUserId($aliceId);
        $this->assertTrue($alice->isSuspended());
        unset($alice);

        $data['action'] = 'unsuspend';
        $result = $repo->manageUsers($data);
        $this->assertTrue($result);
        $alice = \Sentry::findThrottlerByUserId($aliceId);
        $this->assertFalse($alice->isSuspended());
    }


    public function testBanUnbanRoundTrip()
    {
        $fullThrottle = new Cartalyst\Sentry\Throttling\Eloquent\Throttle();
        $fullThrottle->attempts = 0;
        $fullThrottle->suspended = 0;
        $fullThrottle->banned = 0;

        $alice = $this->generateAdminUser();
        $aliceId = $alice->id;
        $fullThrottle->user_id = $aliceId;
        $fullThrottle->save();

        $alice = \Sentry::findThrottlerByUserId($aliceId);
        $this->assertFalse($alice->isBanned());
        unset($alice);

        $repo = new UserRepository();
        $data = array(
            'action' => 'ban',
            'id' => $aliceId
        );

        $result = $repo->manageUsers($data);
        $this->assertTrue($result);

        $alice = \Sentry::findThrottlerByUserId($aliceId);
        $this->assertTrue($alice->isBanned());
        unset($alice);

        $data['action'] = 'unbanned';
        $result = $repo->manageUsers($data);
        $this->assertTrue($result);
        $alice = \Sentry::findThrottlerByUserId($aliceId);
        $this->assertFalse($alice->isBanned());
    }

    public function testBanBadData()
    {
        $repo = new UserRepository();
        $data = array(
            'action' => 'ban',
        );

        $result = $repo->manageUsers($data);
        $this->assertFalse($result);
    }

    public function testUnbanBadData()
    {
        $repo = new UserRepository();
        $data = array(
            'action' => 'unbanned',
        );

        $result = $repo->manageUsers($data);
        $this->assertFalse($result);
    }

    public function testSuspendBadData()
    {
        $repo = new UserRepository();
        $data = array(
            'action' => 'suspend',
        );

        $result = $repo->manageUsers($data);
        $this->assertFalse($result);
    }

    public function testUnsuspendBadData()
    {
        $repo = new UserRepository();
        $data = array(
            'action' => 'unsuspend',
        );

        $result = $repo->manageUsers($data);
        $this->assertFalse($result);
    }

    public function testActivateBadData()
    {
        $repo = new UserRepository();
        $data = array(
            'action' => 'activate',
        );

        $result = $repo->manageUsers($data);
        $this->assertFalse($result);
    }

    public function testDeactivateBadData()
    {
        $repo = new UserRepository();
        $data = array(
            'action' => 'deactivate',
        );

        $result = $repo->manageUsers($data);
        $this->assertFalse($result);
    }

    public function testGetAllUsersData()
    {
        $alice = $this->generateAdminUser();
        $bob = $this->generateManagerUser();
        $repo = new UserRepository();

        $fullThrottle = new Cartalyst\Sentry\Throttling\Eloquent\Throttle();
        $fullThrottle->attempts = 0;
        $fullThrottle->suspended = 1;
        $fullThrottle->banned = 1;
        $fullThrottle->user_id = $bob->id;
        $fullThrottle->save();

        $result = $repo->getAllUsersData();
        $this->assertEquals(2, count($result));
        $this->assertEquals(true, $result[0]['activated']);
        $this->assertEquals(false, $result[0]['banned']);
        $this->assertEquals(false, $result[0]['suspended']);
        $this->assertEquals('admin', $result[0]['role']);
        $this->assertEquals(0, $result[0]['loginAttempt']);
        $this->assertEquals(true, $result[1]['activated']);
        $this->assertEquals(true, $result[1]['banned']);
        $this->assertEquals(true, $result[1]['suspended']);
        $this->assertEquals('manager', $result[1]['role']);
        $this->assertEquals(0, $result[1]['loginAttempt']);
    }

    public function testUpdateMyDetailsNullData()
    {
        $repo = new UserRepository();
        $data = null;
        $userId = null;

        $result = $repo->updateMyDetails($data, $userId);
        $this->assertEquals('error', $result);
    }

    public function testUpdateMyDetailsGoodData()
    {
        $bob = $this->generateManagerUser();
        $bobId = $bob->id;
        unset($bob);

        $bobProfile = new \UserProfile();
        $bobProfile->save();
        $bobProfileId = $bobProfile->id;
        unset($bobProfile);

        $repo = new UserRepository();

        $data = array (
            'first_name' => 'Robert',
            'last_name' => 'Dobalina',
            'googleplus' => 'mistadobalina',
            'facebook' => 'RobertDobalina',
            'twitter' => 'mistadobalina',
            'about' => 'about',
            'phone' => '',
            'website' => ''
        );

        $result = $repo->updateMyDetails($bobId, $data);
        $this->assertEquals('success', $result);

        // recover updated models to check that update landed
        $bob = \User::find($bobId);
        $bobProfile = \UserProfile::find($bobProfileId);
        $this->assertEquals($data['first_name'], $bob->first_name);
        $this->assertEquals($data['last_name'], $bob->last_name);
        $this->assertEquals($data['googleplus'], $bobProfile->googleplus);
        $this->assertEquals($data['facebook'], $bobProfile->facebook);
        $this->assertEquals($data['twitter'], $bobProfile->twitter);
        $this->assertEquals($data['about'], $bobProfile->about);
        $this->assertEquals($data['phone'], $bobProfile->phone);
        $this->assertEquals($data['website'], $bobProfile->website);
    }

    public function testGetUserProfileBadUserIdShouldThrowSomeThingWentWrong()
    {
        $repo = new UserRepository();
        $correctException = false;

        try {
            $result = $repo->getUserProfile(-1);
        } catch (SomeThingWentWrongException $e) {
            $correctException = true;
        }
        $this->assertTrue($correctException);
    }

    public function testGetUserGoodUserIdNullProfile()
    {
        $bob = $this->generateManagerUser();
        $bobId = $bob->id;
        unset($bob);
        $repo = new UserRepository();

        $bob = \User::find($bobId);

        $result = $repo->getUserProfile($bobId);
        $this->assertNull($result['profile']['about']);
        $this->assertNull($result['profile']['website']);
        $this->assertNull($result['profile']['phone']);
        $this->assertNull($result['profile']['facebook']);
        $this->assertNull($result['profile']['twitter']);
        $this->assertNull($result['profile']['googleplus']);
        $this->assertEquals($bob->email, $result['mainData']['email']);
        $this->assertEquals($bob->activated, $result['mainData']['activated']);
        $this->assertEquals($bob->first_name, $result['mainData']['first_name']);
        $this->assertEquals($bob->last_name, $result['mainData']['last_name']);
    }

    public function testGetUserProfileGoodUserIdWithGoodProfile()
    {
        $bob = $this->generateManagerUser();
        $bobId = $bob->id;
        $bobProfile = new \UserProfile;
        $bobProfile->googleplus = 'mistadobalina';
        $bobProfile->twitter = 'mistabobdobalina';
        $bobProfile->facebook = 'RobertDobalina';
        $bobProfile->website = "www.example.com";
        $bobProfile->save();
        $bobProfileId = $bobProfile->id;
        unset($bobProfile);
        unset($bob);
        $repo = new UserRepository();

        $bob = \User::find($bobId);
        $bobProfile = \UserProfile::find($bobProfileId);

        $result = $repo->getUserProfile($bobId);
        $this->assertNull($result['profile']['about']);
        $this->assertEquals($bobProfile->website, $result['profile']['website']);
        $this->assertNull($result['profile']['phone']);
        $this->assertEquals($bobProfile->facebook,$result['profile']['facebook']);
        $this->assertEquals($bobProfile->twitter,$result['profile']['twitter']);
        $this->assertEquals($bobProfile->googleplus,$result['profile']['googleplus']);
        $this->assertEquals($bob->email, $result['mainData']['email']);
        $this->assertEquals($bob->activated, $result['mainData']['activated']);
        $this->assertEquals($bob->first_name, $result['mainData']['first_name']);
        $this->assertEquals($bob->last_name, $result['mainData']['last_name']);
    }

    public function testAddUserDetailsWithBothNamesBlankShouldNotWork()
    {
        $oldQuickNoteCount = \Quicknote::all()->count();
        $oldUserProfileCount = \UserProfile::all()->count();

        $repo = new UserRepository();
        $data = array(
            'first_name' => '',
            'last_name' => '',
            'email' => 'alice@example.com',
            'password' => 'bruceschneier',
            'role' => 'manager'
        );

        $result = $repo->addUserWithDetails($data);
        $this->assertFalse($result);

        $newQuickNoteCount = \Quicknote::all()->count();
        $newUserProfileCount = \UserProfile::all()->count();
        $this->assertEquals($oldQuickNoteCount, $newQuickNoteCount);
        $this->assertEquals($oldUserProfileCount, $newUserProfileCount);
    }

    public function testAddUserDetailsWithOnlyFirstNameShouldWork()
    {
        $oldQuickNoteCount = \Quicknote::all()->count();
        $oldUserProfileCount = \UserProfile::all()->count();

        $repo = new UserRepository();
        $data = array(
            'first_name' => 'Alice',
            'last_name' => '',
            'email' => 'alice@example.com',
            'password' => 'bruceschneier',
            'role' => 'manager'
        );

        $result = $repo->addUserWithDetails($data);
        $this->assertTrue($result);
        $user = \User::where('email','=',$data['email'])->first();

        $this->assertEquals($data['first_name'], $user->first_name);
        $this->assertEquals($data['last_name'], $user->last_name);
        $this->assertEquals(true, $user->activated);

        $newQuickNoteCount = \Quicknote::all()->count();
        $newUserProfileCount = \UserProfile::all()->count();
        $this->assertEquals($oldQuickNoteCount + 1, $newQuickNoteCount);
        $this->assertEquals($oldUserProfileCount +1, $newUserProfileCount);
    }

    public function testAddUserDetailsWithOnlyLastNameShouldWork()
    {
        $oldQuickNoteCount = \Quicknote::all()->count();
        $oldUserProfileCount = \UserProfile::all()->count();

        $repo = new UserRepository();
        $data = array(
            'first_name' => '',
            'last_name' => 'Example',
            'email' => 'example@example.com',
            'password' => 'bruceschneier',
            'role' => 'manager'
        );

        $result = $repo->addUserWithDetails($data);
        $this->assertTrue($result);
        $user = \User::where('email','=',$data['email'])->first();

        $this->assertEquals($data['first_name'], $user->first_name);
        $this->assertEquals($data['last_name'], $user->last_name);
        $this->assertEquals(true, $user->activated);

        $newQuickNoteCount = \Quicknote::all()->count();
        $newUserProfileCount = \UserProfile::all()->count();
        $this->assertEquals($oldQuickNoteCount + 1, $newQuickNoteCount);
        $this->assertEquals($oldUserProfileCount +1, $newUserProfileCount);
    }

    public function testUpdateDetailsWithBothNamesBlankShouldNotWork()
    {
        $bob = $this->generateManagerUser();
        $bobId = $bob->id;
        $bobFirstName = $bob->first_name;
        $bobLastName = $bob->last_name;
        unset($bob);
        $repo = new UserRepository();

        $data = array (
            'first_name' => '',
            'last_name' => '',
            'googleplus' => 'mistadobalina',
            'facebook' => 'RobertDobalina',
            'twitter' => 'mistadobalina',
            'about' => 'about',
            'phone' => '',
            'website' => ''
        );

        $result = $repo->updateMyDetails($bobId, $data);
        $this->assertEquals('error', $result);
        $bob = \User::find($bobId);
        $this->assertEquals($bobFirstName, $bob->first_name);
        $this->assertEquals($bobLastName, $bob->last_name);
    }

    public function testUpdateDetailsWithOnlyFirstNameShouldWork()
    {
        $bob = $this->generateManagerUser();
        $bobId = $bob->id;
        $bobProfile = new \UserProfile;
        $bobProfile->save();
        unset($bob);
        $repo = new UserRepository();

        $data = array (
            'first_name' => 'Robert',
            'last_name' => '',
            'googleplus' => 'mistadobalina',
            'facebook' => 'RobertDobalina',
            'twitter' => 'mistadobalina',
            'about' => 'about',
            'phone' => '',
            'website' => ''
        );

        $result = $repo->updateMyDetails($bobId, $data);
        $this->assertEquals('success', $result);
        $bob = \User::find($bobId);
        $this->assertEquals("Robert", $bob->first_name);
        $this->assertEquals("", $bob->last_name);
    }

    public function testUpdateDetailsWithOnlyLastNameShouldWork()
    {
        $bob = $this->generateManagerUser();
        $bobId = $bob->id;
        $bobProfile = new \UserProfile;
        $bobProfile->save();
        unset($bob);

        $repo = new UserRepository();

        $data = array (
            'first_name' => '',
            'last_name' => 'Dobalina',
            'googleplus' => 'mistadobalina',
            'facebook' => 'RobertDobalina',
            'twitter' => 'mistadobalina',
            'about' => 'about',
            'phone' => '',
            'website' => ''
        );

        $result = $repo->updateMyDetails($bobId, $data);
        $this->assertEquals('success', $result);
        $bob = \User::find($bobId);
        $this->assertEquals("", $bob->first_name);
        $this->assertEquals("Dobalina", $bob->last_name);
    }

    private function generateAdminUser()
    {
        // dig out group to assign
        $group = Sentry::findGroupByName('admin');

        // set up sample users
        $aliceCredentials = array(
            'first_name' => 'Alice',
            'last_name' => 'Example',
            'email' => 'alice@example.com',
            'password' => 'bruceschneier',
            'activated' => true,
        );

        $alice = \Sentry::createUser($aliceCredentials);
        $alice->addGroup($group);

        return $alice;
    }

    private function generateManagerUser()
    {
        // dig out group to assign
        $group = Sentry::findGroupByName('manager');

        // set up sample users
        $aliceCredentials = array(
            'first_name' => 'Bob',
            'last_name' => 'Demonstration',
            'email' => 'bob@demonstration.com',
            'password' => 'sharedsecret',
            'activated' => true,
        );

        $alice = \Sentry::createUser($aliceCredentials);
        $alice->addGroup($group);

        return $alice;
    }
}