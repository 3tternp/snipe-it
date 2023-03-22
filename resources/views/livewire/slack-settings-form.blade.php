{{-- Page title --}}
@section('title')
{{ trans('admin/settings/general.webhook_title') }}
@parent
@stop

@section('header_right')
<a href="{{ route('settings.index') }}" class="btn btn-primary"> {{ trans('general.back') }}</a>
@stop


{{-- Page content --}}
@section('content')

<div><!-- livewire div - do not remove -->
    <form class="form-horizontal" role="form" wire:submit.prevent="submit">
        {{csrf_field()}}

        <div class="row">

            <div class="col-sm-10 col-sm-offset-1 col-md-8 col-md-offset-2">

                <div class="panel box box-default">

                    <div class="box-header with-border">
                        <h2 class="box-title">
                            <i class="{{$webhook_icon}}"></i> {{ trans('admin/settings/general.webhook', ['app' => $webhook_name] ) }}
                        </h2>
                    </div>

                <div class="box-body">
                    @if($webhook_selected != 'general')
                    <div class="col-md-12">
                            <p>
                                {!! trans('admin/settings/general.webhook_integration_help',array('webhook_link' => $webhook_link, 'app' => $webhook_name)) !!}
                            </p>
                        <br>
                    </div>
                    @endif

                    <div class="col-md-12" style="border-top: 0px;">

                        @if(session()->has('success'))
                            <div class="alert alert-success fade in">
                                {{session('success')}}
                            </div>
                        @endif
                        @if(session()->has('error'))
                            <div class="alert alert-danger fade in">
                                {{session('error')}}
                            </div>
                        @endif

                        <div class="form-group">
                            <div class="col-md-2">
                                <label for="webhook_selected">
                                    {{ trans('general.integration_option') }}
                                </label>
                            </div>
                            <div class="col-md-9 required">
                                <select wire:model="webhook_selected" aria-label="webhook_selected" class="form-control"{{ app('demo_mode') ? ' disabled' : ''}}>
                                    <option value="slack">{{ trans('admin/settings/general.slack') }}</option>
                                    <option value="general">{{ trans('admin/settings/general.general_webhook') }}</option>
                                </select>
                            </div>
                        </div>

                        @if (app('demo_mode'))
                            @include('partials.forms.demo-mode')
                        @endif

                        <!--Webhook endpoint-->
                        <div class="form-group{{ $errors->has('webhook_endpoint') ? ' error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('webhook_endpoint', trans('admin/settings/general.webhook_endpoint',['app' => $webhook_name ])) }}
                            </div>
                            <div class="col-md-9 required">
                                    <input type="text" wire:model="webhook_endpoint" class="form-control" placeholder="{{$webhook_placeholder}}" value="{{old('webhook_endpoint', $webhook_endpoint)}}"{{ app('demo_mode') ? ' disabled' : ''}}>
                                {!! $errors->first('webhook_endpoint', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        @if (app('demo_mode'))
                            @include('partials.forms.demo-mode')
                        @endif


                        <!-- Webhook channel -->
                        <div class="form-group{{ $errors->has('webhook_channel') ? ' error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('webhook_channel', trans('admin/settings/general.webhook_channel',['app' => $webhook_name ])) }}
                            </div>
                            <div class="col-md-9 required">
                                    <input type="text" wire:model="webhook_channel" class="form-control" placeholder="#IT-Ops" value="{{ old('webhook_channel', $webhook_channel) }}"{{ app('demo_mode') ? ' disabled' : ''}}>

                                {!! $errors->first('webhook_channel', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div>
                        </div>

                        @if (!app('demo_mode'))
                            @include('partials.forms.demo-mode')
                        @endif

                        <!-- Webhook botname -->
                        <div class="form-group{{ $errors->has('webhook_botname') ? ' error' : '' }}">
                            <div class="col-md-2">
                                {{ Form::label('webhook_botname', trans('admin/settings/general.webhook_botname',['app' => $webhook_name ])) }}
                            </div>
                            <div class="col-md-9">
                                    <input type="text" wire:model="webhook_botname" class='form-control' placeholder="Snipe-Bot" {{ old('webhook_botname', $webhook_botname)}}{{ app('demo_mode') ? ' disabled' : ''}}>
                                {!! $errors->first('webhook_botname', '<span class="alert-msg" aria-hidden="true">:message</span>') !!}
                            </div><!--col-md-10-->
                        </div>

                        @if (app('demo_mode'))
                            @include('partials.forms.demo-mode')
                        @endif

                        <!--Webhook Integration Test-->
                        @if($webhook_selected == 'slack')
                            @if($webhook_endpoint != null && $webhook_channel != null)
                                <div class="form-group">
                                    <div class="col-md-offset-2 col-md-9">
                                        <a href="#" wire:click.prevent="testWebhook"
                                           class="btn btn-default btn-sm pull-left">
                                            <i class="{{$webhook_icon}}" aria-hidden="true"></i>
                                                {!! trans('admin/settings/general.webhook_test',['app' => ucwords($webhook_selected) ]) !!}
                                        </a>
                                        <div wire:loading>
                                            <span style="padding-left: 5px; font-size: 20px">
                                                <i class="fas fa-spinner fa-spin" aria-hidden="true"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endif
                    </div><!-- /.col-md-12 -->
               </div><!-- /.box-body -->

                <div class="box-footer">
                    <div class="text-right col-md-12">
                        
                        <button type="reset" wire:click.prevent="clearSettings" class="col-md-2 text-left btn btn-danger pull-left">{{ trans('general.clear_and_save') }}</button>

                        <a class="btn btn-link pull-left" href="{{ route('settings.index') }}">{{ trans('button.cancel') }}</a>


                        <button type="submit" {{$isDisabled}} class="btn btn-primary"{{ app('demo_mode') ? ' disabled' : ''}}>
                        <i class="fas fa-check icon-white" aria-hidden="true"></i> {{ $save_button }}</button>

                    </div> <!-- /.col-md-12 -->
                </div><!--box-footer-->

           </div> <!-- /.box -->
       </div> <!-- /.col-md-8-->
    </div> <!-- /.row -->
</form>
</div>  <!-- /livewire div -->


