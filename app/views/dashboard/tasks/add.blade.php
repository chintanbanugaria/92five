@extends('dashboard.default')
@section('head')
<title>92five app - Add Task</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/tasks')}}">Tasks</a> / Add New</h2>
        <!-- Add New Task -->
        <div class="row-fluid add_new_task">
          <div class="span7 add_new_task_left" id="add_new_task_left">
            <form class="form-horizontal" action="#" id="newtaskform" method="post"  data-validate="parsley"  >
              <h3>
              <input type="text" name="task_name" id="task_name" class="task_create_in" value="" placeholder="Task Name (required)" data-required="true" data-show-errors="false">
              </h3>
              <div class="add-proj-form add_task_form">
                <fieldset>
                  <div class="control-group">
                    <label>Project:
                      <p class="help-block">(optional)</p>
                    </label>
                    <select name="projectlist" id="projectlist" class="projectlist" tabindex="1">
                      <option name="" value="null" selected="selected" title="">None</option>
                      @if($projects != null)
                      @foreach($projects as $project)
                      <option name="" value="{{$project['id']}}" title="">{{$project['project_name']}}</option>
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="control-group">
                    <label>Kick off dates:
                    </label>
                    <input id="startdate" name="startdate" type="text" class="span6 pull-left" placeholder="Start date" data-required="true" data-trigger="change">
                    <input id="enddate" name="enddate" type="text" class="span6 pull-right"  class="span6 pull-right" placeholder="End date" data-required="true" data-trigger="change">
                  </div>
                  <div class="control-group">
                    <label>Note:
                      <p class="help-block">(optional)</p>
                    </label>
                    <textarea id="note" class="add-proj-form-t" placeholder="Note"></textarea>
                  </div>
                  <div class="control-group">
                    <label for="passwordinput">Asignee:<span class="tooltipster-icon" title="To add the asignee start typing the name and select the appropriate user from the list. Please note that only those name will appear in list who are registered in the app. Please add your name as well if you are one of them.">(?)</span></label>
                    <div class="controls" style="margin:0;">
                      <div class="span12 flatui-detail" style="position:relative;">
                        <input id="plugin" name="passwordinput" type="text" placeholder="Add Name">
                      </div>
                      <div id="selected">
                        <ul id="list">
                        </ul>
                        <input style="display: none;" name="tagsinput" id="tagsinput" class="tagsinput" placeholder="Add Name" value="" />
                        <p></p>
                      </div>
                    </div>
                  </div>
                  <div class="add_task_button_main"><button class="add_task_submit">Submit</a></button></div>
                </fieldset>
              </form>
            </div>
          </div>
          <div class="span5 add_new_task_right" id="add_new_task_right" >
            <h3>Add Sub-tasks</h3>
            <div class="add-proj-form add_task_form" >
              <form class="form-horizontal" id="newsubtaskform">
                <input id="subtasks"  name="" type="text" placeholder="Subtasks (optional)">
              </form>
              <input style="display: none;" name="taskId" id="taskId" class="tagsinput"  value="" />
              <div class="row-fluid sub_task_list_main">
                <div class="row-fluid">
                  <div class="span12 sub_task_data selected">
                    <ul id="subtasklist">
                    </ul>
                  </div>
                </div>
                <div class="add_task_button_main">
                  <a  href="#"class="add_project" id="taskfiles">Add files (if any)</a>
                  <a  href="{{url('/dashboard/task/added')}}" class="add_project">I am done here.</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
  @stop
  @section('endjs')
  {{ HTML::script('assets/js/jquery/jquery.blockUI.js') }}
  {{ HTML::script('assets/js/dashboard/addtask.js') }}
  <script>
 $(document).on("click", ".removeme", function() {
   var email = $(this).parent('li').attr('email');
   var emaillist = $('#tagsinput').val();
   newemaillist = $.grep(emaillist.split(','), function(v) {
     return v != email;
   }).join(',');
   $(this).parent().remove();
   $('#tagsinput').val(newemaillist);
 });
 $('#add_new_task_right').block({
   message: null
 });
 $(function() {
   var addTaskModel = new AddTaskModel();
   var addTaskview = new AddTaskView({
     model: addTaskModel
   });
 });
</script>
{{ HTML::style('assets/css/dashboard/backbone.autocomplete.css') }}
{{ HTML::script('assets/js/dashboard/backbone.autocomplete.js') }}
{{ HTML::script('assets/js/dashboard/projectuserlist.js') }}
{{ HTML::style('assets/css/dashboard/pickadate.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.date.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.time.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::script('assets/js/dashboard/legacy.js') }}
{{ HTML::script('assets/js/dashboard/picker.js') }}
{{ HTML::script('assets/js/dashboard/picker.date.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/dashboard/addtask.js') }}
{{ HTML::script('assets/js/dashboard/datecheck.js') }}
<script>
$(document).ready(function() {
            $('.tooltipster-icon').tooltipster();
        });
</script>
  @stop

