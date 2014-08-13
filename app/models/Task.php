<?php 
 
class Task extends \Eloquent {
 
    protected $table = 'tasks';
 
    protected $softDelete = true;

    public function users()
    {
    	return $this->belongsToMany('User','task_user')->withPivot('user_id');
    }

	public function subtasks()
	{
		    return $this->hasMany('Subtask');

	} 
}