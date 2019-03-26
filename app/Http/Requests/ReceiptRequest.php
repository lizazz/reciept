<?php

namespace App\Http\Requests;

use App\Components\CommonConstants;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class IngredientRequest
 * @package App\Http\Requests
 */
class ReceiptRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            /** For create Receipt case */
            case 'POST':
                {
                    return [
                        'name' => 'string|max:' . CommonConstants::INGREDIENT_RECEIPT_NAME,
                        'description' => 'nullable|string|max:50000',
                        'ingredients' => 'array'
                    ];
                }
            /** For update Receipt case */
            case 'PUT':
                {
                    return [
                        'name' => 'string|max:' . CommonConstants::INGREDIENT_RECEIPT_NAME,
                        'description' => 'nullable|string|max:50000',
                        'ingredients' => 'array'
                    ];
                }
            case 'PATCH':
            default:break;
        }
    }
}
