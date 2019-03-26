@extends('adminlte::page')

@section('title', 'Edit Receipt')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/rangeslider/css/ion.rangeSlider.min.css') }}"/>
    @include( 'fileinput/stylesheet' )
@stop
@section('content_header')
    <h1>@lang('recruit.edit_receipt')</h1>
@stop

@section('content')
    <div class="row">
        <div class="ed-candidate col-md-12">
            @include('receipts.parts.form')
        </div>
    </div>
@stop