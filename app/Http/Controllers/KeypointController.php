<?php

namespace App\Http\Controllers;


use App\Models\Keypoint;
use Illuminate\Http\Request;

class KeypointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $cbOpen = $request->input('cb_open_type') === 'normal' ? 'normal' : $request->input('cb_open_options', []);
        // Process data (e.g., save to database)
        return redirect()->route('keypoint.add')->with('success', 'Data saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keypoint $keypoint)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keypoint $keypoint)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keypoint $keypoint)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keypoint $keypoint)
    {
        //
    }
}
