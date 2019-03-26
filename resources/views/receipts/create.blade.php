@extends('adminlte::page')

@section('title', 'Create Receipt')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/rangeslider/css/ion.rangeSlider.min.css') }}"/>
    @include( 'fileinput/stylesheet' )
@stop
@section('content_header')
    <h1>@lang('recruit.create_receipt')</h1>
@stop

@section('content')
    <div class="row">
        <div class="new-candidate col-md-12">
            @include('receipts.parts.form')
        </div>
    </div>
@stop