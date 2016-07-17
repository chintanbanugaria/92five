<?php

class GroupsTableSeeder extends Seeder {

    public function run()
    {
        DB::table('groups')->delete();

        $groups = array(
            array(
                'name' => 'admin',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'permissions' => '{"project.create":1,"project.update":1,"project.view":1,"project.delete":1,"task.create":1,"task.update":1,"task.view":1,"task.delete":1,"milestone.create":1,"milestone.update":1,"milestone.view":1,"milestone.delete":1,"user.create":1,"user.update":1,"user.view":1,"user.delete":1,"role.create":1,"role.update":1,"role.view":1,"role.delete":1,"reports.create":1,"reports.update":1,"reports.view":1,"reports.delete":1,"groups.create":1,"groups.update":1,"groups.view":1,"groups.delete":1}'
            ),
            array(
                'name' => 'manager',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'permissions' => '{"project.create":1,"project.update":1,"project.view":1,"project.delete":1,"task.create":1,"task.update":1,"task.view":1,"task.delete":1,"milestone.create":1,"milestone.update":1,"milestone.view":1,"milestone.delete":1,"user.view":1,"role.view":1,"reports.create":1,"reports.update":1,"reports.view":1,"reports.delete":1,"groups.view":1}'
            ),
            array(
                'name' => 'leader',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'permissions' => '{"project.update":1,"project.view":1,"task.create":1,"task.update":1,"task.view":1,"task.delete":1,"milestone.create":1,"milestone.update":1,"milestone.view":1,"milestone.delete":1,"user.view":1,"role.view":1,"reports.create":1,"reports.update":1,"reports.view":1}'
            ),
            array(
                'name' => 'user',
                'created_at' => new DateTime,
                'updated_at' => new DateTime,
                'permissions' => '{"project.view":1,"task.create":1,"task.update":1,"task.view":1,"task.delete":1,"milestone.update":1,"milestone.view":1,"milestone.delete":1,"user.view":1,"reports.view":1}'
            )
        );

        DB::table('groups')->insert($groups);
    }

}