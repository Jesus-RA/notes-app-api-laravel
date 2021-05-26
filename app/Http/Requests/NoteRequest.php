<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;

class NoteRequest extends FormRequest
{
    public $validator;

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
        return [
            "data" => ["required", "array"],
            "data.type" => ["required", "string"],
            "data.attributes" => ["required", "array"]
        ];
    }

    protected function failedValidation(Validator $validator){
        
        $this->validator = $validator;
        
    }

}
