@extends('dashboard.default')
@section('head')
<title>92five app - Edit Project</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard<a> / <a href="{{url('/dashboard/projects')}}">Projects</a> / Edit</h2>
        <div class="row-fluid proj_create">
          <form class="" action='' method='post' id="editproject" data-validate="parsley">
            <h3><input type="text" name="project_name" id="project_name" class="proj_create_in" value="{{$project['project_name']}}" placeholder="Project Name (required)" data-required="true" data-show-errors="false"> <div class="p-icon-main">
          </div></h3>
          <div class="row-fluid span12 proj_create_detail">
            <div class="row-fluid">
              <!-- Left Part -->
              <div class="span7 add-proj-form form-horizontal">
                <fieldset>
                  <div class="control-group">
                    <label>Description:
                      <p class="help-block">(optional)</p>
                    </label>
                    <textarea class="add-proj-form-t" placeholder="Description" name="description" id="description">{{$project['description']}}</textarea>
                  </div>
                  <div class="control-group">
                    <label>Kick off dates:
                    </label>
                    <input id="startdate" name="startdate" type="text" class="span6 pull-left" placeholder="Start date" value="{{new ExpressiveDate($project['start_date'])}}" data-required="true" data-trigger="change">
                    <input id="enddate" name="enddate" type="text"  class="span6 pull-right" placeholder="End date" value="{{new ExpressiveDate($project['end_date'])}}" data-required="true" data-trigger="change">
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Client:
                      <p class="help-block">(optional)</p>
                    </label>
                    <div class="controls">
                      <input id="project_client" name="project_client" type="text" placeholder="Client" value="{{$project['project_client']}}">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Note:
                      <p class="help-block">(optional)</p>
                    </label>
                    <div class="controls">
                      <textarea class="add-proj-form-t" placeholder="Note" id="note" name="note">{{$project['note']}}</textarea>
                    </div>
                  </div>
                  <div class="content_detail">
                    <div class="row-fluid field_data">
                      <div class="span5 field_name">Status:</div>
                      <div class="span7 radio-group">
                        @if($project['status'] == 'active')
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="1" name="status" value="active" checked>
                        <span class="radio-label"><span class="activelabel">Active</span></span> </div>
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="2" name="status" value="completed" >
                        <span class="radio-label"><span class="completedlabel">Completed</span></span></div>
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="3" name="status" value="delayed" >
                        <span class="radio-label"><span class="delayedlabel">Delayed</span></span></div>
                        @elseif($project['status'] == 'completed')
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="1" name="status" value="active" >
                        <span class="radio-label"><span class="activelabel">Active</span></span> </div>
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="2" name="status" value="completed" checked >
                        <span class="radio-label"><span class="completedlabel">Completed</span></span></div>
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="3" name="status" value="delayed" >
                        <span class="radio-label"><span class="delayedlabel">Delayed</span></span></div>
                        @elseif($project['status'] == 'delayed')
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="1" name="status" value="active" >
                        <span class="radio-label"><span class="activelabel">Active</span></span> </div>
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="2" name="status" value="completed" >
                        <span class="radio-label"><span class="completedlabel">Completed</span></span></div>
                        <div class="span12 radio_proj_edit">
                          <input type="radio" id="3" name="status" value="delayed" checked >
                        <span class="radio-label"><span class="delayedlabel">Delayed</span></span></div>
                        @endif
                      </div>
                    </div>
                  </div>
                </fieldset>
              </div>
              <!-- Right Part -->
              <div class="span5 add_proj_right add-proj-form">
                <div class="control-group col">
                  <label class="control-label" for="passwordinput">Collaborators:<span class="tooltipster-icon" title="To add the collaborator start typing the name and select the appropriate from the list. Please note that only those name will appear in the list who are registered in the app.Please add your name as well if you are one of them.">(?)</span></label>
                  <div class="controls">
                    <div class="span12 flatui-detail">
                      <input id="plugin" name="passwordinput" type="text" placeholder="Add Name">
                    </div>
                    <div id="selected">
                      <ul id="list">
                        @foreach($users as $user)
                        <li id="userlist" class="userlist" email={{$user['email']}} >{{$user['first_name'].' '.$user['last_name']}} <a class="removeme" id="removeme" href="#">X</a></li>
                        @endforeach
                      </ul>
                      <input style="display: none;" name="tagsinput" id="tagsinput" class="tagsinput" placeholder="Add Name" value="{{$emaillist}}" data-trigger="change" data-required="true"/>
                      <p></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="submit_button_main"><button class="submit">Update</a></button></div>
          </div>
        </div>
        <input type="hidden" id="projectid" name="projectid" value={{$project['id']}} />
      </form>
    </div>
  </div>
</div>
</div>
@stop
@section('endjs')
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
 $("#editproject").submit(function(e) {
   if ($("#tagsinput").val() == '') {
     alert('Atleast add one Collaborator');
     e.preventDefault();
   }
 });
</script>

{{ HTML::style('assets/css/dashboard/pickadate.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.date.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.time.css') }}
{{ HTML::style('assets/css/dashboard/backbone.autocomplete.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::style('assets/css/dashboard/jqtransform.css') }}
{{ HTML::script('assets/js/dashboard/legacy.js') }}
{{ HTML::script('assets/js/dashboard/picker.js') }}
{{ HTML::script('assets/js/dashboard/picker.date.js') }}
{{ HTML::script('assets/js/dashboard/backbone.autocomplete.js') }}
{{ HTML::script('assets/js/dashboard/userlist.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/jquery/jquery.jqtransform.js') }}
{{ HTML::script('assets/js/dashboard/datecheck.js') }}
<script>
$(function() {
  $('.radio-group').jqTransform();
}); 
$(document).ready(function() {
            $('.tooltipster-icon').tooltipster();
        });
</script>
  @stop

