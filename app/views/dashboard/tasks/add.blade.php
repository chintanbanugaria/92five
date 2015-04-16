@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.addTask')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a> / <a href="{{url('/dashboard/tasks')}}">{{trans('92five.Tasks')}}</a> / {{trans('92five.addNew')}}</h2>
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
                    <label>{{trans('92five.project')}}:
                      <p class="help-block">({{trans('92five.optional')}})</p>
                    </label>
                    <select name="projectlist" id="projectlist" class="projectlist" tabindex="1">
                      <option name="" value="null" selected="selected" title="">{{trans('92five.none')}}</option>
                      @if($projects != null)
                      @foreach($projects as $project)
                      <option name="" value="{{$project['id']}}" title="">{{$project['project_name']}}</option>
                      @endforeach
                      @endif
                    </select>
                  </div>
                  <div class="control-group">
                    <label>{{trans('92five.kickOffDates')}}:
                    </label>
                    <input id="startdate" name="startdate" type="text" class="span6 pull-left" placeholder="Start date" data-required="true" data-trigger="change">
                    <input id="enddate" name="enddate" type="text" class="span6 pull-right"  class="span6 pull-right" placeholder="End date" data-required="true" data-trigger="change">
                  </div>
                  <div class="control-group">
                    <label>{{trans('92five.note')}}:
                      <p class="help-block">({{trans('92five.optional')}})</p>
                    </label>
                    <textarea id="note" class="add-proj-form-t" placeholder="Note"></textarea>
                  </div>
                  <div class="control-group">
                    <label for="passwordinput">{{trans('92five.assignee')}}:<span class="tooltipster-icon" title="To add the asignee start typing the name and select the appropriate user from the list. Please note that only those name will appear in list who are registered in the app. Please add your name as well if you are one of them.">(?)</span></label>
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
                  <div class="add_task_button_main"><button class="add_task_submit">{{trans('92five.submit')}}</a></button></div>
                </fieldset>
              </form>
            </div>
          </div>
          <div class="span5 add_new_task_right" id="add_new_task_right" >
            <h3>{{trans('92five.addSubTask')}}</h3>
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
                  <a  href="#"class="add_project" id="taskfiles">{{trans('92five.addFilesIfAny')}}</a>
                  <a  href="{{url('/dashboard/task/added')}}" class="add_project">{{trans('92five.iAmDoneHere')}}.</a>
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

