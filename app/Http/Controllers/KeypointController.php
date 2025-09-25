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
        // Define array fields that come from checkboxes
        $arrayFields = [
            's_cb', 's_cb2', 's_lr', 's_door', 's_acf', 's_dcf', 's_dcd', 's_hlt', 's_sf6',
            's_fir', 's_fis', 's_fit', 's_fin', 's_comf', 's_lruf',
            'c_cb', 'c_cb2', 'c_hlt', 'c_rst'
        ];

        // Validation rules
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'nullable|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'nullable|string|max:255',
            'id_gi' => 'required|integer|exists:tb_garduinduk,id_gi',
            'nama_peny' => 'nullable|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
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
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_picms' => 'required|string|max:25|exists:tb_picmaster,id_picmaster', // Updated to id_picmaster
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field.'.*' => 'string|in:normal,ok,nok,log,sld,tidak_uji',
            ]);
        }

        // Process array fields: implode into comma-separated string
        foreach ($arrayFields as $field) {
            if ($request->has($field)) {
                $validated[$field] = implode(',', $request->input($field));
            } else {
                $validated[$field] = ''; // Use empty string for NOT NULL columns
            }
        }

        // Create the record
        Keypoint::create($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Keypoint $keypoint)
    {
        return view('pages.keypoint.show', compact('keypoint'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Keypoint $keypoint)
    {
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::table('tb_garduinduk')->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $picmaster = DB::table('tb_picmaster')->get();

        // For array fields, explode the comma-separated values to pre-check checkboxes
        $arrayFields = [
            's_cb', 's_cb2', 's_lr', 's_door', 's_acf', 's_dcf', 's_dcd', 's_hlt', 's_sf6',
            's_fir', 's_fis', 's_fit', 's_fin', 's_comf', 's_lruf',
            'c_cb', 'c_cb2', 'c_hlt', 'c_rst'
        ];

        foreach ($arrayFields as $field) {
            if ($keypoint->$field) {
                $keypoint->$field = explode(',', $keypoint->$field);
            } else {
                $keypoint->$field = [];
            }
        }

        return view('pages.keypoint.edit', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'picmaster'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Keypoint $keypoint)
    {
        // Define array fields that come from checkboxes
        $arrayFields = [
            's_cb', 's_cb2', 's_lr', 's_door', 's_acf', 's_dcf', 's_dcd', 's_hlt', 's_sf6',
            's_fir', 's_fis', 's_fit', 's_fin', 's_comf', 's_lruf',
            'c_cb', 'c_cb2', 'c_hlt', 'c_rst'
        ];

        // Validation rules
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'nullable|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'nullable|string|max:255',
            'id_gi' => 'required|integer|exists:tb_garduinduk,id_gi',
            'nama_peny' => 'nullable|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
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
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_picms' => 'required|string|max:25|exists:tb_picmaster,id_picmaster', // Updated to id_picmaster
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field.'.*' => 'string|in:normal,ok,nok,log,sld,tidak_uji',
            ]);
        }

        // Process array fields: implode into comma-separated string
        foreach ($arrayFields as $field) {
            if ($request->has($field)) {
                $validated[$field] = implode(',', $request->input($field));
            } else {
                $validated[$field] = ''; // Use empty string for NOT NULL columns
            }
        }

        // Update the record
        $keypoint->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Keypoint $keypoint)
    {
        $keypoint->delete();
        return redirect()->route('keypoint.index')->with('success', 'Keypoint deleted successfully!');
    }

    /**
     * Display notes for the specified resource.
     */
    public function note(Keypoint $keypoint)
    {
        return view('pages.keypoint.note', compact('keypoint'));
    }
}
