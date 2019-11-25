<?php

namespace App\Http\Controllers\AdminsControllers;

use App\Pharmacist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\PharmacistsRegistrationRequest;

use App\Http\Controllers\Controller;

class PharmacistsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['api']);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function Register(PharmacistsRegistrationRequest $request)
    {
       $pharmacist = Pharmacist::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make('vhealth123'),
            'department_id' => $request->department_id,
            'avatar' => $request->avatar
        ]);

        if($request->hasFile('avatar'))
        {
            $this->savePharmacistAvatar($pharmacist);
        }

        return response()->json(['success' => 'Pharmacist added'], 200);
    }


    public function savePharmacistAvatar(Pharmacist $pharmacist)
    {
     
        $fileNameToStore = request()->file('avatar')->getClientOriginalName(); 

        # image path
        $path = 'public/images/pharmacists/'. $pharmacist->id;

        request()->file('avatar')->storeAs($path, $fileNameToStore);

        $pharmacist->avatar = '/storage/images/pharmacists/'.$pharmacist->id. '/'. $fileNameToStore;

        $pharmacist->save();
        
    }

     /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pharmacist $pharmacist)
    {
        $pharmacist->update($request->all());

        $this->savePharmacistAvatar($pharmacist);

        return response()->json(['success' => 'Pharmacist\'s details modified'], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Employee  $employee
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pharmacist $pharmacist)
    {
        Storage::deleteDirectory('public/images/pharmacists/'.$pharmacist->id.'/');
        
        $pharmacist->delete();

        return response()->json(['success' => $pharmacist->name .' deleted'], 200);
    }


}
