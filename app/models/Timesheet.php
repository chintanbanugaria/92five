<?php 
 
class Timesheet extends \Eloquent {
 
    protected $table = 'timesheet';
 
    protected $softDelete = true;

    public function users()
    {
    	return $this->hasMany('User');
    }
    public function tasks()
    {
    	return $this->hasMany('Task');
    }
    public function getUpdatedAtAttribute($value)
    {
            $tempUpdatedAt = new ExpressiveDate($value);
           return($tempUpdatedAt->format('jS F, Y \a\\t g:ia'));
    }
}