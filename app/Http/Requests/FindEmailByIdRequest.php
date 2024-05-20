<?php

namespace App\Http\Requests;

use App\Facades\EmailStorage;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FindEmailByIdRequest extends FormRequest
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
            'id' => ['required', 'exists:emails,id', 'numeric'],
            'with_relations' => ['sometimes', 'required', 'array', 'min:1'],
            'with_relations.*' => ['sometimes', 'required', 'string', function ($attribute, $value, $fail) {
                if (! in_array($value, EmailStorage::AVAILABLE_RELATIONS)) {
                    $fail("The provided \"{$value}\" relation is not allowed.");
                }
            }],
        ];
    }
}
