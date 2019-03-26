<a class="btn btn-primary btn-xs" href="{{ route('ingredients.edit', ['ingredient' => $ingredient->id]) }}" title="@lang('lagarto.edit')">
    <i class="fa fa-fw fa-edit"></i> @lang('lagarto.edit')</a>
<button class="btn btn-danger btn-delete btn-xs"
        data-remote="{{ route('ingredients.destroy', ['ingredient' => $ingredient->id]) }}" title="@lang('lagarto.delete')">
    <i class="fa fa-fw fa-trash"></i> @lang('lagarto.delete')</button>