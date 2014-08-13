<?php 
 
class Events extends \Eloquent {
 
    protected $table = 'events';
 
    protected $softDelete = true;

    public function users()
    {
    	return $this->belongsToMany('User','event_user')->withPivot('user_id');
    }

}