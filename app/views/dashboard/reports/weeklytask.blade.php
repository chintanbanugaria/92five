@extends('dashboard.default')
@section('head')
<title>92five app - My Weekly Project Report</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <!-- Time Sheet Detail -->
        <div class="work-report-title">Weekly Report for {{Sentry::getUser()->first_name}} {{Sentry::getUser()->last_name}} generated on {{App::make('date')}} for the task {{$data['task']['name']}}</div>
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
        <div class="report-summay">
          <h3>Summary</h3>
          <div class="row-fluid report-summay-inner">
            <!-- Left -->
            <div class="span6 summary-left">
              <div class="summary-detail-1">Total Hours spent</div>
              <div class="summary-detail-1"><span class="summary-detail-5">{{$data['totalTime']['hours']}} </span>hours <span class="summary-detail-5"> {{$data['totalTime']['mins']}} </span>minutes</div>
            </div>
            <!-- Right -->
            <div class="span6 summary-right"><canvas id="canvas" height="306" width="408"></canvas></div>
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
{{ HTML::script('assets/js/dashboard/ChartNew.js') }}
<style>
      canvas{
      }
    </style>
<script>
var lineChartData = {
  labels: {{$chartWeek}},
  datasets: [{
      fillColor: "rgba(52, 152, 219,1.0)",
      strokeColor: "rgba(220,220,220,1)",
      pointColor: "rgba(41, 128, 185,1.0)",
      pointStrokeColor: "#fff",
      data: {{$data['chartData']}}
    }
  ],
}
var options = {
  scaleFontFamily: "'Lato_reg'",
  scaleFontColor: "#000",
  scaleOverride: true,
  scaleSteps: 6,
  scaleStepWidth: 2,
  scaleStartValue: null,
  scaleShowLabels: true,
  annotateDisplay: true,
  yAxisLabel: "Hours",
  yAxisFontSize: 12,
}
var myLine = new Chart(document.getElementById("canvas").getContext("2d")).Line(lineChartData, options);
  </script>

  @stop

