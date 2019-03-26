@extends('adminlte::page')

@section('title', 'Edit Candidates')
@section('css')
    <link rel="stylesheet" href="{{ asset('js/rangeslider/css/ion.rangeSlider.min.css') }}"/>
    @include( 'fileinput/stylesheet' )
@stop
@section('content_header')
    <h1>@lang('recruit.edit_ingredient')</h1>
@stop
@section('content')
    <div class="row">
        <div class="ed-candidate col-md-12">
            @include('ingredients.parts.form')
        </div>
    </div>
@stop