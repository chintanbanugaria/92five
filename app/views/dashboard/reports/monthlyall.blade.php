@extends('dashboard.default')
@section('head')
<title>92five app - My Monthly Report</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <div class="monthly_title">Monthly Report for {{$name}} generated on {{App::make('date')}}</div>
        <div class="row-fluid monthly_detail_1">
          <div class="span5 report-summay monthly_calender cal2">
            <script type="text/template" id="template-calendar">
              <h3><%= month %>  <%= year %></h3>
            <div class="report-summay-inner">
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
                    <td ><%= days[d].day %></td>
                    <% } %>
                  </tr>
                  <% } %>
                </table>
              </div>
            </div>
            </script>
          </div>
          <div class="span7 report-summay monthly_detail_2">
            <h3>Summary</h3>
            <div class="report-summay-inner">
              <div class="task-worked">
                <div class="summary-detail-1">Total Working Hours : <strong>{{$data['totalTime']['hours']}}</strong> hours<strong> {{$data['totalTime']['mins']}}</strong> minutes</div>
                <div class="row-fluid">
                  <div class="span6">
                    <h4>Task Worked On:</h4>
                    <ul class="task-worked-list">
                      @if(sizeof($data['tasks'] !== 0))
                      @foreach($data['tasks'] as $task)
                      <li> {{$task['name']}} - <span>{{$task['hours']}}</span> hours <span> {{$task['mins']}}</span> minutes</li>
                      @endforeach
                      @endif
                      @if($data['otherTasksTimeSpent'] != 0)
                      <li>Others - <span>{{$data['otherTasksTime']['hours']}}</span> hours<span> {{$data['otherTasksTime']['mins']}}</span> minutes</li>
                      @endif
                    </ul>
                  </div>
                  <div class="span6">
                    <h4>Projects Worked On</h4>
                    <ul class="task-worked-list">
                      @if(sizeof($data['projects'] != 0))
                      @foreach($data['projects'] as $project)
                      <li> {{$project['name']}} - <span>{{$project['hours']}}</span> hours <span> {{$project['mins']}}</span> minutes</li>
                      @endforeach
                      @endif
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        @for( $i=0; $i < $totalDays; $i++)
        @if(sizeof($data['entries'][$i]) != 0)
        <div class="report-summay">
          <h3>{{ new ExpressiveDate($dates[$i])}}</h3>
        </div>
        <div class="row-fluid timesheet-detail" id="timesheet-detail">
          @foreach($data['entries'][$i] as $entry)
          <div class="">
            <div class="timesheet-box">
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
                @if($entry['task_id'] == null)
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
        </div>
        @endif
        @endfor
      </div>
    </div>
  </div>
</div>
@stop
@section('endjs')
{{ HTML::script('assets/js/dashboard/moment.min.js') }}
{{ HTML::script('assets/js/dashboard/clndr.js') }}
<script>
var calendars = {};
var tempmonth = '{{$month}}';
var tempyear = {{$year}};
$(document).ready(function() {

  calendars.clndr2 = $('.cal2').clndr({
    template: $('#template-calendar').html(),
    daysOfTheWeek: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
    showAdjacentMonths: false,
  });
  calendars.clndr2.setMonth(tempmonth);
  calendars.clndr2.setYear(tempyear);
});
</script>
@stop
