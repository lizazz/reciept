@extends('adminlte::page')

@section('title', 'Error 404')

@section('content_header')
    <h1>Page not found</h1>
@stop

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 404</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Page not found.</h3>

            <p>
                @php
                    $default_error_message = "We could not find the page you were looking for. Meanwhile, you may return to dashboard or to the previous page.";
                @endphp

                {!! isset($exception)? ($exception->getMessage()? $exception->getMessage(): $default_error_message): $default_error_message !!}
            </p>

            <a class="btn btn-default" href="{{ route('adminDashboard') }}">Dashboard</a>
            <a class="btn btn-default" href="javascript:history.back()">Go Back</a>
        </div>
    </div>
@stop