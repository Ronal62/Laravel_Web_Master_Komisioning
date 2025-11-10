<?php

namespace App\Http\Controllers;

use App\Models\PelaksanaRtu;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class PelaksanaRtuController extends Controller
{
    public function index()
    {
        $pelaksanaRtus = PelaksanaRtu::all();
        return view('pages.pelrtu.index', compact('pelaksanaRtus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pelrtu.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_pelrtu' => 'required|string|max:100',
            'foto_ttd' => 'required|file|image|mimes:png|max:2048',
        ]);

        $path = $request->file('foto_ttd')->store('ttd_pelrtu', 'public');

        $pelaksanaRtu = new PelaksanaRtu();
        $pelaksanaRtu->nama_pelrtu = $request->nama_pelrtu;
        $pelaksanaRtu->foto_ttd = $path;
        $pelaksanaRtu->save();

        return redirect()->route('pelrtu.index')->with('success', 'Pelaksana RTU added successfully.');
    }

    public function edit($id)
    {
        $pelaksanaRtu = PelaksanaRtu::findOrFail($id);
        return view('pages.pelrtu.edit', compact('pelaksanaRtu'));
    }

    public function update(Request $request, $id)
    {
        $pelaksanaRtu = PelaksanaRtu::findOrFail($id);

        $request->validate([
            'nama_pelrtu' => 'required|string|max:100',
            'foto_ttd' => 'nullable|file|image|mimes:png|max:2048',
        ]);

        $pelaksanaRtu->nama_pelrtu = $request->nama_pelrtu;

        // Only update signature if new file is uploaded
        if ($request->hasFile('foto_ttd')) {
            // Delete old signature file
            if ($pelaksanaRtu->foto_ttd && Storage::disk('public')->exists($pelaksanaRtu->foto_ttd)) {
                Storage::disk('public')->delete($pelaksanaRtu->foto_ttd);
            }

            // Store new signature
            $path = $request->file('foto_ttd')->store('ttd', 'public');
            $pelaksanaRtu->foto_ttd = $path;
        }

        $pelaksanaRtu->save();

        return redirect()->route('pelrtu.index')->with('success', 'Pelaksana RTU updated successfully.');
    }

    public function destroy($id)
    {
        $pelaksanaRtu = PelaksanaRtu::findOrFail($id);

        // Delete signature file
        if ($pelaksanaRtu->foto_ttd && Storage::disk('public')->exists($pelaksanaRtu->foto_ttd)) {
            Storage::disk('public')->delete($pelaksanaRtu->foto_ttd);
        }

        $pelaksanaRtu->delete();

        return redirect()->route('pelrtu.index')->with('success', 'Pelaksana RTU deleted successfully.');
    }
}
