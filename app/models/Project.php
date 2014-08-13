<?php 
 
class Project extends \Eloquent {
 
    protected $table = 'projects';
 
    protected $softDelete = true;

    public function projectcollabs()
	{
			return $this->hasMany('Projectcollabs','project_id');
	}
 
}