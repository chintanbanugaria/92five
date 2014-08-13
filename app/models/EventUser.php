<?php 
 
class EventUser extends \Eloquent {
 
    protected $table = 'event_user';
 
    protected $softDelete = true;

    public function events()
    {
    	return $this->belongsTo('Events','events_id');
    }

}