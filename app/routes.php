<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::get('/', function()
{
	
	if(!Sentry::check())
	{
		return View::make('login.index');
	}
	else
	{
		return Redirect::to('dashboard');
	}	
});

Route::get('/forgotpassword', function()
{
	return View::make('login.forgotpassword');
});
Route::get('/login', function()
{
	if(!Sentry::check())
	{
		return View::make('login.index');
	}
	else
	{
		return Redirect::to('dashboard');
	}
});
Route::get('/logout', function(){

	Sentry::logout();
	return Redirect::to('/login');
});
Route::group(array('prefix'=>'install','before'=>'install'),function() 
{
    Route::get('/','InstallController@getIndex');
    Route::get('/database','InstallController@getDatabase');
    Route::post('/database','InstallController@postDatabase');
    Route::post('/timezone','InstallController@postTimeZone');
    Route::post('/adminaccount','InstallController@postAdminAccount');
});
Route::post('/auth/login', 'AuthController@authLogin');
Route::post('/auth/forgotpassword', 'AuthController@authForgotPassword');
Route::get('/auth/recoverpassword', 'AuthController@authRecoverPassword');
Route::post('/auth/updatepassword', 'AuthController@authUpdatePassword');
Route::get('/auth/activateuser', 'AuthController@authActivateUser');
Route::post('/auth/createuser', 'AuthController@authCreateUser');
Route::get('/auth/verifyemail','AuthController@authVerifyEmail');
Route::group(array('prefix'=>'dashboard','before'=>'auth'),function() 
{

				 Route::get('/', 'Controllers\Domain\Dashboard\DashboardController@getIndex');
				 if(Request::ajax())
				 {
				 	Route::get('/todos','Controllers\Domain\Dashboard\DashboardController@getToDos');
				 	Route::put('/todos/{id?}', 'Controllers\Domain\Dashboard\DashboardController@putToDos');
				 	Route::get('/quicknote','Controllers\Domain\Dashboard\DashboardController@getQuickNote');
				 	Route::put('/quicknote','Controllers\Domain\Dashboard\DashboardController@putQuickNote');
				 	Route::get('/users','Controllers\Domain\Dashboard\DashboardController@getUsersList');
				 	Route::get('/projects/edit/deletefile/{id}','Controllers\Domain\Dashboard\DashboardController@getDeleteFile');
				 	Route::put('/task/update/{id?}', 'Controllers\Domain\Dashboard\TaskController@updateStatus');
				 	Route::get('/users/project/{id?}','Controllers\Domain\Dashboard\DashboardController@getProjectUsersList');
				 	Route::post('/tasks/add', 'Controllers\Domain\Dashboard\TaskController@postAddTask');
				 	Route::post('/tasks/subtask', 'Controllers\Domain\Dashboard\TaskController@postAddSubTask');
				 	Route::delete('/tasks/subtask/{id?}', 'Controllers\Domain\Dashboard\TaskController@deleteSubTask');
				 	Route::post('/tasks/edit/subtask', 'Controllers\Domain\Dashboard\TaskController@postAddSubTask');
				 	Route::delete('/tasks/edit/subtask/{id?}', 'Controllers\Domain\Dashboard\TaskController@deleteSubTask');
				 	Route::post('/tasks/edit/update', 'Controllers\Domain\Dashboard\TaskController@postEditTask');
				 	Route::get('/tasks/edit/add/files/deletefile/{id}','Controllers\Domain\Dashboard\DashboardController@getDeleteFile');
				 	Route::get('/calendar/events/{id?}','Controllers\Domain\Dashboard\CalendarController@getEvents');
				 	/***TimeSheet***/
				 	Route::get('timesheet/entry/{day?}', 'Controllers\Domain\Dashboard\TimesheetController@getEntries');
				 	Route::get('todo','Controllers\Domain\Dashboard\TodoController@getTodos');
				 	Route::put('/todo/{id?}', 'Controllers\Domain\Dashboard\TodoController@putTodos');
				 	Route::post('todo','Controllers\Domain\Dashboard\TodoController@postTodos');
				 	Route::delete('todo/{id?}','Controllers\Domain\Dashboard\TodoController@deleteTodos');

				}
				Route::get('roles',function(){
					return View::make('dashboard.roles');
				});
				Route::get('projects','Controllers\Domain\Dashboard\ProjectController@getIndex');
				Route::get('Projects','Controllers\Domain\Dashboard\ProjectController@getIndex');
				Route::get('projects/{id}','Controllers\Domain\Dashboard\ProjectController@getViewProject')->where('id', '[0-9]+');
				Route::get('/download/{md5}','Controllers\Domain\Dashboard\DashboardController@getDownloadFile');
				Route::post('projects/delete','Controllers\Domain\Dashboard\ProjectController@deleteProject');
				
				Route::get('projects/edit/{id}','Controllers\Domain\Dashboard\ProjectController@getEditProject')->where('id', '[0-9]+');
				Route::post('projects/edit/{id}','Controllers\Domain\Dashboard\ProjectController@postEditProject');
				Route::post('projects/edit/add/files','Controllers\Domain\Dashboard\ProjectController@postAddFiles');
				Route::get('projects/add','Controllers\Domain\Dashboard\ProjectController@getAddProject');
				Route::post('projects/add','Controllers\Domain\Dashboard\ProjectController@postCreateProject');
				Route::post('projects/add/files','Controllers\Domain\Dashboard\ProjectController@postAddFiles');
				Route::get('projects/add/done',function(){
					return Redirect::to('dashboard/projects')->with('status','success')->with('message','Project Added');
				});
				Route::get('projects/edit/done/{id?}',function($id){
					return Redirect::to('dashboard/projects/'.$id)->with('status','success')->with('message','Project Updated');
				});
				/************** Tasks **************/
				Route::get('tasks','Controllers\Domain\Dashboard\TaskController@getIndex');
				Route::get('Tasks','Controllers\Domain\Dashboard\TaskController@getIndex');
				Route::get('/tasks/project/{id?}', 'Controllers\Domain\Dashboard\TaskController@getProjectsTasks');
				Route::get('/tasks/add','Controllers\Domain\Dashboard\TaskController@getAddTasks');
				Route::get('/tasks/add/files/{id?}','Controllers\Domain\Dashboard\TaskController@getAddFiles');
				Route::post('/tasks/add/files/{id?}','Controllers\Domain\Dashboard\TaskController@postAddFiles');
				Route::get('/tasks/{id?}','Controllers\Domain\Dashboard\TaskController@getViewTask');
				Route::get('/tasks/edit/{id?}','Controllers\Domain\Dashboard\TaskController@getEditTask');
				Route::get('/tasks/edit/add/files/{id?}','Controllers\Domain\Dashboard\TaskController@getEditFiles');
				Route::post('/tasks/edit/add/files/{id?}','Controllers\Domain\Dashboard\TaskController@postAddFiles');
				Route::post('/tasks/delete','Controllers\Domain\Dashboard\TaskController@getDeleteIt');
				Route::get('/task/added',function(){
						return Redirect::to('dashboard/tasks')->with('status','success')->with('message','Task Added');
				});
				Route::get('/task/edited/{id?}',function($id){
						return Redirect::to('dashboard/tasks/'.$id)->with('status','success')->with('message','Task Updated');
				});
				Route::put('task/subtasks/{id?}','Controllers\Domain\Dashboard\TaskController@updateSubTask');
				/************* Routes for Calendar **************/
				Route::get('calendar','Controllers\Domain\Dashboard\CalendarController@getIndex');
				Route::post('calendar/add','Controllers\Domain\Dashboard\CalendarController@addEvent');
				Route::post('calendar/event/delete','Controllers\Domain\Dashboard\CalendarController@deleteEvent');
				Route::get('calendar/event/edit/{id?}','Controllers\Domain\Dashboard\CalendarController@getEditEvent');
				Route::post('calendar/event/edit/{id?}','Controllers\Domain\Dashboard\CalendarController@postEditEvent');
				Route::get('calendar/event/createdbyme','Controllers\Domain\Dashboard\CalendarController@getEventsCreatedByMe');

				/************* Routes for Timesheet **************/
				Route::get('timesheet','Controllers\Domain\Dashboard\TimesheetController@getIndex');
				Route::post('timesheet/entry/add','Controllers\Domain\Dashboard\TimesheetController@addEntry');
				Route::post('timesheet/entry/delete','Controllers\Domain\Dashboard\TimesheetController@deleteEntry');
				Route::post('timesheet/entry','Controllers\Domain\Dashboard\TimesheetController@getDateEntries');
				Route::get('timesheet/entry/edit/{id?}','Controllers\Domain\Dashboard\TimesheetController@getEditEntries');
				Route::post('timesheet/entry/edit/{id?}','Controllers\Domain\Dashboard\TimesheetController@postEditEntry');
				/**************** Routes for Todos *********************/
				Route::get('mytodos','Controllers\Domain\Dashboard\TodoController@getIndex');
				Route::get('mytodos/markallcompleted','Controllers\Domain\Dashboard\TodoController@markAllCompleted');
				Route::get('mytodos/deletecompleted','Controllers\Domain\Dashboard\TodoController@deleteCompleted');
				Route::get('mytodos/deleteall','Controllers\Domain\Dashboard\TodoController@deleteAll');
				/**************** Reports *******************/
				Route::get('reports','Controllers\Domain\Dashboard\ReportController@getIndex');
				Route::post('reports/weekly','Controllers\Domain\Dashboard\ReportController@postWeekly');
				Route::post('reports/weeklytask','Controllers\Domain\Dashboard\ReportController@postWeeklyTask');
				Route::post('reports/weeklyproject','Controllers\Domain\Dashboard\ReportController@postWeeklyProject');
				Route::post('reports/monthly','Controllers\Domain\Dashboard\ReportController@postMonthly');
				Route::post('reports/monthlytask','Controllers\Domain\Dashboard\ReportController@postMonthlyTask');
				Route::post('reports/monthlyproject','Controllers\Domain\Dashboard\ReportController@postMonthlyProject');
				Route::post('reports/projectreport','Controllers\Domain\Dashboard\ReportController@postProjectReport');
				Route::post('reports/usermonthlyproject','Controllers\Domain\Dashboard\ReportController@postUserProjectReport');
				/**************** Users *********************/
				Route::get('me','Controllers\Domain\Dashboard\UserController@myProfile');
				Route::get('user/{id?}','Controllers\Domain\Dashboard\UserController@getUser');
				Route::get('me/editmydetails','Controllers\Domain\Dashboard\UserController@editMyDetails');
                Route::post('me/editmydetails','Controllers\Domain\Dashboard\UserController@postEditMyDetails');
				Route::get('me/changemyemail','Controllers\Domain\Dashboard\UserController@changeEmail');
				Route::post('me/changemyemail','Controllers\Domain\Dashboard\UserController@postChangeEmail');
				Route::get('me/changemypassword','Controllers\Domain\Dashboard\UserController@changePassword');
				Route::post('me/changemypassword','Controllers\Domain\Dashboard\UserController@postChangePassword');

				/************** admin routes ************/
				Route::group(array('prefix'=>'admin','before'=>'admin'),function() 
				{
					Route::get('/', 'Controllers\Domain\Admin\AdminController@getIndex');
					Route::get('users', 'Controllers\Domain\Admin\UserController@getAllUsers');
					Route::get('users/add', 'Controllers\Domain\Admin\UserController@getAddUser');
					Route::post('users/add', 'Controllers\Domain\Admin\UserController@postAddUser');
 					if(Request::ajax())
				 	{
				 		Route::put('/users/manage/{id?}','Controllers\Domain\Admin\UserController@manageUsers');
				 	}
				 	Route::get('/users/roles/{id?}','Controllers\Domain\Admin\UserController@getChangeRole');
				 	Route::post('/users/roles','Controllers\Domain\Admin\UserController@postChangeRole');
				 	Route::post('/users/delete','Controllers\Domain\Admin\UserController@deleteUser');
				 	Route::get('/settings','Controllers\Domain\Admin\AdminController@getEmailSettings');
				 	Route::post('/settings','Controllers\Domain\Admin\AdminController@postEmailSettings');
				 	Route::get('/users/add/withdetails','Controllers\Domain\Admin\UserController@getAddUserWithDetails');
				 	Route::post('/users/add/withdetails','Controllers\Domain\Admin\UserController@postAddUserWithDetails');
				 	Route::get('/users/changeemail/{id?}','Controllers\Domain\Admin\UserController@getChangeEmail');
				 	Route::post('/users/changeemail/{id?}','Controllers\Domain\Admin\UserController@postChangeEmail');
				 	Route::get('/users/changepassword/{id?}','Controllers\Domain\Admin\UserController@getChangePassword');
				 	Route::post('/users/changepassword/{id?}','Controllers\Domain\Admin\UserController@postChangePassword');
				 	Route::post('/deleterestore','Controllers\Domain\Admin\DataController@getIndex');
				 	Route::post('/data/deleteall/{type?}','Controllers\Domain\Admin\DataController@deleteAll');
				 	Route::post('/data/delete','Controllers\Domain\Admin\DataController@deleteSingleEntity');
				 	Route::post('/data/restoreall/{type?}','Controllers\Domain\Admin\DataController@restoreAll');
				 	Route::post('/data/restore','Controllers\Domain\Admin\DataController@restoreSingleEntity');

				});
                Route::get('credits',function(){
                    return View::make('dashboard.credits');
                });

 });








