@extends('adminlte::page')

@section('title', 'Create Ingredient')
@section('css')
    @include( 'fileinput/stylesheet' )
@stop
@section('content_header')
    <h1>@lang('recruit.create_ingredient')</h1>
@stop

@section('content')
    <div class="row">
        <div class="new-candidate col-md-12">
            @include('ingredients.parts.form')
        </div>
    </div>
@stop