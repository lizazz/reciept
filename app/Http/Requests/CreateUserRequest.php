<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreateUserRequest
 * @package App\Http\Requests
 */
class CreateUserRequest extends FormRequest
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
        $maxFileSize = ini_get('upload_max_filesize');

        switch(substr(($maxFileSize), -1)){
            case "M":
                $sizeInKb = (int) $maxFileSize * 1024;
                break;

            case "G":
                $sizeInKb = (int) $maxFileSize * 1024 * 1024;
                break;
            default:
                $sizeInKb = (int) $maxFileSize;
        }

        return [
            'name' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string',
            'confirm' => 'same:password'
        ];
    }
}
