<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MessagesRequest extends FormRequest
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
     * Get the validation rules that apply to png,jpg
     * @return array
     */
    public function rules()
    {
        return [
            
            'message' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,docx,xlsx',
            'recipient_id' => 'required|integer' 
        ];
    }
}
