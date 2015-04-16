@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.myMonthlyReport')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <div class="monthly_title">{{trans('92five.monthlyReportTitle')}} {{$name}} {{trans('92five.reportTitle2')}} {{App::make('date')}}</div>
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
            <h3>{{trans('92five.summary')}}</h3>
            <div class="report-summay-inner">
              <div class="task-worked">
                <div class="summary-detail-1">{{trans('92five.totalWorkingHours')}} : <strong>{{$data['totalTime']['hours']}}</strong>{{trans('92five.hours')}}<strong> {{$data['totalTime']['mins']}}</strong>{{trans('92five.minutes')}}</div>
                <div class="row-fluid">
                  <div class="span6">
                    <h4>{{trans('92five.taskWorkedOn')}}:</h4>
                    <ul class="task-worked-list">
                      @if(sizeof($data['tasks'] !== 0))
                      @foreach($data['tasks'] as $task)
                      <li> {{$task['name']}} - <span>{{$task['hours']}}</span>{{trans('92five.hours')}} <span> {{$task['mins']}}</span> {{trans('92five.minutes')}}</li>
                      @endforeach
                      @endif
                      @if($data['otherTasksTimeSpent'] != 0)
                      <li>{{trans('92five.others')}} - <span>{{$data['otherTasksTime']['hours']}}</span> {{trans('92five.hours')}}<span>{{$data['otherTasksTime']['mins']}}</span>{{trans('92five.minutes')}}</li>
                      @endif
                    </ul>
                  </div>
                  <div class="span6">
                    <h4>{{trans('92five.projectWorkedOn')}}</h4>
                    <ul class="task-worked-list">
                      @if(sizeof($data['projects'] != 0))
                      @foreach($data['projects'] as $project)
                      <li> {{$project['name']}} - <span>{{$project['hours']}}</span> {{trans('92five.hours')}} <span> {{$project['mins']}}</span> {{trans('92five.minutes')}}</li>
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
                <div class="span5">{{trans('92five.workedOn')}} : </div>
                <div class="span7">{{$entry['title']}}</div>
              </div>
              <div class="timesheet-detail-3"></div>
              <div class="workingtime">{{$entry['total_hours']}} {{trans('92five.hours')}} {{$entry['total_minutes']}} {{trans('92five.minutes')}}</div>
              <div class="timesheet-time">from {{date('g:ia', strtotime($entry['start_time']))}} till {{date('g:ia', strtotime($entry['end_time']))}}</div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">{{trans('92five.details')}}:</div>
                @if($entry['details'] == null)
                <div class="span7">[{{trans('92five.noDetails')}}]</div>
                @else
                <div class="span7">{{$entry['details']}}</div>
                @endif
              </div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">{{trans('92five.task')}}:</div>
                @if($entry['task_id'] == null)
                <div class="span7">[{{trans('92five.noTask')}}]</div>
                @else
                <div class="span7">{{$entry['task']['name']}}</div>
                @endif
              </div>
              <div class="row-fluid timesheet-remark">
                <div class="span5">{{trans('92five.remarks')}}:</div>
                @if($entry['details'] == null)
                <div class="span7">[{{trans('92five.noRemarks')}}]</div>
                @else
                <div class="span7">{{$entry['remarks']}}</div>
                @endif
              </div>
              <div class="timesheet-create">{{trans('92five.updatedOn')}} {{$entry['updated_at']}}</div>
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
