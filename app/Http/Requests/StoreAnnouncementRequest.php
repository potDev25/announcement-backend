<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAnnouncementRequest extends FormRequest
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
            "title"     => 'required',
            "content"   => 'required',
            "startDate" => 'required',
            "endDate"   => 'required',
        ];
    }

    public function messages() : array
    {
        return [
            "title.required"     => 'Please enter title of the announcement',
            "content.required"   => 'Please enter content',
            "startDate.required" => 'Please specify start date',
            "endDate.required"   => 'Please specify end date',
        ];
    }
}
