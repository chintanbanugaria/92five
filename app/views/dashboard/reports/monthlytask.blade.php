@extends('dashboard.default')
@section('head')
<title>92five app - My Monthly Task Report</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <div class="monthly_title">MonthlyReport for {{$name}} generated on {{App::make('date')}} for the task {{$data['task']['name']}}</div>
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
              </div>
            </div>
          </div>
        </div>
        <div class="report-summay">
          <h3>Tasks</h3>
          <div class="row-fluid report-summay-inner monthly_tasks">
            <canvas id="weekChart" height="406" width="950" ></canvas>
            <!--<div class="summary-detail-4">No Entries on this date has been recorded</div>-->
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
{{ HTML::script('assets/js/dashboard/ChartNew.js') }}

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
<style>
      canvas{
         width: 100% !important;
        max-width: 975px;
        height: auto !important;
      }
    </style>
<script>
var lineChartData = {
  labels:{{$chartWeek}},
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
var myLine = new Chart(document.getElementById("weekChart").getContext("2d")).Bar(lineChartData, options);
myLine.reDraw();
</script>
@stop
