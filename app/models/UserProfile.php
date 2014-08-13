<?php

class UserProfile extends \Eloquent{

	    protected $table = 'user_profile';

	        protected $softDelete = true;

	    public function user()
		{
			return $this->belongsTo('User','id');
		}



}