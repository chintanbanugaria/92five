<?php namespace Controllers\Domain\Admin;
/**
 * Data Controller.    
 * @version    1.0.0
 * @author     Chintan Banugaria
 * @copyright  (c) 2014, 92fiveapp
 * @link       http://92fiveapp.com
 **/
class DataController extends \BaseController{
        /**
         * Get data based on user selection
         * @return View
         */
		public function getIndex()
        {   
             try
             {   
                //Get the type of entity
                $entity = \Input::get('entity');
                if($entity == 'projects')
                {
                    //Get only deleted projects
                    $projects = \Project::onlyTrashed()->get()->toArray();
                    $data;
                    if(sizeof($projects) != 0)
                    {
                            //Manipulation
                            foreach($projects as $project)
                            {   
                                $tempData;
                                $tempData['id'] = $project['id'];
                                $tempData['name'] = $project['project_name'];
                                $tempData['created_at'] = $project['created_at'];
                                $tempData['deleted_at'] = $project['deleted_at'];
                                $tempData['updated_at'] = $project['updated_at'];
                                $userId = $project['deleted_by'];
                                $user = \User::find($userId)->get(array('first_name','last_name'))->toArray();
                                $tempData['user'] = $user;
                                $data [] = $tempData;
                            }
                            //Return data
                            return \View::make('dashboard.admin.data')
                                    ->with('data',$data)
                                    ->with('type','Projects');
                    }
                    else
                    {
                        //No Data found. Return Null
                        return \View::make('dashboard.admin.data')
                                    ->with('data',null)
                                    ->with('type','Projects');
                    }
                }
                elseif($entity == 'tasks')
                {
                    //Get only deleted tasks
                    $tasks = \Task::onlyTrashed()->get()->toArray();
                    $data;
                    if(sizeof($tasks) != 0)
                    {
                            //Manipulation
                            foreach($tasks as $task)
                            {
                                $tempData;
                                $tempData['id'] = $task['id'];
                                $tempData['name'] = $task['name'];
                                $tempData['created_at'] = $task['created_at'];
                                $tempData['deleted_at'] = $task['deleted_at'];
                                $tempData['updated_at'] = $task['updated_at'];
                                $userId = $task['deleted_by'];
                                $user = \User::where('id',$userId)->get(array('first_name','last_name'))->toArray();
                                $tempData['user'] = $user;
                                $data [] = $tempData;
                            }
                            //Return Data
                            return \View::make('dashboard.admin.data')
                                        ->with('data',$data)
                                        ->with('type','Tasks');
                    }
                    else
                    {
                        //No Data Found. Return Null.
                        return \View::make('dashboard.admin.data')
                                        ->with('data',null)
                                        ->with('type','Tasks');
                    }
                  
                }
                elseif($entity == 'events')
                {
                    //Get only deleted events
                    $events = \Events::onlyTrashed()->get()->toArray();
                    $data;
                    if(sizeof($events) != 0)
                    {
                        //Manipulation
                        foreach($events as $event)
                        {
                            $tempData;
                            $tempData['id'] = $event['id'];
                            $tempData['name'] = $event['title'];
                            $tempData['date'] = $event['date'];
                            $tempData['created_at'] = $event['created_at'];
                            $tempData['deleted_at'] = $event['deleted_at'];
                            $tempData['updated_at'] = $event['updated_at'];
                            $userId = $event['deleted_by'];
                            $user = \User::find($userId)->get(array('first_name','last_name'))->toArray();
                            $tempData['user'] = $user;
                            $data [] = $tempData;
                        } 
                        //Return Data
                        return \View::make('dashboard.admin.data')
                                    ->with('data',$data)
                                    ->with('type','Events');  
                    }
                    else
                    {   
                        //No Data Found. Return Null
                        return \View::make('dashboard.admin.data')
                                        ->with('data',null)
                                        ->with('type','Events');
                    }
                }
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in Admin Data Controller - getIndex():'.$e->getMessage());
                throw new \SomethingWentWrongException();
            }
        }
        /**
         * Permanently Delete All Data
         * @param string
         * @return View
         */
        public function deleteAll($type)
        {
            try
            {
                    if($type == 'projects')
                    {
                         //Get all deleted projects
                         $projects = \Project::onlyTrashed()->get()->toArray();
                          if(sizeof($projects) != 0)
                          {
                            foreach($projects as $project)
                               {
                                    //Get Tasks for project
                                    $tasks = \Task::withTrashed()->where('project_id',$project['id'])->lists('id');
                                    if(sizeof($tasks) != 0)
                                    {
                                        //Delet Each Task
                                        foreach ($tasks as $task) 
                                        {
                                            $result = static::deleteEntity($task,'task');
                                        }
                                    }
                                    //Delete Project
                                    $result = static::deleteEntity($project['id'],'project');
                                }
                          }
                         //For Notifications 
                        \Session::put('status','success');
                        \Session::put('message', 'Project Deleted');
                        return \View::make('dashboard.admin.data')
                            ->with('data',null)
                            ->with('type','Projects'); 

                        
                    }
                    elseif($type == 'tasks')
                    {
                        //Get all deleted tasks
                        $tasks = \Task::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($tasks) != 0)
                        {
                                //Delete Each Task
                                foreach($tasks as $task)
                                {
                                    $result = static::deleteEntity($task['id'],'task');

                                }
                        }
                        //For Notifications
                        \Session::put('status','success');
                        \Session::put('message', 'Tasks Deleted');
                        return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Tasks'); 
                        
                    }
                    elseif($type == 'events')
                    {
                       //Permanently delete all events
                        $events = \Events::onlyTrashed()->forceDelete();
                        //For Notifications
                       \Session::put('status','success');
                       \Session::put('message', 'Events Deleted');
                         return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Events');                                    

                    }
            }
            catch(\Exception $e)
            {

                \Log::error('Something Went Wrong in Admin Data Controller - deleteAll():'.$e->getMessage());
                throw new \SomethingWentWrongException();
            }

        }
        /**
         * Delete Entity
         * @param int, string
         * @return boolean
         */
        public static function deleteEntity($id,$type)
        {
            try
            {
                    $dir;
                    $entity;
                    if($type == 'task')
                    {
                        //Find Task
                        $entity  = \Task::withTrashed()->find($id);
                        //Get the path of folder for uploads
                        $dir = public_path().'/uploads/tasks/'.$entity->folder;
                    }
                    elseif($type == 'project')
                    {
                        //Get Project
                        $entity  = \Project::withTrashed()->find($id);
                        //Get the  path of folder for uploads
                        $dir = public_path().'/uploads/projects/'.$entity->folder;
                    }

                    if(is_dir($dir))
                    {
                       //If Uploads directory exists, get list of files
                        $files = array_diff(scandir($dir),array('.','..')); 
                        //Delete Each file
                        foreach ($files as $file) 
                        { 
                            unlink($dir.'/'.$file); 
                        } 
                        //Delete folder
                        $deleteFolder = \File::deleteDirectory($dir);
                        //Get the file attachment Ids
                        $fileIds = \Fileref::where('parent_id',$id)->where('parent_type',$type)->lists('attachment_id');
                        if(sizeof($fileIds) != 0)
                        {
                            //Delete each file attachment entry from database
                            foreach ($fileIds as $fieldId) 
                            {
                             
                                $deletefile = \Files::find($fieldId);
                                $deletefile->forceDelete();
                            }
                        }
                        //Delete the entity
                        $entity->forceDelete();  
                    }
                    else
                    {
                        //Folder doesn't exists, delete the entity
                        $entity->forceDelete();
                    }
                    return true;
            }
            catch(\Exception $e)
            {
                 \Log::error('Something Went Wrong in Admin Data Controller - deleteEntity():'.$e->getMessage());
                throw new \SomethingWentWrongException();
            }
        }
        /**
         * Delete Single Entity
         * @return View
         */
        public function deleteSingleEntity()
        {
            try
            {
                   //Get the entity type and Id
                    $entityType = \Input::get('entitytype');
                    $entityId = \Input::get('entityid');
                    if($entityType == 'tasks')
                    {
                        //Delete task
                        $result = static::deleteEntity($entityId,'task');
                        //Retrieve All data
                        $tasks = \Task::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($tasks) != 0)
                        {
                                foreach($tasks as $task)
                                {
                                    $tempData;
                                    $tempData['id'] = $task['id'];
                                    $tempData['name'] = $task['name'];
                                    $tempData['created_at'] = $task['created_at'];
                                    $tempData['deleted_at'] = $task['deleted_at'];
                                    $tempData['updated_at'] = $task['updated_at'];
                                    $data [] = $tempData;
                                }
                                //For Notifications
                                \Session::put('status','success');
                                \Session::put('message', 'Task Deleted');
                                return \View::make('dashboard.admin.data')
                                            ->with('data',$data)
                                            ->with('type','Tasks');
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Task Deleted');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Tasks');
                        }
                    }
                    elseif($entityType == 'projects')
                    {
                        //Get all tasks for the project
                        $tasks = \Task::withTrashed()->where('project_id',$entityId)->lists('id');
                        if(sizeof($tasks) != 0)
                        {   
                            //Delete All Tasks
                            foreach ($tasks as $task) 
                            {
                                $result = static::deleteEntity($task,'task');
                            }
                        }
                        //Delete project
                        $result = static::deleteEntity($entityId,'project');
                        $projects = \Project::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($projects) != 0)
                        {
                                foreach($projects as $project)
                                {
                                    $tempData;
                                    $tempData['id'] = $project['id'];
                                    $tempData['name'] = $project['project_name'];
                                    $tempData['created_at'] = $project['created_at'];
                                    $tempData['deleted_at'] = $project['deleted_at'];
                                    $tempData['updated_at'] = $project['updated_at'];
                                    $data [] = $tempData;
                                }
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Project Deleted');
                                    return \View::make('dashboard.admin.data')
                                            ->with('data',$data)
                                            ->with('type','Projects');
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Project Deleted');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Projects');
                        }
                    }
                    elseif($entityType == 'events')
                    {   
                        //Delete Event
                        $event = \Events::withTrashed()->find($entityId);
                        $event->forceDelete();
                        $events = \Events::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($events) != 0)
                        {
                            foreach($events as $event)
                            {
                                $tempData;
                                $tempData['id'] = $event['id'];
                                $tempData['name'] = $event['title'];
                                $tempData['date'] = $event['date'];
                                $tempData['created_at'] = $event['created_at'];
                                $tempData['deleted_at'] = $event['deleted_at'];
                                $tempData['updated_at'] = $event['updated_at'];
                                $data [] = $tempData;
                            } 
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Event Deleted');
                            return \View::make('dashboard.admin.data')
                                        ->with('data',$data)
                                        ->with('type','Events');  
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Event Deleted');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Events');
                        }
                    }
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in Admin Data Controller - deleteSingleEntity():'.$e->getMessage());
                throw new \SomethingWentWrongException();
            }
        }
        /**
         * Restore Al
         * @return View
         */
        public function restoreAll($type)
        {
            try
            {
                    if($type == 'events')
                    {
                        //Restore all deleted events with users
                        $events = \Events::onlyTrashed()->restore();
                        $eventsCollabs = \EventUser::onlyTrashed()->restore();
                       \Session::put('status','success');
                       \Session::put('message', 'Events Restored');
                         return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Events');    
                    }
                    elseif($type == 'tasks')
                    {
                        //Get all Ids of deleted tasks
                       $taskIds = \Task::onlyTrashed()->lists('id');
                       foreach($taskIds as $taskId)
                       {
                            $task = \Task::withTrashed()->find($taskId);
                            //Get the project Id associated with Task
                            $projectId = $task->project_id;
                            if($projectId != null)
                            {
                                $project = \Project::withTrashed()->find($projectId);
                                //Check if project is deleted
                                if(!$project->trashed())
                                {
                                    //Project is not deleted, hence restore the task
                                    $task->restore();
                                    \Taskcollabs::withTrashed()->where('task_id',$taskId)->restore();
                                }
                            }
                            else
                            {
                                    //No Project is associated, restore the task
                                    $task->restore();
                                    \Taskcollabs::withTrashed()->where('task_id',$taskId)->restore();
                            }

                       }
                       //Get all deleted tasks
                        $tasks = \Task::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($tasks) != 0)
                        {
                                foreach($tasks as $task)
                                {
                                    $tempData;
                                    $tempData['id'] = $task['id'];
                                    $tempData['name'] = $task['name'];
                                    $tempData['created_at'] = $task['created_at'];
                                    $tempData['deleted_at'] = $task['deleted_at'];
                                    $tempData['updated_at'] = $task['updated_at'];
                                    $data [] = $tempData;
                                }
                                //For Notifications
                                \Session::put('status','success');
                                \Session::put('message', 'Task Restored');
                                return \View::make('dashboard.admin.data')
                                            ->with('data',$data)
                                            ->with('type','Tasks');
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Tasks Restored');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Tasks');
                        }

                    }
                    elseif($type == 'projects')
                    {
                        //Get Ids of the deleted projects
                        $projectIds = \Project::onlyTrashed()->lists('id');
                        foreach($projectIds as $projectId)
                        {
                            //Get Ids of task for each project
                            $taskIds = \Task::withTrashed()->where('project_id',$projectId)->lists('id');
                            if(sizeof($taskIds) != 0)
                            {
                                //Restore each task
                                foreach ($taskIds as $taskId) 
                                {
                                   $task = \Task::withTrashed()->find($taskId);
                                   if($task->trashed())
                                   {
                                        $task->restore();
                                         \Taskcollabs::withTrashed()->where('task_id',$taskId)->restore();
                                   }
                                }
                            }
                            //Restore project and users
                            $project = \Project::withTrashed()->find($projectId);
                            $project->restore();
                            $projectCollabs = \Projectcollabs::withTrashed()->where('project_id',$projectId)->restore();
                        }
                        //For notifications
                        \Session::put('status','success');
                        \Session::put('message', 'Projects Restored');
                        return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Projects');
                    }
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in Admin Data Controller - restoreAll():'.$e->getMessage());
                throw new \SomethingWentWrongException();
            }
        }
        public function restoreSingleEntity()
        {
             try
             {
                    //Get the entity type and Id
                    $entityType = \Input::get('restoreentitytype');
                    $entityId = \Input::get('restoreentityid');
                    if($entityType == 'tasks')
                    {
                       //Find the task
                       $restoreTask = \Task::withTrashed()->find($entityId);
                       //Get the project Id associated with task
                            $projectId = $restoreTask->project_id;
                            if($projectId != null)
                            {
                                $project = \Project::withTrashed()->find($projectId);
                                //Check if project is deleted or not
                                if(!$project->trashed())
                                {
                                    //Project is not deleted, restore task
                                    $restoreTask->restore();
                                    \Taskcollabs::withTrashed()->where('task_id',$entityId)->restore();
                                }
                            }
                            else
                            {       //No project is associtated, restore task
                                    $restoreTask->restore();
                                    \Taskcollabs::withTrashed()->where('task_id',$entityId)->restore();
                            }

                        $tasks = \Task::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($tasks) != 0)
                        {
                                foreach($tasks as $task)
                                {
                                    $tempData;
                                    $tempData['id'] = $task['id'];
                                    $tempData['name'] = $task['name'];
                                    $tempData['created_at'] = $task['created_at'];
                                    $tempData['deleted_at'] = $task['deleted_at'];
                                    $tempData['updated_at'] = $task['updated_at'];
                                    $data [] = $tempData;
                                }
                                //For Notifications
                                \Session::put('status','success');
                                \Session::put('message', 'Task Restored');
                                return \View::make('dashboard.admin.data')
                                            ->with('data',$data)
                                            ->with('type','Tasks');
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Task Restored');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Tasks');
                        }
                    }
                    elseif($entityType == 'projects')
                    {
                            //List all Task Ids of the project
                            $taskIds = \Task::withTrashed()->where('project_id',$entityId)->lists('id');
                            if(sizeof($taskIds) != 0)
                            {
                                foreach ($taskIds as $taskId) 
                                {
                                   $task = \Task::withTrashed()->find($taskId);
                                   //Check if task if trashed or not
                                   if($task->trashed())
                                   {
                                        //Restore Task
                                        $task->restore();
                                        \Taskcollabs::withTrashed()->where('task_id',$taskId)->restore();
                                   }
                                }
                            }
                            //Find Project and restore
                            $project = \Project::withTrashed()->find($entityId);
                            $project->restore();
                            $projectCollabs = \Projectcollabs::withTrashed()->where('project_id',$entityId)->restore();
                        $projects = \Project::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($projects) != 0)
                        {
                                foreach($projects as $project)
                                {
                                    $tempData;
                                    $tempData['id'] = $project['id'];
                                    $tempData['name'] = $project['project_name'];
                                    $tempData['created_at'] = $project['created_at'];
                                    $tempData['deleted_at'] = $project['deleted_at'];
                                    $tempData['updated_at'] = $project['updated_at'];
                                    $data [] = $tempData;
                                }
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Project Restored');
                                    return \View::make('dashboard.admin.data')
                                            ->with('data',$data)
                                            ->with('type','Projects');
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Project Restored');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Projects');
                        }
                    }
                    elseif($entityType == 'events')
                    {
                        //Find Event and restore it
                        $restoreEvent = \Events::withTrashed()->find($entityId);
                        $restoreEvent->restore();
                        $restoreEventCollabs = \EventUser::withTrashed()->where('events_id',$entityId)->restore();
                        $events = \Events::onlyTrashed()->get()->toArray();
                        $data;
                        if(sizeof($events) != 0)
                        {
                            foreach($events as $event)
                            {
                                $tempData;
                                $tempData['id'] = $event['id'];
                                $tempData['name'] = $event['title'];
                                $tempData['date'] = $event['date'];
                                $tempData['created_at'] = $event['created_at'];
                                $tempData['deleted_at'] = $event['deleted_at'];
                                $tempData['updated_at'] = $event['updated_at'];
                                $data [] = $tempData;
                            } 
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Event Restored');
                            return \View::make('dashboard.admin.data')
                                        ->with('data',$data)
                                        ->with('type','Events');  
                        }
                        else
                        {
                            //For Notifications
                            \Session::put('status','success');
                            \Session::put('message', 'Event Restored');
                            return \View::make('dashboard.admin.data')
                                            ->with('data',null)
                                            ->with('type','Events');
                        }
                    }
            }
            catch(\Exception $e)
            {
                \Log::error('Something Went Wrong in Admin Data Controller - restoreSingleEntity():'.$e->getMessage());
                throw new \SomethingWentWrongException();
            }
        }
          
}