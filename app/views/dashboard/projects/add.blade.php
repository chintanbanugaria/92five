@extends('dashboard.default')
@section('head')
<title>92five app - Add Project</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/projects')}}">Projects</a> / Add</h2>
        <div class="row-fluid proj_create">
          <form class="" action='add' method='post' id="addproject"  data-validate="parsley" >
            <h3><input type="text" name="project_name" id="project_name" class="proj_create_in" value="" placeholder="Project Name (required)" data-required="true" data-show-errors="false"> <div class="p-icon-main">
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
                    <textarea class="add-proj-form-t" placeholder="Description" name="description" id="description"></textarea>
                  </div>
                  <div class="control-group">
                    <label>Kick off dates:
                    </label>
                    <input id="startdate" name="startdate" type="text" class="span6 pull-left" placeholder="Start date" data-required="true" data-trigger="change" >
                    <input id="enddate" name="enddate" type="text"  class="span6 pull-right" placeholder="End date" data-required="true" data-trigger="change" >
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Client:
                      <p class="help-block">(optional)</p>
                    </label>
                    <div class="controls">
                      <input id="project_client" name="project_client" type="text" placeholder="Client">
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Note:
                      <p class="help-block">(optional)</p>
                    </label>
                    <div class="controls">
                      <textarea class="add-proj-form-t" placeholder="Note" id="note" name="note"></textarea>
                    </div>
                  </div>
                </fieldset>
              </div>
              <!-- Right Part -->
              <div class="span5 add_proj_right add-proj-form">
                <div class="control-group col">
                  <label class="control-label" for="passwordinput">Collaborators:<span class="tooltipster-icon" title="To add the collaborator start typing the name and select the appropriate from the list. Please note that only those name will appear in the list who are registered in the app. Please add your name as well if you are one of them.">(?)</span></label>
                  <div class="controls">
                    <div class="span12 flatui-detail">
                      <input id="plugin" name="passwordinput" type="text" placeholder="Add Name" >
                    </div>
                    <div id="selected">
                      <ul id="list">
                      </ul>
                      <input style="display: none;" name="tagsinput" id="tagsinput" class="tagsinput"  placeholder="Add Name" value="" />
                      <p></p>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="submit_button_main"><button class="submit">Submit</a></button></div>
          </div>
        </div>
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
 $("#addproject").submit(function(e) {
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
{{ HTML::script('assets/js/dashboard/legacy.js') }}
{{ HTML::script('assets/js/dashboard/picker.js') }}
{{ HTML::script('assets/js/dashboard/picker.date.js') }}
{{ HTML::script('assets/js/dashboard/backbone.autocomplete.js') }}
{{ HTML::script('assets/js/dashboard/userlist.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/dashboard/datecheck.js') }}
<script>
$(document).ready(function() {
  $('.tooltipster-icon').tooltipster();
});
</script>
  @stop

