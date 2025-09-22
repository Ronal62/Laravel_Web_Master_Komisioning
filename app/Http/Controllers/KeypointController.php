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
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::table('tb_garduinduk')->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $picmaster = DB::table('tb_picmaster')->get();

        return view('pages.keypoint.add', compact('merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'picmaster'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'nullable|string|max:255',
            'id_medkom' => 'nullable|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'nullable|string|max:255',
            'id_gi' => 'nullable|integer|exists:tb_garduinduk,id_gi',
            'nama_peny' => 'nullable|string|max:25',
            'id_sec' => 'nullable|integer|exists:tb_sectoral,id_sec',
            's_cb' => 'nullable|string|max:100',
            's_cb2' => 'nullable|string|max:100',
            's_lr' => 'nullable|string|max:100',
            's_door' => 'nullable|string|max:100',
            's_acf' => 'nullable|string|max:100',
            's_dcf' => 'nullable|string|max:100',
            's_dcd' => 'nullable|string|max:100',
            's_hlt' => 'nullable|string|max:100',
            's_sf6' => 'nullable|string|max:100',
            's_fir' => 'nullable|string|max:100',
            's_fis' => 'nullable|string|max:100',
            's_fit' => 'nullable|string|max:100',
            's_fin' => 'nullable|string|max:100',
            's_comf' => 'nullable|string|max:100',
            's_lruf' => 'nullable|string|max:100',
            'c_cb' => 'nullable|string|max:150',
            'c_cb2' => 'nullable|string|max:150',
            'c_hlt' => 'nullable|string|max:150',
            'c_rst' => 'nullable|string|max:150',
            'ir_rtu' => 'nullable|numeric',
            'ir_ms' => 'nullable|numeric',
            'ir_scale' => 'nullable|string|max:10',
            'is_rtu' => 'nullable|numeric',
            'is_ms' => 'nullable|numeric',
            'is_scale' => 'nullable|string|max:10',
            'it_rtu' => 'nullable|numeric',
            'it_ms' => 'nullable|numeric',
            'it_scale' => 'nullable|string|max:10',
            'vr_rtu' => 'nullable|string|max:10',
            'vr_ms' => 'nullable|string|max:10',
            'vr_scale' => 'nullable|string|max:10',
            'vs_rtu' => 'nullable|string|max:10',
            'vs_ms' => 'nullable|string|max:10',
            'vs_scale' => 'nullable|string|max:10',
            'vt_rtu' => 'nullable|string|max:10',
            'vt_ms' => 'nullable|string|max:10',
            'vt_scale' => 'nullable|string|max:10',
            'sign_kp' => 'nullable|string|max:10',
            'id_komkp' => 'nullable|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_picms' => 'nullable|integer|exists:tb_picmaster,id_picmaster',
            'pelrtu' => 'nullable|string|max:25',
            'ketkp' => 'nullable|string|max:500',
        ]);

        $keypoint = Keypoint::create($validated);

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
