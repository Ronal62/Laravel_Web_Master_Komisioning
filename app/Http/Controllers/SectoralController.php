<?php

namespace App\Http\Controllers;

use App\Models\Sectoral;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class SectoralController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sectoral = Sectoral::all();
        return view('pages.sectoral.index', compact('sectoral'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.sectoral.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //  validate the request data
        $request->validate([
            'nama_sec' => 'required|string|max:25',
        ]); // Add other validation rules as needed

        // create a new sectoral record
        Sectoral::create([
            'nama_sec' => $request->nama_sec,
        ]);

        // redirect to the index page with a success message
        return redirect()->route('sectoral.index')->with('success', 'Sectoral created successfully.');
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sectoral $sectoral)
    {
        return view('pages.sectoral.edit', compact('sectoral'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sectoral $sectoral)
    {
        //  validate the request data
        $request->validate([
            'nama_sec' => 'required|string|max:25',
        ]); // Add other validation rules as needed

        // update the sectoral record
        $sectoral->update([
            'nama_sec' => $request->nama_sec,
        ]);

        // redirect to the index page with a success message
        return redirect()->route('sectoral.index')->with('success', 'Sectoral updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sectoral $sectoral)
    {
        $sectoral->delete();
        return redirect()->route('sectoral.index')->with('success', 'Sectoral deleted successfully.');
    }
}