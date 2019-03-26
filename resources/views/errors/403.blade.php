@extends('adminlte::page')

@section('title', 'Error 403')

@section('content_header')
    <h1>Forbidden</h1>
@stop

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 403</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Forbidden.</h3>

            <p>
                @php
                    $default_error_message = "Meanwhile, you may return to dashboard or to the previous page.";
                @endphp

                {!! isset($exception) ? ($exception->getMessage()? $exception->getMessage(): $default_error_message) : $default_error_message !!}
            </p>

            <a class="btn btn-default" href="{{ route('adminDashboard') }}">Dashboard</a>
            <a class="btn btn-default" href="javascript:history.back()">Go Back</a>
        </div>
    </div>
@stop