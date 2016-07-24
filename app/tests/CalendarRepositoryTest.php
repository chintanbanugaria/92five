<?php

class CalendarRepositoryTest extends \TestCase
{
    public function testAddEventNoData()
    {
        $alice = $this->generateAdminUser();
        $repo = new CalendarRepository();
        $correctException = false;

        try {
            $repo->addEvent(array(), $alice->id);
        } catch (SomeThingWentWrongException $e) {
            $correctException = true;
        }
        $this->assertTrue($correctException);
    }

    public function testAddEventGoodData()
    {
        $alice = $this->generateAdminUser();
        $repo = new CalendarRepository();

        $data = array (
            'title' => 'Das Testevent',
            'category' => 'Test',
            'location' => '',
            'note' => '',
            "starttime_submit" => "16:15",
            "endtime_submit" => "18:00",
            'date_submit' => "20 July, 2018",
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active',
        );

        $result = $repo->addEvent($data, $alice->id);
        $this->assertEquals('success', $result);
        $event = \Events::where('title','=',$data['title'])->first();
        $this->assertTrue($event instanceof \Events, get_class($event));
        $this->assertEquals($data['category'], $event->category);
        $this->assertEquals($data['starttime_submit'], $event->start_time);
        $this->assertEquals($data['endtime_submit'], $event->end_time);
        $this->assertEquals($data['date_submit'], $event->date);
        $this->assertEquals($data['note'], $event->notes);
        $this->assertEquals($data['location'], $event->location);
        $this->assertEquals($alice->id, $event->updated_by);
    }

    public function testEditEventGoodData()
    {
        $alice = $this->generateAdminUser();
        $bob = $this->generateManagerUser();
        $repo = new CalendarRepository();

        $data = array (
            'title' => 'Das Testevent',
            'category' => 'Test',
            'location' => '',
            'note' => '',
            "starttime_submit" => "16:15",
            "endtime_submit" => "18:00",
            'date_submit' => "20 July, 2018",
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active',
        );

        $result = $repo->addEvent($data, $alice->id);
        $this->assertEquals('success', $result);
        $event = \Events::where('title','=',$data['title'])->first();
        $this->assertEquals($data['category'], $event->category);
        $this->assertEquals($data['starttime_submit'], $event->start_time);
        $this->assertEquals($data['endtime_submit'], $event->end_time);
        $this->assertEquals($data['date_submit'], $event->date);
        $this->assertEquals($data['note'], $event->notes);
        $this->assertEquals($data['location'], $event->location);
        $this->assertEquals($alice->id, $event->updated_by);
        $eventId = $event->id;
        unset($event);

        $data = array (
            'eventid' => $eventId,
            'title' => 'Das Testevent',
            'category' => 'Test',
            'location' => '',
            'note' => '',
            "starttime_submit" => "17:15",
            "endtime_submit" => "19:00",
            'date' => "20 July, 2018",
            'date_expected' => '2018-07-20',
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active',
        );

        $result = $repo->editEvent($data, $bob->id);
        $this->assertEquals('success', $result);
        $event = \Events::find($eventId);
        $this->assertEquals($data['category'], $event->category);
        $this->assertEquals($data['starttime_submit'], $event->start_time);
        $this->assertEquals($data['endtime_submit'], $event->end_time);
        $this->assertEquals($data['date_expected'], $event->date);
        $this->assertEquals($data['note'], $event->notes);
        $this->assertEquals($data['location'], $event->location);
        $this->assertEquals($bob->id, $event->updated_by);
    }

    public function testEditEventGoodDataShouldUpdate()
    {
        $alice = $this->generateAdminUser();
        $bob = $this->generateManagerUser();
        $repo = new CalendarRepository();

        $data = array (
            'title' => 'Das Testevent',
            'category' => 'Test',
            'location' => '',
            'note' => '',
            "starttime_submit" => "16:15",
            "endtime_submit" => "18:00",
            'date_submit' => "20 July, 2018",
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active',
        );

        $result = $repo->addEvent($data, $alice->id);
        $this->assertEquals('success', $result);
        $event = \Events::where('title','=',$data['title'])->first();
        $this->assertEquals($data['category'], $event->category);
        $this->assertEquals($data['starttime_submit'], $event->start_time);
        $this->assertEquals($data['endtime_submit'], $event->end_time);
        $this->assertEquals($data['date_submit'], $event->date);
        $this->assertEquals($data['note'], $event->notes);
        $this->assertEquals($data['location'], $event->location);
        $this->assertEquals($alice->id, $event->updated_by);
        $eventId = $event->id;
        unset($event);

        $data = array (
            'eventid' => $eventId,
            'title' => 'Das Testevent',
            'category' => 'Test',
            'location' => '',
            'note' => '',
            "starttime_submit" => "17:15",
            "endtime_submit" => "19:00",
            'date' => "20 July, 2018 at 12:00 am",
            'date_expected' => '2018-07-20',
            'tagsinput' => 'alice@example.com,bob@demonstration.net',
            'status' => 'active',
        );

        $result = $repo->editEvent($data, $bob->id);
        $this->assertEquals('success', $result);
        $event = \Events::find($eventId);
        $this->assertEquals($data['category'], $event->category);
        $this->assertEquals($data['starttime_submit'], $event->start_time);
        $this->assertEquals($data['endtime_submit'], $event->end_time);
        $this->assertEquals($data['date_expected'], $event->date);
        $this->assertEquals($data['note'], $event->notes);
        $this->assertEquals($data['location'], $event->location);
        $this->assertEquals($bob->id, $event->updated_by);
    }

    public function testEditEventMissingData()
    {
        $alice = $this->generateAdminUser();
        $bob = $this->generateManagerUser();
        $repo = new CalendarRepository();

        $data = array ();

        $result = $repo->editEvent($data, $alice->id);
        $this->assertEquals('error', $result);
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
        $bobCredentials = array(
            'first_name' => 'Bob',
            'last_name' => 'Demonstration',
            'email' => 'bob@demonstration.com',
            'password' => 'sharedsecret',
            'activated' => true,
        );

        $bob = \Sentry::createUser($bobCredentials);
        $bob->addGroup($group);

        return $bob;
    }

}