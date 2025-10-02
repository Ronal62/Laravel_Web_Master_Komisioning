<?php

namespace App\Http\Controllers;

use App\Models\Garduinduk;
use Illuminate\Http\Request;

class GarduindukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $garduinduks = Garduinduk::all();
        return view('pages.garduinduk.index', compact('garduinduks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.garduinduk.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_gi' => 'required|string|max:25',
            'nama_dcc' => 'required|string|max:10',
            'alamat_gi' => 'required|string',
            'ip_gi' => 'required|string|max:15',
            'no_hp' => 'required|string|max:12',
        ]);

        Garduinduk::create($validated);
        return redirect()->route('gardu.index')->with('success', 'Gardu Induk created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Garduinduk $gardu)
    {
        return view('pages.garduinduk.show', compact('gardu'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Garduinduk $gardu)
    {
        return view('pages.garduinduk.edit', compact('gardu'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Garduinduk $gardu)
    {
        $validated = $request->validate([
            'nama_gi' => 'required|string|max:25',
            'nama_dcc' => 'required|string|max:10',
            'alamat_gi' => 'required|string',
            'ip_gi' => 'required|string|max:15',
            'no_hp' => 'required|string|max:12',
        ]);

        $gardu->update($validated);
        return redirect()->route('gardu.index')->with('success', 'Gardu Induk updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Garduinduk $gardu)
    {
        $gardu->delete();
        return redirect()->route('gardu.index')->with('success', 'Gardu Induk deleted successfully.');
    }
}
