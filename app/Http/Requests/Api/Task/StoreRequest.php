<?php

namespace App\Http\Requests\Api\Task;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'author_id' => 'required|integer|exists:users,id',
            'reader_user_id' => 'required|integer|exists:users,id',
            'title' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'text' => 'required|string',
            'deadline_date' => 'required|date'
        ];
    }

    public function messages(): array
    {
        return parent::messages();
    }

    /**
     * @param Validator $validator
     * @return void
     *
     * Return the first validation error as a JSON response
     */
    protected function failedValidation(Validator $validator): void
    {
        $errors = $validator->errors()->first();
        $response = response()->json(['error' => $errors], 422);
        throw new HttpResponseException($response);
    }
}
