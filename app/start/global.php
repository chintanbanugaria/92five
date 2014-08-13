<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

	app_path().'/commands',
	app_path().'/controllers',
	app_path().'/models',
	app_path().'/database/seeds',


));
ClassLoader::load(app_path().'/models/Subtask.php');

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a rotating log file setup which creates a new file each day.
|
*/

$logFile = 'log-'.php_sapi_name().'.txt';

Log::useDailyFiles(storage_path().'/logs/'.$logFile);

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function(Exception $exception, $code)
{
	switch ($code)
    {
        case 503:
            return Response::view('errors.503', array(), 503);

       case 404:
            return Response::view('errors.404', array(), 404);

        case 401:
            return Response::view('errors.401', array(), 401);

       // default:
         //   return Response::view('errors.default', array(), $code);
    }
});
App::error(function(TaskNotFoundException $exception, $code)
{	
            return Response::view('errors.notfound', array('subject'=>'Task'), 404);   
});
App::error(function(ProjectNotFoundException $exception, $code)
{  
            return Response::view('errors.notfound', array('subject'=>'Project'), 404);   
});
App::error(function(FileNotFoundException $exception, $code)
{  
            return Response::view('errors.notfound', array('subject'=>'File'), 404);   
});
App::error(function(EventNotFoundException $exception, $code)
{
              return Response::view('errors.notfound', array('subject'=>'Event'), 404);   
});
App::error(function(TimesheetEntryNotFoundException $exception, $code)
{
              return Response::view('errors.notfound', array('subject'=>'Timesheet Entry'), 404);   
});
App::error(function(UserNotFoundException $exception, $code)
{
              return Response::view('errors.notfound', array('subject'=>'User'), 404);   
});
App::error(function(NotAuthorizedForProject $exception, $code)
{
              return Response::view('errors.notauthorized', array('subject'=>'Project'), 401);   
});
App::error(function(NotAuthorizedForTaskException $exception, $code)
{
              return Response::view('errors.notauthorized', array('subject'=>'Task'), 401);   
});
App::error(function(NotAuthorizedForEventException $exception, $code)
{
              return Response::view('errors.notauthorized', array('subject'=>'Event'), 401);   
});
App::error(function(NotAuthorizedForTimesheetEntryException $exception, $code)
{
              return Response::view('errors.notauthorized', array('subject'=>'Timesheet Entry'), 401);   
});
App::error(function(SomeThingWentWrongException $exception, $code)
{
              return Response::view('errors.somethingwentwrong', array('subject'=>'Project'),400);   
});
App::error(function(Exception $exception, $code)
{   
    return Response::view('errors.somethingwentwrong', array('subject'=>'Project'),400);   
});


/*App::missing(function($exception)
{
    return Response::view('errorpages.404', array(), 404);
});*/

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenace mode is in effect for this application.
|
*/

App::down(function()
{
	return Response::view('errors.maintenance');
});


App::bind('TaskInterface',function(){

	return new TaskRepository;
});
App::bind('ProjectInterface',function(){

  return new ProjectRepository;
});

App::bind('CalendarInterface',function(){

	return new CalendarRepository;
});
App::bind('TimesheetInterface',function(){

	return new TimesheetRepository;
});
App::bind('TodoInterface',function(){

	return new TodoRepository;
});
App::bind('ReportInterface',function(){

	return new ReportRepository;
});
App::bind('UserInterface',function(){

	return new UserRepository;
});
/*

|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';