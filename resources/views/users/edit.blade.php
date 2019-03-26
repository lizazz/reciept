@extends('adminlte::page')

@section('title', 'Users')
@section('css')
    @include( 'fileinput/stylesheet' )
@stop
@section('content_header')
    <h1>@lang('lagarto.edit_user')</h1>
@stop

@section('content')
    <section class="panel">
        <div class="panel-body edit-user">
            <div class="row">
                <div class="col-md-12">
                    @include( 'users.parts.form' )
                </div>
            </div>
        </div>
    </section>
@stop