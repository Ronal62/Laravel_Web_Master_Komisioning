<?php

namespace App\Http\Controllers;

use App\Models\Picmaster;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PicmasterController extends Controller
{
    public function index()
    {
        $picmasters = Picmaster::all();
        return view('pages.picmaster.index', compact('picmasters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.picmaster.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_picmaster' => 'required|string|max:255',
            'foto_ttd' => 'required|file|image|mimes:png|max:2048',
        ]);

        $path = $request->file('foto_ttd')->store('ttd', 'public');

        $picmaster = new Picmaster();
        $picmaster->nama_picmaster = $request->nama_picmaster;
        $picmaster->foto_ttd = $path;
        $picmaster->save();

        return redirect()->route('picmaster.index')->with('success', 'Pelaksana Master II added successfully.');
    }

    public function destroy($id)
    {
        $picmaster = Picmaster::findOrFail($id);
        $picmaster->delete();

        return redirect()->route('picmaster.index')->with('success', 'Pelaksana Master II deleted successfully.');
    }
}