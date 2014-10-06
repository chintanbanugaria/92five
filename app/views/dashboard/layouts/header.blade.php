<div class="navbar navbar-inverse navbar-fixed-top">
  <div class="navbar-inner">
<a class="brand" href="{{url('/dashboard')}}"><img src="{{asset('assets/images/dashboard/logo.png')}}" alt=""></a>
    <div class="container">

      <button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse"> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
      <div class="nav-collapse collapse">
        <ul class="nav top_menu_1 pull-right">
          <li class="search_box_t">
            <form class="navbar-search top_search search_box_t" action="">
        <!--      <input type="text" class="search-query span2" placeholder="Search"> -->
              <div class="icon-search"></div>
            </form>
          </li>
        <!--  <li><a href="#"><img src="{{asset('images/dashboard/messages.png')}}" alt="" class="top_menu_icon" />Messages</a></li>
           @if(Sentry::getUser()->inGroup(Sentry::getGroupProvider()->findByName('admin')))
          <li><a href="{{url('/dashboard/admin/settings')}}"><img src="{{asset('images/dashboard/settings.png')}}" alt="" class="top_menu_icon" />Settings</a></li> 
          @endif-->
          <li class="welcome_text"><span>{{trans('92five.header.menu')}}:</span> <a href="{{url('/dashboard/me')}}">{{Sentry::getUser()->first_name}} {{Sentry::getUser()->last_name}}</a></li>
          <li><a href="{{URL::to('/logout')}}" style="font-size:15px;"><img src="{{asset('assets/images/dashboard/logout.png')}}" alt="" class="top_menu_icon" />{{trans('92five.logout')}}</a></li>
        </ul>
      </div>
    </div>
  </div>
</div>