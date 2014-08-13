@extends('dashboard.default')
@section('head')
<title>92five app - Edit Timesheet</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard<a> / <a href="{{url('/dashboard/timesheet')}}">Timesheet</a> / Edit Entry</h2>
        <div class="row-fluid proj_create">
          <form class="" action='' method='post' data-validate="parsley">
            <h3><input type="text" name="title" id="title" class="proj_create_in" value="{{$entry['title']}}" placeholder="Event Name (required)" data-required="true" data-show-errors="false"> <div class="p-icon-main">
          </div></h3>
          <div class="row-fluid span12 proj_create_detail">
            <div class="row-fluid">
              <!-- Left Part -->
              <div class="span6 add-proj-form">
                <fieldset>
                  <div class="control-group">
                    <input id="date" name="date" type="text" class="span6" value="{{new ExpressiveDate($entry['date'])}}" placeholder="Date" data-required="true" data-show-errors="true">
                    <input id="starttime" name="starttime" type="text" class="span3" placeholder="From" data-required="true" data-show-errors="true" value="{{date('g:iA', strtotime($entry['start_time']))}}">
                    <input id="endtime" name="endtime" type="text" class="span3" placeholder="Till" data-required="true" data-show-errors="true" value="{{date('g:iA', strtotime($entry['end_time']))}}">
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Details:</label>
                    <div class="controls">
                      <textarea name="details" id="details" class="add-proj-form-t" placeholder="Details">{{$entry['details']}}</textarea>
                    </div>
                  </div>
                </fieldset>
              </div>
              <!-- Right Part -->
              <div class="span5 add_proj_right add-proj-form">
                <fieldset>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Task:</label>
                    <div class="controls">
                      <div class="task_select">
                        <select name="task" id="task" tabindex="1">
                          @if($tasks != null)
                          @foreach($tasks as $task)
                          @if($entry['task_id'] == $task['id'])
                          <option  name="" selected value={{$task['id']}} title="">{{$task['name']}}</option>
                          @else
                          <option  name="" value={{$task['id']}} title="">{{$task['name']}}</option>
                          @endif
                          @endforeach
                          @if($entry['task_id'] == null)
                          <option  name="" selected value="others" title="">Others</option>
                          @else
                          <option  name="" value="others" title="">Others</option>
                          @endif
                          @else
                          <option  name="" value="others" title="">No tasks</option>
                          @endif
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="control-group">
                    <label class="control-label" for="passwordinput">Remarks:</label>
                    <div class="controls">
                      <textarea name="remarks" id="remarks" class="add-proj-form-t" placeholder="Remarks">{{$entry['remarks']}}</textarea>
                    </div>
                  </div>
                </fieldset>
              </div>
              <div class="submit_button_main"><button class="submit">Update</a></button></div>
            </div>
          </div>
          <input type="hidden" id="entryid" name="entryid" value="{{$entry['id']}}" />
        </form>
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')
{{ HTML::style('assets/css/dashboard/pickadate.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.date.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.time.css') }}
{{ HTML::style('assets/css/dashboard/backbone.autocomplete.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::style('assets/css/dashboard/jqtransform.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.time.css') }}
{{ HTML::script('assets/js/dashboard/legacy.js') }}
{{ HTML::script('assets/js/dashboard/picker.js') }}
{{ HTML::script('assets/js/dashboard/picker.date.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/dashboard/picker.time.js') }}
<script>
 $('#date').pickadate({
   formatSubmit: 'yyyy-mm-dd'
 });
 var from_$input = $('#starttime').pickatime({
   interval: 15,
   formatSubmit: 'HH:i',
   formatLabel: function(timeObject) {
     return '<b>h</b>:i <!i>a</!i>';
   }
 });
 var from_picker = from_$input.pickatime('picker');
 var to_$input = $('#endtime').pickatime({
   interval: 15,
   formatSubmit: 'HH:i',
   formatLabel: function(timeObject) {
     var minObject = this.get('min');

     var hours = timeObject.hour - minObject.hour;
     var mins = (timeObject.mins - minObject.mins) / 60;
     pluralize = function(number, word) {
       return number + ' ' + (number === 1 ? word : word + 's');
     }
     return '<b>h</b>:i <!i>a</!i> <sm!all>(' + pluralize(hours + mins, '!hour') + ')</sm!all>';
   }
 });
 var to_picker = to_$input.pickatime('picker');
 if (from_picker.get('value')) {
   to_picker.set('min', from_picker.get('select'));
 }
 if (to_picker.get('value')) {
   from_picker.set('max', to_picker.get('select'));
 }
 from_picker.on('set', function(event) {
   if (event.select) {
     to_picker.set('min', from_picker.get('select'));
   }
 });
 to_picker.on('set', function(event) {
   if (event.select) {
     from_picker.set('max', to_picker.get('select'));
   }
 });
</script>
  @stop

