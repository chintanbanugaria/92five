<?php

class Taskcollabs extends \Eloquent{

	    protected $table = 'task_user';

	        protected $softDelete = true;

	    public function task()
		{
			return $this->belongsTo('Task','id');
		}
		public function users()
		{
			return $this->belongsTo('User','id');
		}


}