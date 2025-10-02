<?php

namespace App\Http\Controllers;

use App\Models\merklbs;
use Illuminate\Http\Request;

class MerklbsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $merklbs = merklbs::all();
        return view('pages.merklbs.index', compact('merklbs'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(merklbs $merklbs)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(merklbs $merklbs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, merklbs $merklbs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(merklbs $merklbs)
    {
        //
    }
}
