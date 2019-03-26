@if( !isset($ingredient) )
    {{ Form::open(['url' => route('ingredients.store'), 'method' => 'post']) }}
@else
    {{ Form::open(['url' => route('ingredients.update', ['ingredient' => $ingredient->id]), 'method' => 'put']) }}
@endif
<div class="box box-primary">
    <div class="box-body">
        <div class="new-ingredient__box-form">
            <div class="row">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                    {{ Form::label('name', __('recruit.name') . '*') }}
                    {{ Form::text('name', $ingredient->name ?? null, ['class' => 'form-control',
                        'maxlength' => \App\Components\CommonConstants::INGREDIENT_INGREDIENT_NAME]) }}
                </div>
            </div>
        </div>
    </div>
    <div class="box-footer">
        {{ Form::submit( isset($ingredient) ? 'Update' : 'Create', $attributes = ['class' => 'btn btn-info']) }}
        <a href="{{ route('ingredients.index') }}" class="btn btn-default btn-indent-left">
            @lang('recruit.cancel')
        </a>
    </div>
</div>
{{ Form::close() }}