<?php

class JoinTest extends \TestCase
{
    public function testJoinUsersOnGroups()
    {
        // dig out group to assign
        $group = Sentry::findGroupByName('admin');
        $groupID = $group->getId();

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

        //now try joining alice and bob on admin group
        $result = DB::table('users')
            ->join('users_groups', 'users.id', '=', 'users_groups.user_id')
            ->select('users.id', 'users_groups.group_id')
            ->where('users.id', '=', $alice->id)
            ->orWhere('users.id', '=', $bob->id)
            ->orderBy('users.id')
            ->get();

        //if we've joined correctly, retrieved group ID for both cases should be admin group's ID,
        //since that was only thing retrieved
        $this->assertEquals(2, sizeof($result));
        $this->assertEquals($groupID, $result[0]->group_id);
        $this->assertEquals($groupID, $result[1]->group_id);
    }
}