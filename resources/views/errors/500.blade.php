@extends('adminlte::page')

@section('title', 'Error 500')

@section('content_header')
    <h1>Something went wrong</h1>
@stop

@section('content')
    <div class="error-page">
        <h2 class="headline text-yellow"> 500</h2>

        <div class="error-content">
            <h3><i class="fa fa-warning text-yellow"></i> Oops! Something went wrong.</h3>

            <p>
                @php
                    $default_error_message = "We will work on fixing that right away. Meanwhile, you may return to dashboard or to the previous page.";
                @endphp

                {!! isset($exception) ? ($exception->getMessage()? $exception->getMessage(): $default_error_message) : $default_error_message !!}
            </p>

            <a class="btn btn-default" href="{{ route('adminDashboard') }}">Dashboard</a>
            <a class="btn btn-default" href="javascript:history.back()">Go Back</a>
        </div>
    </div>
@stop