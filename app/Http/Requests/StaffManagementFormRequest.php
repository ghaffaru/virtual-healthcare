<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StaffManagementFormRequest extends FormRequest
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
            
            'name' => 'required|string',

            'department_id' => 'required|integer',

            'email' => 'required|email|unique:employees',

            'phone' => 'required|string|min:10|max:13|unique:employees',

            'qualification' => 'required|string',

            'staff_type_id' => 'required|integer',

            'designation' => 'nullable|string',

            'avatar' => 'nullable',

            'gender' => 'required|string|min:1|max:1', # f or M

        ];
    }
}


/* 
 if($request->hasFile('avatar'))
        {
            $fileNameToStore = $request->file('avatar')->getClientOriginalName().now(); 

            # image path
            $path = 'app/public/images/'.$fileNameToStore;

            $request->file('avatar')->move(storage_path($path));

            $request['avatar'] = $path;

        }

        Employee::create($request->all());

        return response()->json(['success' => 'Staff added'], 200);


        StaffManagementFormRequest $request

        use App\Http\Requests\StaffManagementFormRequest;

*/