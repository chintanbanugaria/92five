<?php 
use \Todos as Todos;
use \SomeThingWentWrongException as SomeThingWentWrongException;
/**
 * Todo Repository.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class TodoRepository implements TodoInterface{

	public function getTodos($userId)
	{
		$todos = Todos::where('user_id','=',$userId)->orderBy('created_at','DESC')->get(array('id','text','status'))->toJson();
		return $todos;
	}
	public function putTodos($data, $userId)
	{
		try
		{	
			$todos = Todos::where('id','=',$data['id'])->where('user_id','=',$userId)->first();
			$todos->status = $data['status'];
			$todos->save();
			return 'success';
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Todo Repository - putTodos():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}
	}
	public function postTodos($data, $userId)
	{
		try
		{
			$todo = new Todos;
			$todo->text = $data['text'];
			$todo->status = 'incomplete';
			$todo->user_id = $userId;
			$todo->save();
			return $todo;
		}
		catch(\Exception $e)
		{
			\Log::error('Something Went Wrong in Todo Repository - postTodos():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}

	}
	public function deleteTodos($id)
	{
		try
		{
			$todos = Todos::find($id);
			$todos->forceDelete();
			return 'success';
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong in Todo Repository - deleteTodos():'. $e->getMessage());
			return 'error';
		}

	}
	public function markAllCompleted($userId)
	{
		try
		{
			$todos = Todos::where('user_id',$userId)->where('status','incomplete')->get(array('id'))->toArray();
			if($todos == null)
			{
				//No Todos found
				return 'error';
			}
			else
			{
				foreach ($todos as $todo) 
				{
					$tempTodo = \Todos::find($todo['id']);
					$tempTodo->status = 'completed';
					$tempTodo->save();

				}
				return 'success';
			}
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong in Todo Repository - markAllCompleted():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}

	}
	public function deleteCompleted($userId)
	{
		try
		{
			$todos = Todos::where('user_id',$userId)->where('status','completed')->forceDelete();
			return 'success';
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong in Todo Repository - deleteCompleted():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}

	}
	public function deleteAll($userId)
	{
		try
		{
			$todos = Todos::where('user_id',$userId)->forceDelete();
			return 'success';
		}
		catch(Exception $e)
		{
			\Log::error('Something Went Wrong in Todo Repository - deleteAll():'. $e->getMessage());
			throw new SomeThingWentWrongException();
		}

	}
}