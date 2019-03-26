@if(Auth::check())
    <a class="btn btn-primary btn-xs" href="{{ route('user.edit', ['job' => $user->id]) }}" title="Edit">
        <i class="fa fa-fw fa-edit"></i> Edit</a>
    @if(Auth::user()->id != $user->id)
        <button class="btn btn-danger btn-delete btn-xs" data-remote="{{ route('user.destroy', ['job' => $user->id]) }}" title="Delete">
            <i class="fa fa-fw fa-trash"></i> Delete</button>
    @endif
@endif
