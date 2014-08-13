<?php
//
// NOTE Migration Created: 2014-07-23 16:13:23
// --------------------------------------------------
class Create92FiveappDatabase {
//
// NOTE - Make changes to the database.
// --------------------------------------------------
public function up()
{

//
// NOTE -- event_user
// --------------------------------------------------
Schema::create('event_user', function($table) {
 $table->increments('id');
 $table->unsignedInteger('events_id')->nullable();
 $table->unsignedInteger('user_id')->nullable();
 $table->unsignedInteger('updated_by')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 });


//
// NOTE -- events
// --------------------------------------------------
Schema::create('events', function($table) {
 $table->increments('id');
 $table->string('title', 200)->nullable();
 $table->string('category', 128)->nullable();
 $table->date('date')->nullable();
 $table->('start_time')->nullable();
 $table->('end_time')->nullable();
 $table->('project')->nullable();
 $table->unsignedInteger('task')->nullable();
 $table->text('notes')->nullable();
 $table->string('folder', 128)->nullable();
 $table->string('location', 256)->nullable();
 $table->unsignedInteger('updated_by')->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->unsignedInteger('deleted_by')->nullable();
 $table->dateTime('deleted_at')->nullable();
 });


//
// NOTE -- file
// --------------------------------------------------
Schema::create('file', function($table) {
 $table->increments('id');
 $table->string('file_name', 45)->nullable();
 $table->string('file_sys_ref', 120)->nullable();
 $table->string('file_md5', 45)->nullable();
 $table->string('key', 45);
 $table->string('size', 128)->nullable();
 $table->unsignedInteger('uploaded_by')->nullable();
 $table->dateTime('uploaded_date')->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('deleted_by')->nullable();
 });


//
// NOTE -- file_ref
// --------------------------------------------------
Schema::create('file_ref', function($table) {
 $table->increments('id');
 $table->unsignedInteger('attachment_id')->nullable();
 $table->unsignedInteger('parent_id')->nullable();
 $table->string('parent_type', 45)->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->dateTime('deleted_by')->nullable();
 });


//
// NOTE -- groups
// --------------------------------------------------
Schema::create('groups', function($table) {
 $table->increments('id')->unsigned();
 $table->string('name', 255)->unique();
 $table->text('permissions')->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- project_user
// --------------------------------------------------
Schema::create('project_user', function($table) {
 $table->increments('id');
 $table->unsignedInteger('project_id')->nullable();
 $table->unsignedInteger('user_id');
 $table->dateTime('updated_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('updated_by');
 });


//
// NOTE -- projects
// --------------------------------------------------
Schema::create('projects', function($table) {
 $table->increments('id');
 $table->string('project_name', 100);
 $table->string('project_client', 100)->nullable();
 $table->text('description')->nullable();
 $table->text('note')->nullable();
 $table->date('start_date')->nullable();
 $table->date('end_date')->nullable();
 $table->string('status', 10);
 $table->string('folder', 20)->nullable();
 $table->unsignedInteger('updated_by')->nullable();
 $table->boolean('deleted')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('deleted_by')->nullable();
 $table->dateTime('completed_on')->nullable();
 $table->unsignedInteger('mark_completed_by')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 });


//
// NOTE -- quicknote
// --------------------------------------------------
Schema::create('quicknote', function($table) {
 $table->increments('id');
 $table->text('text')->nullable();
 $table->unsignedInteger('user_id')->nullable();
 $table->dateTime('updated_at');
 $table->dateTime('created_at');
 });


//
// NOTE -- subtasks
// --------------------------------------------------
Schema::create('subtasks', function($table) {
 $table->increments('id');
 $table->string('text', 256);
 $table->string('status', 45);
 $table->unsignedInteger('task_id');
 $table->dateTime('completed_at')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('updated_by');
 $table->dateTime('updated_at');
 $table->dateTime('created_at');
 });


//
// NOTE -- task_user
// --------------------------------------------------
Schema::create('task_user', function($table) {
 $table->increments('id');
 $table->unsignedInteger('task_id')->nullable();
 $table->unsignedInteger('user_id');
 $table->dateTime('deleted_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->unsignedInteger('updated_by')->nullable();
 });


//
// NOTE -- tasks
// --------------------------------------------------
Schema::create('tasks', function($table) {
 $table->increments('id');
 $table->string('name', 500)->nullable();
 $table->string('status', 45)->nullable();
 $table->string('note', 300)->nullable();
 $table->string('folder', 45)->nullable();
 $table->unsignedInteger('project_id')->nullable();
 $table->dateTime('start_date')->nullable();
 $table->dateTime('end_date')->nullable();
 $table->unsignedInteger('updated_by')->nullable();
 $table->dateTime('completed_on')->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('deleted_by')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 });


//
// NOTE -- throttle
// --------------------------------------------------
Schema::create('throttle', function($table) {
 $table->increments('id')->unsigned();
 $table->unsignedInteger('user_id')->unsigned();
 $table->string('ip_address', 255)->nullable();
 $table->unsignedInteger('attempts');
 $table->boolean('suspended');
 $table->boolean('banned');
 $table->timestamp('last_attempt_at')->nullable();
 $table->timestamp('suspended_at')->nullable();
 $table->timestamp('banned_at')->nullable();
 });


//
// NOTE -- timesheet
// --------------------------------------------------
Schema::create('timesheet', function($table) {
 $table->increments('id');
 $table->string('title', 128)->nullable();
 $table->unsignedInteger('task_id')->nullable();
 $table->date('date')->nullable();
 $table->('total_time_spent')->nullable();
 $table->unsignedInteger('total_hours')->nullable();
 $table->unsignedInteger('total_minutes')->nullable();
 $table->('start_time')->nullable();
 $table->('end_time')->nullable();
 $table->text('details')->nullable();
 $table->text('remarks')->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->unsignedInteger('user_id')->nullable();
 $table->unsignedInteger('updated_by')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('deleted_at')->nullable();
 });


//
// NOTE -- todos
// --------------------------------------------------
Schema::create('todos', function($table) {
 $table->increments('id');
 $table->string('text', 100)->nullable();
 $table->string('status', 50);
 $table->date('due_date')->nullable();
 $table->unsignedInteger('user_id');
 $table->dateTime('deleted_at')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 });


//
// NOTE -- user_profile
// --------------------------------------------------
Schema::create('user_profile', function($table) {
 $table->increments('id');
 $table->string('facebook', 128)->nullable();
 $table->string('twitter', 128)->nullable();
 $table->string('googleplus', 128)->nullable();
 $table->string('linkedin', 128)->nullable();
 $table->dateTime('deleted_at')->nullable();
 $table->unsignedInteger('deleted_by')->nullable();
 $table->unsignedInteger('created_by')->nullable();
 $table->dateTime('created_at')->nullable();
 $table->dateTime('updated_at')->nullable();
 $table->text('about')->nullable();
 $table->string('website', 256)->nullable();
 $table->string('phone', 24)->nullable();
 });


//
// NOTE -- users
// --------------------------------------------------
Schema::create('users', function($table) {
 $table->increments('id');
 $table->string('email', 255)->unique();
 $table->string('password', 255);
 $table->text('permissions')->nullable();
 $table->boolean('activated');
 $table->string('activation_code', 255)->nullable();
 $table->timestamp('activated_at')->nullable();
 $table->timestamp('last_login')->nullable();
 $table->string('persist_code', 255)->nullable();
 $table->string('reset_password_code', 255)->nullable();
 $table->string('first_name', 255)->nullable();
 $table->string('last_name', 255)->nullable();
 $table->timestamp('created_at')->default("0000-00-00 00:00:00");
 $table->timestamp('updated_at')->default("0000-00-00 00:00:00");
 });


//
// NOTE -- users_groups
// --------------------------------------------------
Schema::create('users_groups', function($table) {
 $table->increments('user_id')->unsigned();
 $table->increments('group_id')->unsigned();
 });


//
// NOTE -- event_user_foreign
// --------------------------------------------------
Schema::table('event_user', function($table) {
 $table->foreign('events_id')->references('id')->on('events');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- file_ref_foreign
// --------------------------------------------------
Schema::table('file_ref', function($table) {
 $table->foreign('attachment_id')->references('id')->on('file');
 });


//
// NOTE -- project_user_foreign
// --------------------------------------------------
Schema::table('project_user', function($table) {
 $table->foreign('project_id')->references('id')->on('projects');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- subtasks_foreign
// --------------------------------------------------
Schema::table('subtasks', function($table) {
 $table->foreign('task_id')->references('id')->on('tasks');
 });


//
// NOTE -- task_user_foreign
// --------------------------------------------------
Schema::table('task_user', function($table) {
 $table->foreign('task_id')->references('id')->on('tasks');
 $table->foreign('user_id')->references('id')->on('users');
 });


//
// NOTE -- tasks_foreign
// --------------------------------------------------
Schema::table('tasks', function($table) {
 $table->foreign('project_id')->references('id')->on('projects');
 });


//
// NOTE -- timesheet_foreign
// --------------------------------------------------
Schema::table('timesheet', function($table) {
 $table->foreign('user_id')->references('id')->on('users');
 $table->foreign('task_id')->references('id')->on('tasks');
 });


//
// NOTE -- user_profile_foreign
// --------------------------------------------------
Schema::table('user_profile', function($table) {
 $table->foreign('id')->references('id')->on('users');
 });



}
//
// NOTE - Revert the changes to the database.
// --------------------------------------------------
public function down()
{

Schema::drop('event_user');
Schema::drop('events');
Schema::drop('file');
Schema::drop('file_ref');
Schema::drop('groups');
Schema::drop('project_user');
Schema::drop('projects');
Schema::drop('quicknote');
Schema::drop('subtasks');
Schema::drop('task_user');
Schema::drop('tasks');
Schema::drop('throttle');
Schema::drop('timesheet');
Schema::drop('todos');
Schema::drop('user_profile');
Schema::drop('users');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');
Schema::drop('users_groups');

}
}