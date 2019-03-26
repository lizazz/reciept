@extends( 'adminlte::page' )

@section( 'title', 'Users' )
@section( 'css' )
    <link href="{{ asset('css/candidate.css') }}" media="all" rel="stylesheet" type="text/css">
@stop
@section( 'content_header' )
    <h1>Users</h1>
@stop

@section( 'content' )
    <div class="row">
        <div class="col-md-12">
            <div class="box box-primary">
                @if( Auth::check() )
                    <div class="box-header with-border">
                        <a href="{{ route('user.create') }}" class="btn btn-info" role="button">Create User</a>
                    </div>
                @endif
                <div class="box-body">
                    <table id="users-table" class="table table-bordered table-striped dataTable" style="width: 100%">
                        <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            @if( Auth::check() )
                                <th>Action</th>
                            @endif
                        </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section( 'js' )
    <script>
        $(function () {
            $('#users-table').DataTable({
                serverSide  : true,
                processing  : true,
                scrollX     : true,
                ajax        : '{!! route('users.data') !!}',
                pageLength  : 25,
                order       : [[ 0, "desc" ], [ 1, "asc" ]],
                language    : {
                    emptyTable: "No users available."
                },
                columns     : [
                    { data: 'name', name: 'users.name' },
                    { data: 'email' },
                    {!! (Auth::check()) ? "
                    { data: 'action', orderable: false, searchable: false }
                    " : null !!}
                ],
                columnDefs  : [
                    { targets: '_all', defaultContent: '-'}
                ]
            })
            .on('click', '.btn-delete[data-remote]', function (e) {
                e.preventDefault();

                swal({
                    title       : 'Are you sure?',
                    text        : 'User will be permanently deleted!',
                    icon        : 'warning',
                    buttons     : true,
                    dangerMode  : true,
                }).then((willDelete) => {
                    if (willDelete) {
                        $.ajaxSetup({
                            headers : {
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
                                }).then((value) => {window.location.reload()});
                            },
                            error   : function (err) {
                                swal({
                                    title   : 'Error!',
                                    text    : 'User has not been deleted!',
                                    icon    : 'error',
                                }).then((value) => {});
                            }
                        });
                    } else {
                        return false;
                    }
                });
            })
        });
    </script>
@stop
