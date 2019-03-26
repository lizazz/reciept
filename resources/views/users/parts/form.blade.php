
@if( isset($user) )
    {{ Form::open(['url' => route('user.update', ['user' => $user->id]), 'method' => 'put']) }}
@else
    {{ Form::open(['url' => route('user.store'), 'method' => 'post']) }}
@endif
    <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
        {{ Form::label('name', __('lagarto.name') . '*') }}
        {{ Form::text('name', $user->name ?? null, $attributes = ['class' => 'form-control']) }}
    </div>
    <div class="form-group {{ $errors->has('email') ? ' has-error' : '' }} col-md-6">
        {{ Form::label('email', __('lagarto.email') . '*') }}
        {{ Form::email('email', $user->email ?? null, $attributes = ['class' => 'form-control']) }}
    </div>
    <div class="form-group {{ $errors->has('password') ? ' has-error' : '' }} col-md-6" id="password">
        {{ Form::label('password', __('lagarto.password') . '*') }}
        {{ Form::password('password', $attributes = ['class' => 'form-control']) }}
    </div>
    <div class="form-group {{ $errors->has('confirm') ? ' has-error' : '' }} col-md-6"
         id="confirm_password">
        {{ Form::label('confirm', __('lagarto.confirm') . '*') }}
        {{ Form::password('confirm', $attributes = ['class' => 'form-control']) }}
    </div>
    <div class="form-group col-md-12">
        {{ Form::submit(__('lagarto.save'), $attributes = ['class' => 'btn btn-info']) }}
        <a href="{{ route('user.index') }}" class="btn btn-default btn-indent-left">
            @lang('lagarto.cancel')
        </a>
    </div>
{{ Form::close() }}

@section('js')
    @include( 'fileinput.jscript' )

    <script>
        function hidePassword(roleTech) {
            var visibility = 'block';

            $('#password').css('display', visibility);
            $('#confirm_password').css('display', visibility);
        }
    </script>
@stop
