<?php

namespace App\Http\Requests;

use App\Traits\Api;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class ShowSerialPasoRequest extends FormRequest
{
    use Api;
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
            'file' => 'nullable|string|max:128',
            'app_env' => 'required|integer|in:0,1,2',
            'contract_server' => 'nullable|integer|in:0,1',
        ];
    }
    protected function failedValidation(Validator $validator)
    {
        $errors = $validator->errors();
        Log::error(json_encode($errors));
        throw new HttpResponseException($this->responseFileError());
    }
}
