<?php

namespace App\Http\Controllers;

use App\Models\merklbs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

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
        return view('pages.merklbs.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama_merklbs' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return redirect()->route('merk.add')
                ->withErrors($validator)
                ->withInput();
        }

        MerkLbs::create([
            'nama_merklbs' => $request->nama_merklbs,
        ]);

        return redirect()->route('merk.index')->with('success', 'Merk LBS created successfully.');
    }

    public function edit(MerkLbs $merk)
    {
        return view('pages.merklbs.edit', compact('merk'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MerkLbs $merk)
    {
        $validator = Validator::make($request->all(), [
            'nama_merklbs' => 'required|string|max:25',
        ]);

        if ($validator->fails()) {
            return redirect()->route('merk.edit', $merk->id_merkrtu)
                ->withErrors($validator)
                ->withInput();
        }

        $merk->update([
            'nama_merklbs' => $request->nama_merklbs,
        ]);

        return redirect()->route('merk.index')->with('success', 'Merk LBS updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MerkLbs $merk)
    {
        $merk->delete();
        return redirect()->route('merk.index')->with('success', 'Merk LBS deleted successfully.');
    }

    /**
     * Display the specified resource.
     */

}
