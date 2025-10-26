<?php

namespace App\Http\Controllers;

use App\Models\Picmaster;
use Illuminate\Support\Facades\Storage;
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

    public function edit($id)
    {
        $picmaster = Picmaster::findOrFail($id);
        return view('pages.picmaster.edit', compact('picmaster'));
    }

    public function update(Request $request, $id)
    {
        $picmaster = Picmaster::findOrFail($id);

        $request->validate([
            'nama_picmaster' => 'required|string|max:255',
            'foto_ttd' => 'nullable|file|image|mimes:png|max:2048',
        ]);

        $picmaster->nama_picmaster = $request->nama_picmaster;

        // Only update signature if new file is uploaded
        if ($request->hasFile('foto_ttd')) {
            // Delete old signature file
            if ($picmaster->foto_ttd && Storage::disk('public')->exists($picmaster->foto_ttd)) {
                Storage::disk('public')->delete($picmaster->foto_ttd);
            }

            // Store new signature
            $path = $request->file('foto_ttd')->store('ttd', 'public');
            $picmaster->foto_ttd = $path;
        }

        $picmaster->save();

        return redirect()->route('picmaster.index')->with('success', 'Pelaksana Master II updated successfully.');
    }

    public function destroy($id)
    {
        $picmaster = Picmaster::findOrFail($id);

        // Delete signature file
        if ($picmaster->foto_ttd && Storage::disk('public')->exists($picmaster->foto_ttd)) {
            Storage::disk('public')->delete($picmaster->foto_ttd);
        }

        $picmaster->delete();

        return redirect()->route('picmaster.index')->with('success', 'Pelaksana Master II deleted successfully.');
    }
}
