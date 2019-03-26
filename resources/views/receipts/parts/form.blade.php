@if( !isset($receipt) )
    {{ Form::open(['url' => route('receipts.store'), 'method' => 'post']) }}
@else
    {{ Form::open(['url' => route('receipts.update', ['receipt' => $receipt->id]), 'method' => 'put']) }}
@endif

<div class="box box-primary">
    <div class="box-body">
        <div class="new-receipt__box-form">
            <div class="row">
                <div class="form-group {{ $errors->has('name') ? ' has-error' : '' }} col-md-6">
                    {{ Form::label('name', __('recruit.name') . '*') }}
                    {{ Form::text('name', $receipt->name ?? null, ['class' => 'form-control',
                        'maxlength' => \App\Components\CommonConstants::INGREDIENT_RECEIPT_NAME]) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group {{ $errors->has('description') ? ' has-error' : '' }} col-md-6">
                    {{ Form::label('description', __('lagarto.description')) }}
                    {{ Form::textarea('description', $receipt->description ?? null, ['class' => 'form-control']) }}
                </div>
            </div>
            <div class="row">
                <div class="form-group {{ $errors->has('ingredients') ? ' has-error' : '' }}
                        col-md-3 new-receipt__box-ingredients">
                    {{ Form::label("ingredients['name'][]", __('recruit.ingredient')) }}

                </div>
                <div class="form-group {{ $errors->has('ingredients') ? ' has-error' : '' }}
                        col-md-3 new-receipt__box-ingredients" >
                    {{ Form::label("ingredients['quantity'][]", __('recruit.quantity')) }}
                </div>
            </div>
            @php
                $showIngredients = [];
                if (old('ingredients') && count(old('ingredients'))) {
                    $chosenIngredients = old('ingredients');
                  //  dd(old('ingredients'));
                  /*  if(isset($chosenIngredients['name']) && count($chosenIngredients['name'])) {
                        $countChosenIngredients = count($chosenIngredients['name']);

                        for ($i = 0; $i < $countChosenIngredients; $i++) {
                            $chosenQuantity = 0;

                            if (isset($chosenIngredients['quantity'][$i])) {
                                $chosenQuantity = $chosenIngredients['quantity'][$i];
                            }

                            $showIngredients[] = [
                                'id' => $chosenIngredients['name'][$i],
                                'quantity' => $chosenQuantity
                            ];
                        }
                    }*/

                } elseif (isset($existIngredients) && count($existIngredients)) {

                    foreach ($existIngredients as $existIngredient) {

                        if ($existIngredient->ingredient_id !== null) {
                            $showIngredients[] = [
                                'id' => $existIngredient->ingredient_id,
                                'quantity' => $existIngredient->quantity
                            ];
                        }
                    }

                }

            @endphp
            <div class="row" id="ingredients_container">
                @foreach($showIngredients as $showIngredient)
                    <div  class="col-md-12 new-receipt__box-ingredients">
                        <div class="form-group col-md-3" >

                            {{ Form::select("ingredients[name][]", $ingredients, (int) $showIngredient['id'],
                            $attributes = [
                                'class' => 'form-control',
                                'disabled' => count($ingredients) ? false : 'disabled',
                                'placeholder' => count($ingredients) ?
                                    __('recruit.select_ingredient') :
                                    __('lagarto.no_ingredients')]) }}
                        </div>
                        <div class="input-group col-md-3">
                            {{ Form::number(
                                "ingredients[quantity][]",
                                 $showIngredient['quantity'],
                                $attributes = ['class' => 'form-control']
                            ) }}

                            <span class="input-group-btn">
                                <button class='btn btn-danger' onclick='removeIngredientField(this)' type='button'><i class='fa fa-minus'></i></button>
                            </span>
                        </div>
                    </div>
                @endforeach
                <div  class="col-md-12 new-receipt__box-ingredients">
                    <div class="form-group col-md-3" >

                        {{ Form::select("ingredients[name][]", $ingredients, 0,
                        $attributes = [
                            'class' => 'form-control',
                            'disabled' => count($ingredients) ? false : 'disabled',
                            'placeholder' => count($ingredients) ?
                                __('recruit.select_ingredient') :
                                __('lagarto.no_ingredients')]) }}
                    </div>
                    <div class="input-group col-md-3">
                            {{ Form::number(
                                "ingredients[quantity][]",
                                 0,
                                $attributes = ['class' => 'form-control']
                            ) }}

                            <span class="input-group-btn">
                                <button class="btn btn-success" onclick="addIngredientField(this)" type="button"><i class="fa fa-plus"></i></button>
                            </span>
                    </div>
                </div>
                <div class="col-md-6"></div>
            </div>
            <div class="row">
                <div class="box-header with-border">
                    <a href="{{ route('ingredients.create') }}" class="btn btn-success" role="button">@lang('recruit.create_new_ingredient')</a>
                </div>
            </div>
    </div>

    <div class="box-footer">
        {{ Form::submit( isset($receipt) ? 'Update' : 'Create', $attributes = ['class' => 'btn btn-info']) }}
        <a href="{{ route('receipts.index') }}" class="btn btn-default btn-indent-left">
            @lang('recruit.cancel')
        </a>
    </div>
</div>
{{ Form::close() }}

@section('js')
    <script src="{{ asset('js/rangeslider/js/ion.rangeSlider.min.js') }}"></script>

    <script>
        function addIngredientField() {
            var newInput = "<div  class='col-md-12 new-receipt__box-ingredients'>" +
               "<div class='form-group col-md-3 ' >" +
                    '{{ Form::select("ingredients[name][]", $ingredients, null,
                        $attributes = [
                            "class" => "form-control",
                            "disabled" => count($ingredients) ? false : "disabled",
                            "placeholder" => count($ingredients) ?
                                __("recruit.select_ingredient") :
                                __("lagarto.no_ingredients")]) }}' +
               "</div>" +
               "<div class='input-group col-md-3'>" +
                   '{{ Form::number("ingredients[quantity][]", 0 , $attributes = ["class" => "form-control"]) }}' +
                   "<span class='input-group-btn'>" +
                       "<button class='btn btn-danger' onclick='removeIngredientField(this)' type='button'><i class='fa fa-minus'></i></button>" +
                   "</span>" +
                "</div>" +
           "</div>";

            document.getElementById('ingredients_container').insertAdjacentHTML('beforeend', newInput);
        }

        function removeIngredientField(field) {
            $(field).closest(".new-receipt__box-ingredients").fadeOut(300, function() { $(this).remove(); });
        }
    </script>
@stop