<?php

class ProjectRepositoryTest extends \TestCase
{
    public function testAddProjectGoodDates()
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
        $bobCredentials = array(
            'first_name' => 'Bob',
            'last_name' => 'Demonstration',
            'email' => 'bob@demonstration.net',
            'password' => 'oursharedsecret',
            'activated' => true,
        );

        $alice = Sentry::createUser($aliceCredentials);
        $bob = Sentry::createUser($bobCredentials);

        $alice->addGroup($group);
        $bob->addGroup($group);

        $data = array (
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "20 July, 2016",
            'enddate' => "20 July, 2017",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com,bob@demonstration.net'
        );

        $repo = new ProjectRepository();

        $result = $repo->addProject($data, $bob->id);
        $project = \Project::where('project_name',$data['project_name'])->first();
        // start checking what came out
        $this->assertEquals($data['project_name'], $project->project_name);
        $this->assertEquals($data['project_client'], $project->project_client);
        $this->assertEquals("2016-07-20", $project->start_date);
        $this->assertEquals("2017-07-20", $project->end_date);

        $this->assertEquals($project->id, $result['projectId']);
        $this->assertEquals($data['project_name'], $result['project_name']);
    }

    public function testAddProjectBadDates()
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
        $bobCredentials = array(
            'first_name' => 'Bob',
            'last_name' => 'Demonstration',
            'email' => 'bob@demonstration.net',
            'password' => 'oursharedsecret',
            'activated' => true,
        );

        $alice = Sentry::createUser($aliceCredentials);
        $bob = Sentry::createUser($bobCredentials);

        $alice->addGroup($group);
        $bob->addGroup($group);

        $data = array (
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "2016-07-20",
            'enddate' => "2017-07-20",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com,bob@demonstration.net'
        );

        $repo = new ProjectRepository();

        $result = $repo->addProject($data, $bob->id);
        $project = \Project::where('project_name',$data['project_name'])->first();
        $collabs = $project->projectcollabs()->get();
        // start checking what came out
        $this->assertEquals($data['project_name'], $project->project_name);
        $this->assertEquals($data['project_client'], $project->project_client);
        $this->assertEquals(null, $project->start_date);
        $this->assertEquals(null, $project->end_date);

        $this->assertEquals($project->id, $result['projectId']);
        $this->assertEquals($data['project_name'], $result['project_name']);
        $this->assertEquals(2, $collabs->count());
        $this->assertEquals($alice->id, $collabs[0]->id);
        $this->assertEquals($bob->id, $collabs[1]->id);
    }

    public function testUpdateProjectWithAsSuppliedDatesAndTimes()
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
        $bobCredentials = array(
            'first_name' => 'Bob',
            'last_name' => 'Demonstration',
            'email' => 'bob@demonstration.net',
            'password' => 'oursharedsecret',
            'activated' => true,
        );

        $alice = Sentry::createUser($aliceCredentials);
        $bob = Sentry::createUser($bobCredentials);

        $alice->addGroup($group);
        $bob->addGroup($group);

        $data = array (
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "2016-07-20",
            'enddate' => "2017-07-20",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com,bob@demonstration.net'
        );

        $repo = new ProjectRepository();

        $result = $repo->addProject($data, $bob->id);
        $project = \Project::where('project_name',$data['project_name'])->first();
        $this->assertEquals(null, $project->start_date);
        $this->assertEquals(null, $project->end_date);

        $data = array (
            'projectid' => $project->id,
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "20th July, 2016 at 12:00am",
            'enddate' => "20th July, 2017 at 12:00am",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active'
        );

        $result = $repo->updateProject($data, $alice->id);
    }

    public function testUpdateProjectWithKnownGoodDatesAndTimes()
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
        $bobCredentials = array(
            'first_name' => 'Bob',
            'last_name' => 'Demonstration',
            'email' => 'bob@demonstration.net',
            'password' => 'oursharedsecret',
            'activated' => true,
        );

        $alice = Sentry::createUser($aliceCredentials);
        $bob = Sentry::createUser($bobCredentials);

        $alice->addGroup($group);
        $bob->addGroup($group);

        $data = array (
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "2016-07-20",
            'enddate' => "2017-07-20",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com,bob@demonstration.net'
        );

        $repo = new ProjectRepository();

        $result = $repo->addProject($data, $bob->id);
        $project = \Project::where('project_name',$data['project_name'])->first();

        $data = array (
            'projectid' => $project->id,
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "20 July, 2016",
            'enddate' => "20 July, 2017",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active',
        );

        $result = $repo->updateProject($data, $alice->id);
    }

    public function testProcessDateStringKnownGoodData()
    {
        $repo = new ProjectRepository();
        $result = $repo->processDateString('20 July, 2016');
        $this->assertEquals('2016-07-20', $result);
    }

    public function testProcessDateStringShouldBeGoodData()
    {
        $repo = new ProjectRepository();
        $result = $repo->processDateString('20 July, 2016 at 12:00 am');
        $this->assertEquals('2016-07-20', $result);
        $result = $repo->processDateString('20 July, 2018 at 12:00 am');
        $this->assertEquals('2018-07-20', $result);
        $result = $repo->processDateString("20 July, 2018 at 12:00 am");
        $this->assertEquals('2018-07-20', $result);
    }

    public function testProcessDateStringKnownBadData()
    {
        $repo = new ProjectRepository();
        $result = $repo->processDateString('2016-07-20');
        $this->assertEquals(null, $result);
    }

    public function testProcessDateStringNullData()
    {
        $repo = new ProjectRepository();
        $result = $repo->processDateString(null);
        $this->assertEquals(null, $result);
    }
    
    public function testDeleteNullProject()
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

        $alice = Sentry::createUser($aliceCredentials);
        $alice->addGroup($group);

        $repo = new ProjectRepository();
        
        $result = $repo->deleteProject(-1, $alice->id);
        $this->assertFalse($result);
    }

    public function testDeleteProjectNoTasks()
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

        $alice = Sentry::createUser($aliceCredentials);
        $alice->addGroup($group);

        $data = array (
            'project_name' => 'Das Testprojekt',
            'description' => '',
            'note' => '',
            'startdate' => "20 July, 2016",
            'enddate' => "20 July, 2017",
            'project_client' => 'Test',
            'tagsinput' => 'alice@example.com'
        );

        $repo = new ProjectRepository();
        $result = $repo->addProject($data, $alice->id);

        $project = \Project::where('project_name',$data['project_name'])->first();
        $projectId = $project->id;

        $result = $repo->deleteProject($projectId, $alice->id);

        $nuProject = \Project::find($projectId);
        $this->assertNull($nuProject);
        unset($nuProject);
        // now dig up withTrashed and verify deleted_by is correct
        $nuProject = \Project::withTrashed()->find($projectId);
        $this->assertEquals($alice->id, $nuProject->deleted_by);
    }
}