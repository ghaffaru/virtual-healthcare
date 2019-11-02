<?php

namespace App\Http\Controllers\AdminsControllers;

use Illuminate\Http\Request;
use App\HospitalEvent;
use App\Admin;
use App\Http\Requests\HospitalEventRequest;
use App\Http\Resources\HospitalEventResource;
use App\Http\Controllers\Controller;

class HospitalEventsController extends Controller
{
    public function __construct()
    {
        $this->middleware(['multiauth:admin,api']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $event = HospitalEvent::all();

        return HospitalEventResource::collection($event);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(HospitalEventRequest $request)
    {
        //$this->authorize('manage');

       \abort_if(auth()->guard('admin') == Admin::first(), 403);

        HospitalEvent::create($request->all());

        return ['admin'=> auth()->guard('admin')];

        return response()->json(["success" => 'event created'], 200);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(HospitalEvent $event)
    {
        return new HospitalEventResource($event);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(HospitalEventRequest $request, HospitalEvent $event)
    {
        $event->update($request->all());

        return response()->json(["success" => 'event modified'], 200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(HospitalEvent $event)
    {
        $event->delete();

        return response()->json(["success" => 'event deleted'], 200);

    }
}
