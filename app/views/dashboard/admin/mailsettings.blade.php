@extends('dashboard.default')
@section('head')
<title>92five app - Email Settings</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">Dashboard</a> / <a href="{{url('/dashboard/admin')}}">Admin</a> / Email Settings</h2>
        <div class="row-fluid proj_create">
          <form class="" action='' method='post'  data-validate="parsley" >
            <h3> Email Settings
            </h3>
            <div class="row-fluid span12 proj_create_detail">
              <div class="row-fluid">
                <!-- Left Part -->
                <div class="span6 add-proj-form form-horizontal">
                  <fieldset>
                    
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Host:</label>
                      <div class="controls">
                        <input id="host" name="host" type="text" value="{{$data['host']}}" placeholder="Host" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Port:</label>
                      <div class="controls">
                        <input id="port" name="port" type="text" value="{{$data['port']}}" placeholder="Port" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Sender's Email:
                      </label>
                      <div class="controls">
                        <input id="senderaddress" name="senderaddress" type="text" value="{{$data['senderaddress']}}" placeholder="Sender Address" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                  </fieldset>
                </div>
                <!-- Right Part -->
                <div class="span6  add-proj-form form-horizontal">
                  <fieldset>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Username:
                      </label>
                      <div class="controls">
                        <input id="username" name="username" type="text" value="{{$data['username']}}" placeholder="Username" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Password:
                      </label>
                      <div class="controls">
                        <input id="password" name="password" type="text" value="{{$data['password']}}" placeholder="Password" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Encryption:
                        <p class="help-block">(optional)</p>
                      </label>
                      <div class="controls">
                        <select name="encryption" id="encryption" class="projectlist" tabindex="1">
                      @if($data['encryption'] == '')
                      <option name="" value="null" selected="selected" title="">None</option>
                      <option name="" value="ssl" title="">SSL</option>
                      <option name="" value="tls" title="">TLS</option>
                      @elseif($data['encryption'] == 'ssl')
                      <option name="" value="null"  title="">None</option>
                      <option name="" value="ssl" selected="selected" title="">SSL</option>
                      <option name="" value="tls" title="">TLS</option>
                      @elseif($data['encryption'] == 'tls')
                      <option name="" value="null" title="">None</option>
                      <option name="" value="ssl" title="">SSL</option>
                      <option name="" value="tls" selected="selected" title="">TLS</option>
                      @endif
                    </select>
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">Sender's Name:
                      </label>
                      <div class="controls">
                        <input id="serndername" name="sendername" type="text" value="{{$data['sendername']}}" placeholder="Sender's Name" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="submit_button_main"><button class="submit">Submit</a></button></div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
<!-- sidebar -->
</section>
@stop
@section('endjs')
{{ HTML::style('assets/css/simplelogin/parsley.css') }}
{{ HTML::script('assets/js/simplelogin/parsley.js') }}
@stop

