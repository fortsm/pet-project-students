<?php

namespace App\Http\Requests;

use App\Traits\HasJsonFailedValidation;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClassroomRequest extends FormRequest
{
    use HasJsonFailedValidation;
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $classroom_id = (int) $this->route()->originalParameter('classroom');
        return [
            'name' => ['required', 'string', 'max:255', Rule::unique('classrooms')->ignore($classroom_id)],
        ];
    }
}
