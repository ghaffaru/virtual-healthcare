<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class DoctorPatientsChatRequest extends FormRequest
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
            'doctor_id' => 'required|integer',
            'id' => 'required|integer',
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,xlsx,docx'
        ];
    }
}
