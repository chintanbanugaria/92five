@extends('dashboard.default')
@section('head')
<title>92five app - Calendar</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / Calendar</h2>
        <div class="add_project_main">
          <a data-toggle="modal" href="{{url('/dashboard/calendar/event/createdbyme')}}" class="add_project pull-right"> Events Created by Me</a>
          <a data-toggle="modal" href="#myModal" class="add_project add-last"> + Add Event</a>
        </div>
        <!-- Calendar Detail -->
        <div class="row-fluid cal_detail">
          <!-- Cal Left -->
          <div class="span5 cal_left">
            <div class="row-fluid">
              <div class="cal_date" id="cal_date">{{$todaysDate->format('j')}}</div>
              <div class="cal_month" id="cal_month">{{$todaysDate->format('F')}}</div>
              <div class="cal_month" style="margin:0px;" id="cal_year">{{$todaysDate->format('Y')}}</div>
            </div>
            <div class="time_listing" id="time_listing">
              @if(sizeof($events) != 0)
              @foreach($events as $event)
              <div class="row-fluid">
                <div class="span5 time_listing_1">{{date('g:ia', strtotime($event['start_time']))}} - {{date('g:ia', strtotime($event['end_time']))}} </div>
                <div class="span7 time_listing_1"><a data-toggle="modal" class="cal_event_title"  data-placement="right"  eventid={{$event['id']}} href="#myModal4">{{$event['title']}}</a></div>
              </div>
              <div class="calender-viewevent hide">
                @if($event['editdelete'] == 'yes')
                <div class="p-icon-inner"><a class="p-icon-1" title="Edit Event" href="{{url('/dashboard/calendar/event/edit',array($event['id']))}}"><img alt="" src="{{asset('assets/images/dashboard/p-edit.png')}}"></a><a class="p-icon-1 delevent" title="Delete Event" eventid={{$event['id']}} href="#"><img alt="" class="delevent" eventid={{$event['id']}} src="{{asset('assets/images/dashboard/p-delete.png')}}"></a></div>
                @endif
                <div class="viewevent-detail-inner">
                  <!-- Left -->
                  <div class="viewevent-left">
                    <div class="viewevent-detail-1">Category:<span class="viewevent-note"> {{$event['category']}}</span></div>
                    <div class="viewevent-detail-1">Note: <span class="viewevent-note"> {{$event['notes']}}</span></div>
                    <div class="viewevent-detail-1">Location: <span class="viewevent-note"> {{$event['location']}}</span></div>
                  </div>
                  <!-- Right -->
                  <div class="viewevent-right">
                    <div class="viewevent-asignee">
                      <label>People:</label>
                      <div class="viewevent-asignee-right">
                        @foreach($event['users'] as $user)
                        <div class="viewevent-detail-3">{{$user['first_name']}} {{$user['last_name']}}</div>
                        @endforeach
                      </div>
                    </div>
                  </div>
                </div>
              </div>
              @endforeach
              @else
              <div class="row-fluid">
                <div class="span12 time_listing_1"> [ Nothing Scheduled !]</div>
              </div>
              @endif
            </div>
          </div>
          <!-- Cal Right -->
          <div class="span7 cal_right cal2">
            <script type="text/template" id="template-calendar">
              <div class="cal_year"><%= year %></div>
            <div class="calender_sec">
                <div class="cal_detail_2">
                  <div class="cal_next clndr-previous-button"><img src="{{asset('assets/images/dashboard/cal_l.png')}}" alt=""></div>
                <div class="cal_month_2"><p><%= month %></p></div>
                <div class="cal_prav clndr-next-button"><img src="{{asset('assets/images/dashboard/cal_r.png')}}" alt=""></div>
              </div>
              <div class="cal_detail_3">
                  <table width="100%" border="0" cellpadding="0" cellspacing="0">
                  <tr>
                    <% _.each(daysOfTheWeek, function(day) { %>
                    <td ><%= day %></td>
                    <% }); %>
                  </tr>
                  <% for(var i = 0; i < numberOfRows; i++){ %>
                  <tr>
                    <% for(var j = 0; j < 7; j++){ %>
                    <% var d = j + i * 7; %>
                    <td class='<%= days[d].classes %>'><div class='day-contents'><%= days[d].day %>
                    </div></td>
                    <% } %>
                  </tr>
                  <% } %>
                </table>
              </div>
            </div>
            </script>
          </div> 
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Add Event Popup -->
<div id="myModal" class="modal hide fade cal_light_box" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <form class="form-horizontal" action='calendar/add' method='post' id="addevent" data-validate="parsley">
    <div class="modal-header form_modal_header">
      <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
      <h3 id="myModalLabel">
      <input type="text" name="title" id="title" class="popup_title_input" placeholder="Title" data-required="true"  data-show-errors="false" >
      </h3>
    </div>
    <div class="modal-body">
      <div class="popup_event">
        <div class="add-proj-form">
          <fieldset>
            <div class="row-fluid">
              <div class="control-group">
                <div class="row-fluid">
                  <input id="date" name="date" type="text" class="span6 pull-left" placeholder="When" data-required="true"  data-show-errors="true">
                  <input id="starttime" name="starttime" type="text" class="span3 pull-left" placeholder="From" data-required="true"  data-show-errors="true">
                  <input id="endtime" name="endtime" type="text" class="span3 pull-left" placeholder="Till" data-required="true"  data-show-errors="true">
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="passwordinput">Category:</label>
                <div class="controls">
                  <div class="task_select">
                    <select name="category" id="category" tabindex="1" style="width:270px;" data-required="true"  data-show-errors="false">
                      <option name="" value="" selected="selected" title="">Select Category</option>
                      <option  name="" value="Meeting - General" title="">Meeting - General</option>
                      <option  name="" value="Meeting - Project" title="">Meeting - Project</option>
                      <option  name="" value="Meeting - Task" title="">Meeting - Task</option>
                      <option  name="" value="Deliverer" title="">Deliverer</option>
                      <option  name="" value="Client" title="">Client</option>
                      <option  name="" value="Others" title="">Others</option>
                    </select>
                  </div>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="passwordinput">Note:</label>
                <div class="controls">
                  <textarea  name="note" id="note" class="add-proj-form-t" placeholder="Note"></textarea>
                </div>
              </div>
              <div class="control-group">
                <label class="control-label" for="passwordinput">People:<span class="tooltipster-icon" title="To add the people start typing the name and select the appropriate user from the list. Please note that only those name will appear in list who are registered in the app. Please add your name as well if you are one of them.">(?)</span></label>
                <div class="controls">
                  <input id="plugin" name="passwordinput" type="text" placeholder="Add Name">
                </div>
                <div id="selected">
                  <ul id="list">
                  </ul>
                  <input style="display: none;" name="tagsinput" id="tagsinput" class="tagsinput" placeholder="Add Name" value=""/>
                  <p></p>
                </div>
              </div>
              <div class="advanced_link"><a href="#" id="adv">Advanced</a></div>
            </div>
            <div id="advanced-inputs">
              <div class="row-fluid event_form_data">
                <div class="control-group">
                  <label class="control-label" for="passwordinput">Location:</label>
                  <div class="controls">
                    <input id="location" name="location" type="text" placeholder="Location">
                  </div>
                </div>
              </div>
            </div>
          <button class="submit pull-right">Submit</a></button>
        </fieldset>
      </div>
    </div>
  </div>
</form>
</div>
<!-- End Add Event Popup -->
<!-- Delete Event Popup -->
<div id="myModal-item-delete" class="modal cal_light_box hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Really ?</h3>
  </div>
  <div class="modal-body">
    <div class="confirm-delete">Confirm delete the event?</div>
    <div class="confirm-button">
      <form method="post" action="calendar/event/delete">  <input type="hidden" name="deleteEventId" id="deleteEventId" value=  > <button class="submit">Yes please.</a></button></form>
    <button class="submit dontdelete" id="dontdelete" >No Thanks.</a></button></div>
  </div>
</div>
<!-- End Delete Event Popup-->

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
{{Session::forget('status'); Session::forget('message');}}
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
 $(document).on("click", ".dontdelete", function() {

   $('#myModal-item-delete').modal('hide');
 });
 $("#addevent").submit(function(e) {
   if ($("#tagsinput").val() == '') {
     alert('Atleast add one Collaborator');
     e.preventDefault();
   }
$('.tooltipster-icon').tooltipster();
 });
</script>
{{ HTML::script('assets/js/dashboard/moment.min.js') }}
{{ HTML::script('assets/js/dashboard/clndr.js') }}
<script>
var calendars = {};
$(document).ready(function() {

  calendars.clndr2 = $('.cal2').clndr({
    template: $('#template-calendar').html(),
    daysOfTheWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    events: {{$eventDates}},
    clickEvents: {
      click: function(e) {
        // console.log($(e.element).hasClass("event"));
        if ($(e.element).hasClass("event")) 
        {
          var tempclass = $(e.element).attr("class");
          var finaldate = tempclass.split('day-')[1];
          var eventsModel = new EventsList([], {
            selectedDate: finaldate
          });
          var eventsView = new EventsListView({
            collection: eventsModel
          });
          eventsView.render();

        } else 
        {

          //User has clicked a day in which no event is there
          // Hence do nothing
        }
      }
    }
  });

  $("#advanced-inputs").hide();
  $('#adv').click(function() {
    $("#advanced-inputs").slideToggle();
  });
  $('#date').pickadate({
    formatSubmit: 'yyyy-mm-dd'
  });
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
{{ HTML::script('assets/js/dashboard/picker.time.js') }}
{{ HTML::script('assets/js/dashboard/backbone.autocomplete.js') }}
{{ HTML::script('assets/js/dashboard/userlist.js') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
{{ HTML::script('assets/js/dashboard/calendar.js') }}
  <script>
$(function() {
  var eventModel = new EventModel();
  var eventview = new EventView({
    model: eventModel
  });
});
</script>
<script>
var from_$input = $('#starttime').pickatime({
  min: [7, 00],
  max: [21, 0],
  formatSubmit: 'HH:i',
  formatLabel: function(timeObject) {
    return '<b>h</b>:i <!i>a</!i>';
  }
});
var from_picker = from_$input.pickatime('picker');
var to_$input = $('#endtime').pickatime({
  min: [7, 00],
  max: [21, 0],
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

