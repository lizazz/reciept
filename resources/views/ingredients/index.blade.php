@extends('adminlte::page')

@section('title', 'Ingedients')

@section('content_header')
    <h1>@lang('recruit.ingedients')</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                @if(Auth::check())
                    <div class="box-header with-border">
                        <a href="{{ route('ingredients.create') }}" class="btn btn-info" role="button">@lang('recruit.create_ingredient')</a>
                    </div>
                @endif
                <div class="box-body">
                    <table id="ingredient-table" class="table table-bordered table-striped dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>@lang('recruit.name')</th>
                            @if(Auth::check())<th>@lang('recruit.actions')</th>@endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop
@section('js')
    <script>
        $(function () {
            $('#ingredient-table').DataTable({
                serverSide  : true,
                processing  : true,
                scrollX     : true,
                ajax        : '{!! route('ingredients.data') !!}',
                pageLength  : 25,
                order       : [[ 0, "desc" ]],
                language    : {
                    emptyTable: "No ingredients available."
                },
                columns     : [
                    { data: 'name', name: 'ingredients.name' },
                    {!! (Auth::check()) ?
                        "{ data: 'action', orderable: false, searchable: false }" : null !!}
                ],
                columnDefs  : [
                    { targets: '_all', defaultContent: '-'}
                ]
            })
                .on('click', '.btn-delete[data-remote]', function (e) { //Same function exists in show.blade file
                    e.preventDefault();

                    swal({
                        title       : 'Are you sure?',
                        text        : 'ingredient will be permanently deleted!',
                        icon        : 'warning',
                        buttons     : true,
                        dangerMode  : true,
                    }).then((willDelete) => {
                        if (willDelete) {
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $.ajax({
                                type    : 'DELETE',
                                data    : { method: '_DELETE', submit: true },
                                dataType: 'json',
                                url     : $(this).data('remote'),
                                success : function (response) {
                                    swal({
                                        title   : response.success === 'error' ? 'Error!' : 'Successfully!',
                                        text    : response.message,
                                        icon    : response.success === 'error' ? 'error' : 'success',
                                    }).then((value) => {});
                                },
                                error   : function (err) {
                                    swal({
                                        title   : 'Error!',
                                        text    : 'Ingredient has not been deleted!',
                                        icon    : 'error',
                                    }).then((value) => {});
                                }
                            }).always(function (data) {
                                $('#ingredient-table').DataTable().draw(false);
                            });
                        } else {
                            return false;
                        }
                    });
                });
        });
    </script>
@stop