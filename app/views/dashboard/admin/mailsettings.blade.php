@extends('dashboard.default')
@section('head')
<title>92five app - {{trans('92five.emailSettings')}}</title>
@stop
@section('content')
<div id="contentwrapper">
  <div class="main_content">
    <div class="row-fluid">
      <div class="span12 project_detail">
        <h2><a href="{{url('/dashboard')}}">{{trans('92five.Dashboard')}}</a> / <a href="{{url('/dashboard/admin')}}">{{trans('92five.Admin')}}</a> / Email Settings</h2>
        <div class="row-fluid proj_create">
          <form class="" action='' method='post'  data-validate="parsley" >
            <h3>{{trans('92five.emailSettings')}}
            </h3>
            <div class="row-fluid span12 proj_create_detail">
              <div class="row-fluid">
                <!-- Left Part -->
                <div class="span6 add-proj-form form-horizontal">
                  <fieldset>
                    
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">{{trans('92five.host')}}:</label>
                      <div class="controls">
                        <input id="host" name="host" type="text" value="{{$data['host']}}" placeholder="Host" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">{{trans('92five.port')}}:</label>
                      <div class="controls">
                        <input id="port" name="port" type="text" value="{{$data['port']}}" placeholder="Port" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">{{trans('92five.sendersEmail')}}:
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
                      <label class="control-label" for="passwordinput">{{trans('92five.userName')}}:
                      </label>
                      <div class="controls">
                        <input id="username" name="username" type="text" value="{{$data['username']}}" placeholder="Username" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">{{trans('92five.password')}}:
                      </label>
                      <div class="controls">
                        <input id="password" name="password" type="password" value="{{$data['password']}}" placeholder="Password" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                    <div class="control-group">
                      <label class="control-label" for="passwordinput">{{trans('92five.encryption')}}:
                        <p class="help-block">({{trans('92five.optional')}})</p>
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
                      <label class="control-label" for="passwordinput">{{trans('92five.sendersName')}}:
                      </label>
                      <div class="controls">
                        <input id="serndername" name="sendername" type="text" value="{{$data['sendername']}}" placeholder="Sender's Name" data-required="true" data-show-errors="true">
                      </div>
                    </div>
                  </fieldset>
                </div>
              </div>
              <div class="submit_button_main"><button class="submit">{{trans('92five.submit')}}</a></button></div>
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

