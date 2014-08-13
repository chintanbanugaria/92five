@extends('dashboard.default')
@section('head')
<title>92five app - My Weekly Report</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <!-- Time Sheet Detail -->
        <div class="work-report-title">Weekly Report for Sam Rafter generated on {{App::make('date')}}</div>
        <div class="timesheet-detail-main">
          <!-- Calender Slider -->
          <div class="jcarousel-wrapper">
            <div class="jcarousel">
              <ul>
                @foreach ($week as $day)
                <li class={{$day['class']}} id="">
                  <span class="c_day">{{$day['dayofweek']}}</span>
                  <span class="c_date">{{$day['day']}}</span>
                  <span class="c_month">{{$day['month']}}</span>
                  <span class="c_year">{{$day['year']}}</span>
                </li>
                @endforeach
              </ul>
            </div>
            <a href="#" class="jcarousel-control-prev">&lsaquo;</a>
            <a href="#" class="jcarousel-control-next">&rsaquo;</a>
            <p class="jcarousel-pagination"></p>
          </div>
        </div>
        <!-- Summery -->
        <div class="report-summay">
          <h3>Summary</h3>
          <div class="row-fluid report-summay-inner">
            <!-- Left -->
            <div class="span8 summary-left">
              <div class="summary-detail-1">Total Working Hours : <strong>{{$data['totalTime']['hours']}}</strong> hours<strong>{{$data['totalTime']['mins']}}</strong> minutes</div>
              <div class="task-worked">
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
              <div class="task-worked">
                <h4>Projects Worked On:</h4>
                <ul class="task-worked-list">
                  @if(sizeof($data['projects'] != 0))
                  @foreach($data['projects'] as $project)
                  <li> {{$project['name']}} - <span>{{$project['hours']}}</span> hours <span> {{$project['mins']}}</span> minutes</li>
                  @endforeach
                  @endif
                </ul>
              </div>
            </div>
            <!-- Right -->
            <div class="span4 summary-right"><img src="assets/images/reports-image-1.jpg" alt=""></div>
          </div>
        </div>
        @for( $i=0; $i < 7; $i++)
        <div class="report-summay">
          <h3>{{ new ExpressiveDate($dates[$i])}}</h3>
          @if(sizeof($data['entries'][$i]) == 0)
          <div class="row-fluid report-summay-inner">
            <div class="summary-detail-4">No Entries on this date has been recorded</div>
          </div>
          @endif
        </div>
        @if(sizeof($data['entries'][$i]) != 0)
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
{{ HTML::style('assets/css/dashboard/jcarousel.responsive.css') }}
{{ HTML::script('assets/js/jquery/jquery.jcarousel.min.js') }}
{{ HTML::script('assets/js/jquery/jcarousel.responsive.js') }}
@stop

