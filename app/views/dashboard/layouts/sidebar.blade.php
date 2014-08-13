<a href="javascript:void(0)" class="sidebar_switch" title="Hide Sidebar">Sidebar switch</a>
<div class="sidebar">
  <div class="antiScroll">
    <div class="antiscroll-inner">
      <div class="antiscroll-content">
        <div class="sidebar_inner">
          <div class="login_info">
            <div class="user_info_data"> <img src="{{url('assets/images/profilepics/')}}/{{Sentry::getUser()->id}}.png" class="user_image" alt="">
              <h4>Hey {{Sentry::getUser()->first_name}}!</h4>
            <span>{{ App::make('date')}}</span> </div>
          </div>
          <div id="side_accordion" class="accordion">
            <div class="accordion-group none_accrodion">
              <div class="accordion-heading"> <a href="{{url('/dashboard')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/dashboard.png')}}" alt=""></span>Dashboard </a> </div>
            </div>
            
            <div class="accordion-group none_accrodion">
              <div class="accordion-heading"> <a href="{{url('/dashboard/projects')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/projects.png')}}" alt=""></span>Projects </a> </div>
            </div>
            <div class="accordion-group none_accrodion">
              <div class="accordion-heading"> <a href="{{url('/dashboard/tasks')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/task.png')}}" alt=""></span>Tasks </a> </div>
            </div>
            <div class="accordion-group none_accrodion">
              <div class="accordion-heading"> <a href="{{url('/dashboard/calendar')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/calendar.png')}}" alt=""></span>Calendar </a> </div>
            </div>
            <div class="accordion-group none_accrodion">
              <div class="accordion-heading"> <a href="{{url('/dashboard/timesheet')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/timesheet.png')}}" alt=""></span>Timesheet </a> </div>
            </div>
            <div class="accordion-group bdr_none1">
              <div class="accordion-heading none_accrodion"> <a href="{{url('/dashboard/mytodos')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/notes.png')}}" alt=""></span>My To-dos </a> </div>
            </div>
          </div>
          <div id="side_accordion" class="accordion">
            @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('admin')))
            <div class="accordion-group bdr_none1">
              <div class="accordion-heading none_accrodion"> <a href="{{url('/dashboard/admin')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/users.png')}}" alt=""></span>Admin </a> </div>
            </div>
            @endif
            <div class="accordion-group bdr_none1">
              <div class="accordion-heading none_accrodion"> <a href="{{url('/dashboard/roles')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/roles.png')}}" alt=""></span>Roles </a> </div>
            </div>
            <div class="accordion-group bdr_none1">
              <div class="accordion-heading none_accrodion"> <a href="{{url('/dashboard/reports')}}"> <span class="accrod_icon"><img src="{{asset('assets/images/dashboard/reports.png')}}" alt=""></span>Reports </a> </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>