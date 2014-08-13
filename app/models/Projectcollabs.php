<?php

class Projectcollabs extends \Eloquent{

	    protected $table = 'project_user';
	    	        protected $softDelete = true;

	    
	    public function project()
		{
			return $this->belongsTo('Project','id');
		}



}