<?php

namespace App\Http\Controllers;

use App\Models\Modem;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Validator;

class ModemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $modem = modem::all();
        return view('pages.modem.index', compact('modem'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.modem.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_modem' => 'required|string|max:25',
            'sinyal' => 'required|string|max:25',
        ]);

        Modem::create([
            'nama_modem' => $request->nama_modem,
            'sinyal' => $request->sinyal,
        ]);

        return redirect()->route('modem.index')->with('success', 'Modem created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function edit(Modem $modem)
    {
        return view('pages.modem.edit', compact('modem'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Modem $modem)
    {
        $validator = Validator::make($request->all(), [
            'nama_modem' => 'required|string|max:25',
            'sinyal' => 'required|string|max:25',
        ]);
        if ($validator->fails()) {
            return redirect()->route('modem.edit', $modem->id_modem)
                ->withErrors($validator)
                ->withInput();
        }

        $modem->update([
            'nama_modem' => $request->nama_modem,
            'sinyal' => $request->sinyal,
        ]);
        return redirect()->route('modem.index')->with('success', 'Modem deleted successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Modem $modem)
    {
        $modem->delete();
        return redirect()->route('modem.index')->with('success', 'Modem deleted successfully.');
    }
}
