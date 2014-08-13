@extends('dashboard.default')
@section('head')
<title>92five app - Timesheet</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Timesheet</h2>
        <div class="add_project_main">
          <div class="timesheet-form">
            <label>Custom Date View</label>
            <div class="input-append">
              <form class="form-vertical" action="{{url('/dashboard/timesheet/entry')}}" method='post' data-validate="parsley">
                <input class="span7"  name="eventDate"id="eventDate" type="text" data-required="true" data-trigger="change">
                <button class="submit timesheetcustom">View</button>
              </form>
            </div>
          </div>
          <a data-toggle="modal" href="#myModal" class="add_project add-last">+ Add new Entry</a>
        </div>
        <!-- Time Sheet Detail -->
        <div class="timesheet-detail-main cal3">
          <!--  Calender Slider -->
          <div class="calender_detail">
            <div class="jcarousel-wrapper">
              <div class="jcarousel">
                <ul>
                  @foreach ($week as $day)
                  @if($day['date'] == $selectedDate)
                  <li class="{{$day['class']}} c_select" id="">
                    <span class="c_day">{{$day['dayofweek']}}</span>
                    <span class="c_date">{{$day['day']}}</span>
                    <span class="c_month">{{$day['month']}}</span>
                    <span class="c_year">{{$day['year']}}</span>
                  </li>
                  @else
                  <li class={{$day['class']}} id="">
                    <span class="c_day">{{$day['dayofweek']}}</span>
                    <span class="c_date">{{$day['day']}}</span>
                    <span class="c_month">{{$day['month']}}</span>
                    <span class="c_year">{{$day['year']}}</span>
                  </li>
                  @endif
                  @endforeach
                </ul>
              </div>
              <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
              <a href="#" class="jcarousel-control-next">&rsaquo;</a>
              <p class="jcarousel-pagination"></p>
            </div>
          </div>
        </div>
        <div class="timesheet-detail-title" id="timesheet-detail-title">Entries showing for {{ new ExpressiveDate($selectedDate)}}</div>
        <div class="row-fluid timesheet-detail" id="timesheet-detail">
          <!-- Box 1 -->
          @if($entries != null)
          @foreach($entries as $entry)
          <div class="">
            <div class="timesheet-box">
              <div class="timesheet-detail-1">
                <ul>
                  <li><a class="p-icon-1 icontoottip" title="Edit Entry" href="{{url('/dashboard/timesheet/entry/edit',array($entry['id']))}}"><img src="{{asset('assets/images/dashboard/p-edit.png')}}" alt=""></a></li>
                  <li><a class="p-icon-1 icontoottip" title="Delete Entry" href="#"><img  class="delevent" eventid={{$entry['id']}} src="{{asset('assets/images/dashboard/p-delete.png')}}" alt=""></a></li>
                </ul>
              </div>
              <div class="row-fluid timesheet-detail-2">
                <div class="span5">Worked on : </div>
                <div class="span7">{{$entry['title']}}</div>
              </div>
              <div class="timesheet-detail-3"></div>
              <div class="workingtime">{{$entry['total_hours']}} hours {{$entry['total_minutes']}} minutes</div>
              <div class="timesheet-time">from {{date('g:ia', strtotime($entry['start_time']))}} till {{date('g:ia', strtotime($entry['end_time']))}}</div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">Details:</div>
                @if($entry['details'] == null)
                <div class="span7">[No details]</div>
                @else
                <div class="span7">{{$entry['details']}}</div>
                @endif
              </div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">Task:</div>
                @if($entry['task'] == null)
                <div class="span7">[No task]</div>
                @else
                <div class="span7">{{$entry['task']['name']}}</div>
                @endif
              </div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">Remark:</div>
                @if($entry['details'] == null)
                <div class="span7">[No remarks]</div>
                @else
                <div class="span7">{{$entry['remarks']}}</div>
                @endif
              </div>
              <div class="timesheet-create">updated on {{$entry['updated_at']}}</div>
            </div>
          </div>
          @endforeach
          @else
          <div class="nodatadisplay_main">
            <div class="nodatadisplay">
              <h2>Sorry. Couldn't find any entry for this day.</h2>
              <div class="nodata_inner">
                <div class="nodata_left"></div>
                <div class="nodata_right"></div>
                <div class="nodata_detail_2"><img src="{{asset('assets/images/dashboard/smile_icon.png')}}" alt=""></div>
              </div>
            </div>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Start Add Entry Popup -->
<div id="myModal" class="modal hide fade cal_light_box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form class="form-horizontal" action="{{url('/dashboard/timesheet/entry/add')}}" method='post' data-validate="parsley">
    <div class="modal-header form_modal_header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">
      <input type="text" name="title" id="title" class="popup_title_input" placeholder="Worked on ?" data-required="true" data-show-errors="false">
      </h3>
    </div>
    <div class="modal-body">
      <div class="popup_event">
        <div class="add-proj-form">
          <fieldset>
            <div class="row-fluid">
              <div class="control-group">
                <div class="row-fluid">
                  <input id="date" name="date" type="text" class="span6 pull-left" placeholder="Date" data-required="true" data-trigger="change">
                  <input id="starttime" name="starttime" type="text" class="span3 pull-left" placeholder="From" data-required="true" data-trigger="change">
                  <input id="endtime" name="endtime" type="text" class="span3 pull-left" placeholder="Till" data-required="true" data-trigger="change">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="passwordinput">Task:</label>
                <div class="controls">
                  <div class="task_select">
                    <select name="task" id="task" tabindex="1" style="width:270px;">
                      @if($tasks != null)
                      @foreach($tasks as $task)
                      <option  name="" value={{$task['id']}} title="">{{$task['name']}}</option>
                      @endforeach
                      <option  name="" value="others" title="">Others</option>
                      @else
                      <option  name="" value="others" title="">No tasks</option>
                      @endif
                    </select>
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="details">Details:</label>
                <div class="controls">
                  <textarea  name="details" id="details" class="add-proj-form-t" placeholder="Details"></textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="remarks">Remarks:</label>
                <div class="controls">
                  <textarea  name="remarks" id="remarks" class="add-proj-form-t" placeholder="Remarks"></textarea>
                </div>
              </div>
            <button class="submit pull-right">Submit</a></button>
          </fieldset>
        </div>
      </div>
    </div>
  </form>
</div>
</div>
<!-- End Add Event Popup -->
<!-- Timesheet Entry Template -->
 <script type="text/template" id="timesheet-entry">

  <div class="">
                  <div class="timesheet-box">
                      <div class="timesheet-detail-1">
                          <ul>
                              <li><a href="{{url('/dashboard/timesheet/entry/edit')}}/<%=id%>" class="p-icon-1 icontoottip" title="Edit Entry"><img src="{{asset('assets/images/dashboard/p-edit.png')}}" alt=""></a></li>
                                <li><a href="#" class="p-icon-1 icontoottip" title="Delete Entry"><img class="delevent" eventid="<%= id%>" src="{{asset('assets/images/dashboard/p-delete.png')}}" alt=""></a></li>
                            </ul>
                        </div>
                        <div class="row-fluid timesheet-detail-2">
                          <div class="span5">Worked on : </div>
                            <div class="span7"><%= title %></div>
                        </div>
                        <div class="timesheet-detail-3"></div>
                        <div class="workingtime"><%= total_hours %> hours <%= total_minutes %> minutes</div>
                       <div class="timesheet-time">from <%= start_time %> till <%= end_time %></div>
                        <div class="row-fluid timesheet-remark">
                          <div class="span5">Details:</div>
                          <% if(details == null) { %>
                                    <div class="span7">[No details]</div>
                       <% } else { %>
                           <div class="span7"><%= details %></div>
                         <% } %>


                        </div>
                        <div class="row-fluid timesheet-remark">
                          <div class="span5">Task:</div>
                          <% if(task == null) { %>
                                    <div class="span7">[No Task]</div>
                       <% } else { %>
                           <div class="span7"><%= task['name'] %></div>
                         <% } %>

                        </div>
                          <div class="row-fluid timesheet-remark">
                          <div class="span5">Remark:</div>
                          <% if(remarks == null) { %>
                                    <div class="span7">[No Remarks]</div>
                       <% } else { %>
                           <div class="span7"><%= remarks %></div>
                         <% } %>
                        </div>
                        <div class="timesheet-create">updated on <%= updated_at %></div>
                    </div>
                </div>
          </script>

<!-- Delete Event Popup -->
<div id="myModal-item-delete" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm delete the entry?</div>
    <div class="confirm-button">
      <form method="post" action="{{url('/dashboard/timesheet/entry/delete')}}">  <input type="hidden" name="entryId" id="entryId" value=  > <button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- End Delete Event Popup -->
@if(Session::has('status') and Session::has('message') )
@if(Session::has('status') == 'success')
<script>
$(document).ready( function() {
iosOverlay({
    text: "{{Session::get('message')}}",
    duration: 5e3,
    icon: tempurl+'assets/images/notifications/check.png'
  });

});
</script>
{{Session::forget('status'); Session::forget('message'); }}
@elseif(Session::has('status') == 'error')
<script>
$(document).ready( function() {
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
<!-- End Deete Event Popup-->
@stop
@section('endjs')
{{ HTML::script('assets/js/dashboard/moment.min.js') }}
{{ HTML::script('assets/js/dashboard/clndr.js') }}

<script>
$(document).ready(function() {
    var calendars = {};
    function weeksInMonth(month) 
    {
      return Math.floor((month.daysInMonth() + moment(month).startOf('month').weekday()) / 7);
    }
  $('#date').pickadate({
    formatSubmit: 'yyyy-mm-dd',
    });
  $('#eventDate').pickadate({
    formatSubmit: 'yyyy-mm-dd',
    });
});
</script>
{{ HTML::style('assets/css/dashboard/pickadate.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.date.css') }}
{{ HTML::style('assets/css/dashboard/pickadate.time.css') }}
{{ HTML::style('assets/css/dashboard/jcarousel.responsive.css') }}
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::script('assets/js/dashboard/legacy.js') }}
{{ HTML::script('assets/js/dashboard/picker.js') }}
{{ HTML::script('assets/js/dashboard/picker.date.js') }}
{{ HTML::script('assets/js/dashboard/picker.time.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/jquery/jquery.jcarousel.min.js') }}
{{ HTML::script('assets/js/jquery/jcarousel.responsive.js') }}
{{ HTML::script('assets/js/dashboard/timesheet.js') }}
 <script>
  $(document).on("click", "li", function() {

    if ($(this).hasClass('c_select')) {
    } else {
      var tempclass = $(this).attr("class");
      var finaldate = tempclass.split('day-')[1];
      $(this).siblings().removeClass('c_select');
      $(this).addClass('c_select');
      var newDate = moment(finaldate, "YYYY-MM-DD").format('D MMMM YYYY');
      $('#timesheet-detail-title').text('Entries showing for ' + newDate);
      var timesheetEntryList = new TimesheetEntryList([], {
        selectedDate: finaldate
      });
      var timesheetView = new TimesheetView({
        collection: timesheetEntryList
      });
      timesheetView.render();
    }
  });
  $(document).on("click", ".dontdelete", function() {

    $('#myModal-item-delete').modal('hide');
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

