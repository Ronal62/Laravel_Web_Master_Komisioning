<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KeypointController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Fetch data from tb_formkp with corrected table/column names based on schema
        $keypoints = DB::table('tb_formkp')
            ->select(
                'id_formkp',
                'tgl_komisioning',
                'nama_lbs as nama_keypoint',
                DB::raw("CONCAT(id_gi, ' - ', nama_peny) as gi_penyulang"),
                DB::raw("CONCAT(
                    COALESCE((SELECT nama_merklbs FROM tb_merklbs WHERE id_merkrtu = tb_formkp.id_merkrtu LIMIT 1), 'Unknown'),
                    ' - ',
                    COALESCE((SELECT nama_modem FROM tb_modem WHERE id_modem = tb_formkp.id_modem LIMIT 1), 'Unknown')
                ) as merk_modem_rtu"),
                'ketkp as keterangan',
                'nama_user as master',
                'lastupdate'
            )
            ->get();

        // Pass data to the view
        return view('pages.keypoint.index', compact('keypoints'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.keypoint.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer',
            'id_modem' => 'required|integer',
            // Add other validation rules as needed
        ]);

        DB::table('tb_formkp')->insert($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keypoint $keypoint)
    {
        $keypoint = DB::table('tb_formkp')->where('id_formkp', $keypoint->id_formkp)->first();
        return view('pages.keypoint.show', compact('keypoint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keypoint $keypoint)
    {
        $keypoint = DB::table('tb_formkp')->where('id_formkp', $keypoint->id_formkp)->first();
        return view('pages.keypoint.edit', compact('keypoint'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keypoint $keypoint)
    {
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            // Add other validation rules as needed
        ]);

        DB::table('tb_formkp')->where('id_formkp', $keypoint->id_formkp)->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keypoint $keypoint)
    {
        DB::table('tb_formkp')->where('id_formkp', $keypoint->id_formkp)->delete();
        return redirect()->route('keypoint.index')->with('success', 'Keypoint deleted successfully!');
    }

    /**
     * Display notes for the specified resource.
     */
    public function note(Keypoint $keypoint)
    {
        $keypoint = DB::table('tb_formkp')->where('id_formkp', $keypoint->id_formkp)->first();
        return view('pages.keypoint.note', compact('keypoint'));
    }
}
