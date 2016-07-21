<?php

class InstallControllerTest extends \TestCase
{
    public function testGetIndexAlreadyInstalled()
    {
        $correctException = false;
        Config::shouldReceive('get')->with('92five.install')->andReturn(true);
        $foo = new InstallController();
        try {
            $foo->getIndex();
        } catch (Exception $e) {
            $correctException = ("Application Already Installed." == $e->getMessage());
        }
        $this->assertEquals(true, $correctException);

    }

    public function testGetIndexNotYetInstalled()
    {
        Config::shouldReceive('get')->with('92five.install')->andReturn(false);
        $foo = new InstallController();
        $result = $foo->getIndex();
        $this->assertTrue($result instanceof \Illuminate\View\View, get_class($result));
        $this->assertEquals('install.syscheck', $result->getName());
    }

    public function testGetDatabase()
    {
        $foo = new InstallController();
        $result = $foo->getDatabase();
        $this->assertTrue($result instanceof \Illuminate\View\View, get_class($result));
        $this->assertEquals('install.database', $result->getName());
    }

    public function testPostDatabaseSuperGut()
    {
        $credentials = array(
            'host'=>'345.345.345.345',
            'database' => 'jutlandParade',
            'username'=>'Bondy',
            'password' => 'Bon Jovi',
            'csrf_token' => Session::getToken()
        );
        Input::replace($credentials);

        $expectedPath = app_path().'/config/database.php';
        $expectedFeed = [
            'connections.mysql.host' => $credentials['host'],
            'connections.mysql.database' => $credentials['database'],
            'connections.mysql.username' => $credentials['username'],
            'connections.mysql.password' => $credentials['password']
        ];

        //Mock it... yeah, mock it..
        Artisan::shouldReceive('call')->withArgs(['migrate'])->andReturnNull()->once();
        Artisan::shouldReceive('call')->withArgs(['db:seed'])->andReturnNull()->once();

        $externalMock = \Mockery::mock('overload:October\Rain\Config\Rewrite');
        $externalMock->shouldReceive('toFile')->withArgs([$expectedPath, $expectedFeed])->andReturnNull()->once();
        $externalMock->shouldReceive('toFile')->withAnyArgs()->never();

        $foo = new InstallController();
        $result = $foo->postDatabase();
        $this->assertTrue($result instanceof \Illuminate\View\View, get_class($result));
        $this->assertEquals('install.timezone', $result->getName());
    }

    public function testPostTimezone()
    {
        $credentials = array(
            'timezone'=>'UTC',
            'csrf_token' => Session::getToken()
        );
        Input::replace($credentials);

        $expectedPath = app_path().'/config/app.php';
        $expectedFeed = [
            'timezone'=> 'UTC'
        ];

        $externalMock = \Mockery::mock('overload:October\Rain\Config\Rewrite');
        $externalMock->shouldReceive('toFile')->withArgs([$expectedPath, $expectedFeed])->andReturnNull()->once();
        $externalMock->shouldReceive('toFile')->withAnyArgs()->never();

        $foo = new InstallController();
        $result = $foo->postTimeZone();
        $this->assertTrue($result instanceof \Illuminate\View\View, get_class($result));
        $this->assertEquals('install.adminaccount', $result->getName());
    }
    
    public function testPostAdminAccountExceptionThrown()
    {
        //Sentry::shouldReceive('createUser')->withAnyArgs()->andThrow(new Exception());
        $foo = new InstallController();
        $correctException = false;
        try {
            $foo->postAdminAccount();
        } catch (Exception $e) {
            $correctException = 'Something Went Wrong in Install Controller Repository - addUserWithDetails()' == $e->getMessage();
        }
        $this->assertTrue($correctException);
    }
    
    public function testPostAdminAccountCreation()
    {
        $credentials = array(
            'email'=>'345.345.345.345',
            'first_name' => 'Alan',
            'last_name'=>'Bond',
            'password' => 'Bon Jovi',
            'csrf_token' => Session::getToken()
        );
        Input::replace($credentials);
        //Input::shouldReceive('all')->withNoArgs()->andReturn($credentials);

        $user = \Mockery::mock('User')->makePartial();
        $user->shouldReceive('addGroup')->withAnyArgs()->andReturnNull()->once();
        $user->shouldReceive('id')->andReturn(42);

        $group = \Mockery::mock('Cartalyst\Sentry\Groups\Eloquent\Group');

        Sentry::shouldReceive('createUser')->withAnyArgs()->andReturn($user)->once();
        Sentry::shouldReceive('findGroupByName')->withAnyArgs()->andReturn($group)->once();

        $quicknoteMock = \Mockery::mock('overload:\Quicknote');
        $quicknoteMock->shouldReceive('save')->withNoArgs()->andReturnNull()->once();
        $userprofileMock = \Mockery::mock('overload:\UserProfile');
        $userprofileMock->shouldReceive('save')->withNoArgs()->andReturnNull()->once();
        $externalMock = \Mockery::mock('overload:October\Rain\Config\Rewrite');
        $externalMock->shouldReceive('toFile')->withAnyArgs()->andReturnNull()->once();
        //Request::shouldReceive('server')->with(['PATH_INFO'])->andReturnNull()->once();

        $foo = new InstallController();
        $result = $foo->postAdminAccount();
        $this->assertTrue($result instanceof \Illuminate\View\View, get_class($result));
        $this->assertEquals('install.done', $result->getName());
    }

}