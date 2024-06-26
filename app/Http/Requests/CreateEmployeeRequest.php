<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateEmployeeRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'date_of_birth'=>['required', 'date','date_format:Y-m-d'],
            'resume' => ['required', 'string'],
            'experience' => ['required', 'string'],
            'education' => ['required', 'string'],
            'portfolio' => ['nullable', 'string'],
            'phone_number' => ['required', 'string'],
            'work_status' => ['required', 'string', 'in:working,student,not working'],
            'graduation_status' => ['required', 'string', 'in:graduated,Not graduated'],
            'photo' => ['nullable','image', 'mimes:jpeg,png,jpg,gif,svg'],
        ];
    }
}
