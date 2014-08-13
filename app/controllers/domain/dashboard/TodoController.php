<?php namespace Controllers\Domain\Dashboard;
use Cartalyst\Sentry\Facades\Laravel\Sentry as Sentry;

/**
 * Todo Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class TodoController extends \BaseController{

	protected $todo;
   /**
	* Constructor
	*/
	public function __construct()
	{
		$this->todo = \App::make('TodoInterface');
	}
   /**
	* Get the View Page
	* @return View
	*/
	public function getIndex()
	{
		return \View::make('dashboard.todo.view');
	}
   /**
	* Get Todos
	* @return JSON
	*/

	public function getTodos()
	{
		//Get the user id of the currently logged in user
		$userId = (int) \Sentry::getUser()->id;
		//Get Todos
		$todos = $this->todo->getTodos($userId);
		return $todos;
	}
   /**
	* Update Todos
	* @return JSON
	*/
	public function putTodos()
	{
		//Get the user id of the currently logged in user		
		$userId = (int) \Sentry::getUser()->id;
		//Get data
		$data = \Input::json()->all();
		//Update Todo
		$result = $this->todo->putTodos($data, $userId);
		if($result == 'success')
		{
			return \Response::make('Todo Updated !', 200);
		}
		else
		{
			return \Response::make('Something is Wrong!', 500);
		}
	}
    /**
     * Add Todos
     * @return JSON
     */
	public function postTodos()
	{
		//Get the user id of the currently logged in user
		$userId = (int) \Sentry::getUser()->id;
		//Get Data
		$data = \Input::json()->all();
		//Add Todos
		$result = $this->todo->postTodos($data, $userId);
		return \Response::json(array( 
		       'id' => $result['id'],
		        'status'=>$result['status'],
		        'text' => $result['text']),
		        200);
		
	}
	/**
	 * Delete Todo
	 * @return JSON
	 */
	public function deleteTodos($id)
	{
		//Delete Todo
		$result = $this->todo->deleteTodos($id);
		if($result == 'success')
		{
			return \Response::json(array( 
		       'error' => false),
		        200);

		}
		else
		{
			return \Response::json(array( 
		       'error' => true),
		        500);
		}
	}
	/**
	 * Mark All Completed
	 * @return Redirect
	 */
	public function markAllCompleted()
	{
		//Get the user id of the currently logged in user		
	    $userId = (int) \Sentry::getUser()->id;
		if($userId == null or $userId == '')
		{
			throw new \SomethingWentWrongException();
			
		}
		else
		{
			//Mark All Completed
			$result = $this->todo->markAllCompleted($userId);
			if($result == 'success')
			{
				return \Redirect::to('dashboard/mytodos');
			}
			else
			{
				return \Redirect::to('dashboard/mytodos');
			}
		}
	}
	/**
	 * Delete Completed Todos
	 * @return Redirect
	 *
	 */
	public function deleteCompleted()
	{
		//Get the user id of the currently logged in user
		$userId = (int) \Sentry::getUser()->id;
			//Delete Completed
			$result = $this->todo->deleteCompleted($userId);
			if($result == 'success')
			{
				return \Redirect::to('dashboard/mytodos');
			}
			else
			{
				return \Redirect::to('dashboard/mytodos');
			}
		
	}
	/**
	 * Delete All
	 * @return Redirect
	 */
	public function deleteAll()
	{
		//Get the user id of the currently logged in user
		$userId = (int) \Sentry::getUser()->id;
		//Delete All Todos	
		$result = $this->todo->deleteAll($userId);
		if($result == 'success')
		{
			return \Redirect::to('dashboard/mytodos');
		}
		else
		{
			return \Redirect::to('dashboard/mytodos');
		}
		
	}
}