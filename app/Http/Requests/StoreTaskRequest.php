<?php

namespace App\Http\Requests;

use App\Http\Controllers\Api\v1\TasksApiController;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreTaskRequest extends FormRequest
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
        return [
            'title'   => 'required',
            'body'    => 'required',
            'status'  => 'required|in:' . implode(',', TasksApiController::STATUS),
            'user_id' => 'required|exists:users,id'
        ];
    }

    /**
     * Customing Messages
     * @return array|string[]
     */
    public function messages()
    {
        return [
            'title.required'   => 'A title is required',
            'body.required'    => 'A body is required',
            'status.required'  => 'A status is required',
            'user_id.required' => 'A user_id is required',
            'user_id.exists'   => 'A user not exists'
        ];
    }

    /**
     * HttpResponseException
     * @param Validator $validator
     */
    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json($validator->errors(), 422));
    }
}
