<a class="btn btn-primary btn-xs" href="{{ route('receipts.edit', ['receipt' => $receipt->id]) }}" title="Edit">
    <i class="fa fa-fw fa-edit"></i> Edit</a>
<button class="btn btn-danger btn-delete btn-xs"
        data-remote="{{ route('receipts.destroy', ['receipt' => $receipt->id]) }}" title="Delete">
    <i class="fa fa-fw fa-trash"></i> Delete</button>