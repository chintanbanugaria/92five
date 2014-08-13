@extends('dashboard.default')
@section('head')
<title>92five app - View Task</title>
@stop
@section('content')

<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/tasks')}}">Task</a> / {{$task['name']}}</h2>
        <!-- Add New Task -->
        <div class="row-fluid view_task">
          <div class="span7 view_task_left">
            <h3>
            @if($task['status'] == 'completed')
            <div class="view_task_check"><input type="checkbox" id={{$task['id']}} value={{$task['id']}} class="regular-checkbox" checked style="position:relative; left:5px;" /><label class="taskCheck" for={{$task['id']}}></label></div>
            <span class="task_link_select">{{$task['name']}}</span>
            @else
            <div class="view_task_check"><input type="checkbox" id={{$task['id']}} value={{$task['id']}} class="regular-checkbox" style="position:relative; left:5px;" /><label class="taskCheck" for={{$task['id']}}></label></div>
            <span>{{$task['name']}}</span>
            @endif
            <div class="add-icon-main">
              <a class="p-icon-1" title="Edit Task" href="{{url('/dashboard/tasks/edit',array($task['id']))}}"><img alt="" src="{{asset('assets/images/dashboard/p-edit.png')}}"></a>
              <a class="p-icon-1" title="Delete Task" data-toggle="modal" href="#myModal-item-delete"><img alt="" src="{{asset('assets/images/dashboard/p-delete.png')}}"></a>
            </div>
            </h3>
            <div class="row-fluid view_comp_deleyed">
              @if($task['status'] == 'active')
              <div class="task_no_inner view_task_hr" id ="task_no_inner">{{sprintf("%02s", $task['num_status'])}} <p><a href="#">days remaining</a></p></div>
              @elseif($task['status'] == 'completed')
              <div class="task_compete view_task_hr2">Completed on {{new ExpressiveDate($task['completed_on'])}}</div>
              @elseif($task['status'] == 'delayed')
              <div class="task_delayed view_task_hr3">Delayed</div>
              @endif
            </div>
            <div class="row-fluid view_date">
              <div class="span6 view_date_detail">Start date : <span>{{new ExpressiveDate($task['start_date'])}}</span></div>
              <div class="span6 view_date_detail">End date: <span>{{new ExpressiveDate($task['end_date'])}}</span></div>
            </div>
            <div class="add-proj-form add_task_form">
              <form class="form-horizontal">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Project:</label>
                    <div class="controls">
                      @if($task['project_id'] != null)
                      <div class="note_for_task"> <a href="{{url('dashboard/projects',array($task['project_id']))}}">{{$task['project_name']}}</a></div>
                      @else
                      <div class="note_for_task"><span class="no_proj_tasks">[No Project is assigned]</span></div>
                      @endif
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Note:</label>
                    <div class="controls">
                      @if($task['note'] != null)
                      <div class="note_for_task">{{$task['note']}}</div>
                      @else
                      <div class="note_for_task"><span class="no_proj_tasks">[No Note for this task]</span></div>
                      @endif
                    </div>
                  </div>
                  <div class="row-fluid span12 a_reamining viewtasklist">
                    <h4>Asignee:</h4>
                    @if($task['status'] == 'active')
                    <ul class="collaborators">
                      @elseif($task['status'] == 'completed')
                      <ul class="collaborators_comp">
                        @elseif($task['status'] == 'delayed')
                        <ul class="collaborators_delayed">
                          @endif
                          @foreach($task['users'] as $user)
                          <li><a href="{{url('/dashboard/user',array($user['id']))}}">{{$user['first_name']." ".$user['last_name']}}</a></li>
                          @endforeach
                        </ul>
                      </div>
                      <div class="row-fluid span12 a_reamining viewtasklist">
                        <h4>Files:</h4>
                        @if($task['files'] == null)
                        <div class ="no_file" >
                          [ No files are attached with this Task ]
                        </div>
                        @else
                        @if($task['status'] == 'active')
                        <ul class="files_1">
                          @elseif($task['status'] == 'completed')
                          <ul class="files_1_comp files_1">
                            @elseif($task['status'] == 'delayed')
                            <ul class="files_1_delayed files_1">
                              @endif
                              @foreach($task['files'] as $file)
                              <li>
                                <a href="{{url('/dashboard/download',array($file['key']))}}">
                                  @if(strlen($file['file_name']) > 36)
                                  {{substr($file['file_name'],0,36).' ...'}}
                                  @else
                                  {{$file['file_name']}}
                                  @endif
                                </a>
                                <span class="view_proj_filedesc">{{$file['size']}} Uploaded on {{new ExpressiveDate($file['uploaded_date'])}} by {{User::where('id',$file['uploaded_by'])->pluck('first_name')}} {{User::where('id',$file['uploaded_by'])->pluck('last_name')}}</span>
                              </li>
                              @endforeach
                            </ul>
                            @endif
                          </div>
                        </fieldset>
                      </form>
                    </div>
                  </div>
                  <div class="span5 add_new_task_right">
                    <h3>Sub-tasks</h3>
                    <div class="add-proj-form add_task_form">
                      <div class="row-fluid sub_task_list_main">
                        @if(sizeof($subtasks) != 0)
                        @foreach($subtasks as $subTask)
                        @if($subTask['status'] == 'active')
                        <div class="row-fluid">
                          <div class="span1 sub_check_1">
                            <input type="checkbox" id="subtask-{{$subTask['id']}}" value="subtask-{{$subTask['id']}}" class="regular-checkbox" style="position:relative; left:5px;" /><label class="subtasks" subtaskid={{$subTask['id']}} for="subtask-{{$subTask['id']}}"></label>
                          </div>
                          <div class="span11 sub_task_data">
                            <div class="add_t_detail_1">{{$subTask['text']}}</div>
                          </div>
                        </div>
                        @elseif($subTask['status'] == 'completed')
                        <div class="row-fluid">
                          <div class="span1 sub_check_1">
                            <input type="checkbox" id="subtask-{{$subTask['id']}}" checked value="subtask-{{$subTask['id']}}" class="regular-checkbox" style="position:relative; left:5px;" /><label class="subtasks" subtaskid={{$subTask['id']}} for="subtask-{{$subTask['id']}}"></label>
                          </div>
                          <div class="span11 sub_task_data">
                            <div class="add_t_detail_1 task_link_select">{{$subTask['text']}}</div>
                          </div>
                        </div>
                        @endif
                        @endforeach
                        @else
                        No Sub Tasks
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<!--Start Delete popup  -->
<div id="myModal-item-delete" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm delete the task?</div>
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/tasks/delete')}}">  <input type="hidden" name="taskId" id="taskId" value="{{$task['id']}}"  > <button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- End Delete Popup -->
 @if(Session::has('status') and Session::has('message') )
@if(Session::has('status') == 'success')
<script>
$(document).ready( function() {
  var url = window.location.href;
var tempurl = url.split('dashboard')[0];
iosOverlay({
    text: "{{Session::get('message')}}",
    duration: 5e3,
    icon: tempurl+'assets/images/notifications/check.png'
  });

});
</script>
{{Session::forget('status'); Session::forget('message');}}
@elseif(Session::has('status') == 'error')
<script>
$(document).ready( function() {
  var url = window.location.href;
var tempurl = url.split('dashboard')[0];
  iosOverlay({
    text: "{{Session::get('message')}}",
    duration: 5e3,
    icon: tempurl+'assets/images/notifications/cross.png'
  });
});
</script>
{{Session::forget('status'); Session::forget('message');}}
@endif
@endif
@stop
@section('endjs')
{{ HTML::script('assets/js/jquery/jquery.blockUI.js') }}
{{ HTML::script('assets/js/dashboard/viewtask.js') }}
{{ HTML::script('assets/js/dashboard/subtasks.js') }}
<script>
$(function() {
  var taskModel = new TaskModel()
  var taskview = new TaskView({
    model: taskModel
  });
  var subTaskModel = new SubTaskModel();
  var subTaskView = new SubTaskView({
    model: subTaskModel
  });
});
$(document).on("click", ".dontdelete", function() {

  $('#myModal-item-delete').modal('hide');
});
</script>
@if($task['status'] == 'completed')
<script>
$('.add_new_task_right').block({ message: null });
</script>
@endif
  @stop

