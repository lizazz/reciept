@extends('adminlte::page')

@section('title', 'My receipts')

@section('content_header')
    <h1>@lang('recruit.my_receipts')</h1>
@stop

@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                @if(Auth::id())
                <div class="box-header with-border">
                    <a href="{{ route('receipts.create') }}" class="btn btn-info" role="button">@lang('recruit.create_receipt')</a>
                </div>
                @endif
                <div class="box-body">
                    <table id="reciept-table" class="table table-bordered table-striped dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>@lang('recruit.receipt')</th>
                            <th>@lang('lagarto.description')</th>
                            @if(Auth::id())<th>@lang('recruit.actions')</th>@endif
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
            $('#reciept-table').DataTable({
                serverSide  : true,
                processing  : true,
                scrollX     : true,
                ajax        : '{!! route('receipts.data') !!}',
                pageLength  : 25,
                order       : [[ 0, "desc" ]],
                language    : {
                    emptyTable: "No receipts available."
                },
                columns     : [
                    { data: 'name', name: 'receipts.name' },
                    { data: 'description', name: 'receipts.description' },
                    @if(Auth::check())
                    { data: 'action', orderable: false, searchable: false }
                    @endif
                ],
                columnDefs  : [
                    { targets: '_all', defaultContent: '-'}
                ]
            })
                .on('click', '.btn-delete[data-remote]', function (e) { //Same function exists in show.blade file
                    e.preventDefault();

                    swal({
                        title       : 'Are you sure?',
                        text        : 'Receipt will be permanently deleted!',
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
                                        text    : 'Receipt has not been deleted!',
                                        icon    : 'error',
                                    }).then((value) => {});
                                }
                            }).always(function (data) {
                                $('#reciept-table').DataTable().draw(false);
                            });
                        } else {
                            return false;
                        }
                    });
                });
        });
    </script>
@stop