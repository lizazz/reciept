@extends('adminlte::login')
@section('css')
    <style>
        button {
            visibility: hidden;
        }
    </style>
@stop
@section('body')

    <div class="login-box">
        <div class="login-logo">
            <a href="{{ url(config('adminlte.dashboard_url', 'home')) }}">{!! config('adminlte.logo', '<b>Admin</b>LTE') !!}</a>
        </div>
        <!-- /.login-logo -->
        <div class="login-box-body">
            @include('flash::message')
        </div>
        <!-- /.login-box-body -->
    </div><!-- /.login-box -->
@stop
