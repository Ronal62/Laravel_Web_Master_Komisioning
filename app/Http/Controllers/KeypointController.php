<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

        // Preprocess id_picms to ensure it's an array
        $idPicmsInput = $request->input('id_picms', '');
        $idPicmsArray = !empty($idPicmsInput) ? array_filter(array_map('trim', explode(',', $idPicmsInput))) : [];

        // Define array fields that come from checkboxes
        $arrayFields = [
            's_cb',
            's_cb2',
            's_lr',
            's_door',
            's_acf',
            's_dcf',
            's_dcd',
            's_hlt',
            's_sf6',
            's_fir',
            's_fis',
            's_fit',
            's_fin',
            's_comf',
            's_lruf',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst'
        ];

        // Define valid checkbox values
        $validCheckboxValues = [
            'open_1',
            'open_2',
            'open_3',
            'open_4',
            'open_5',
            'close_1',
            'close_2',
            'close_3',
            'close_4',
            'close_5',
            'local_1',
            'local_2',
            'local_3',
            'local_4',
            'local_5',
            'remote_1',
            'remote_2',
            'remote_3',
            'remote_4',
            'remote_5',
            'dropen_1',
            'dropen_2',
            'dropen_3',
            'dropen_4',
            'dropen_5',
            'drclose_1',
            'drclose_2',
            'drclose_3',
            'drclose_4',
            'drclose_5',
            'acnrml_1',
            'acnrml_2',
            'acnrml_3',
            'acnrml_4',
            'acnrml_5',
            'acfail_1',
            'acfail_2',
            'acfail_3',
            'acfail_4',
            'acfail_5',
            'dcnrml_1',
            'dcnrml_2',
            'dcnrml_3',
            'dcnrml_4',
            'dcnrml_5',
            'dcfail_1',
            'dcfail_2',
            'dcfail_3',
            'dcfail_4',
            'dcfail_5',
            'dcfnrml_1',
            'dcfnrml_2',
            'dcfnrml_3',
            'dcfnrml_4',
            'dcfnrml_5',
            'dcffail_1',
            'dcffail_2',
            'dcffail_3',
            'dcffail_4',
            'dcffail_5',
            'hlton_1',
            'hlton_2',
            'hlton_3',
            'hlton_4',
            'hlton_5',
            'hltoff_1',
            'hltoff_2',
            'hltoff_3',
            'hltoff_4',
            'hltoff_5',
            'sf6nrml_1',
            'sf6nrml_2',
            'sf6nrml_3',
            'sf6nrml_4',
            'sf6nrml_5',
            'sf6fail_1',
            'sf6fail_2',
            'sf6fail_3',
            'sf6fail_4',
            'sf6fail_5',
            'firnrml_1',
            'firnrml_2',
            'firnrml_3',
            'firnrml_4',
            'firnrml_5',
            'firfail_1',
            'firfail_2',
            'firfail_3',
            'firfail_4',
            'firfail_5',
            'fisnrml_1',
            'fisnrml_2',
            'fisnrml_3',
            'fisnrml_4',
            'fisnrml_5',
            'fisfail_1',
            'fisfail_2',
            'fisfail_3',
            'fisfail_4',
            'fisfail_5',
            'fitnrml_1',
            'fitnrml_2',
            'fitnrml_3',
            'fitnrml_4',
            'fitnrml_5',
            'fitfail_1',
            'fitfail_2',
            'fitfail_3',
            'fitfail_4',
            'fitfail_5',
            'finnrml_1',
            'finnrml_2',
            'finnrml_3',
            'finnrml_4',
            'finnrml_5',
            'finfail_1',
            'finfail_2',
            'finfail_3',
            'finfail_4',
            'finfail_5',
            'comf_nrml_1',
            'comf_nrml_2',
            'comf_nrml_3',
            'lruf_nrml_1',
            'lruf_nrml_2',
            'lruf_nrml_5',
            'cbctrl_op_1',
            'cbctrl_op_2',
            'cbctrl_op_3',
            'cbctrl_op_4',
            'cbctrl_op_5',
            'cbctrl_cl_1',
            'cbctrl_cl_2',
            'cbctrl_cl_3',
            'cbctrl_cl_4',
            'cbctrl_cl_5',
            'cbctrl2_op_1',
            'cbctrl2_op_2',
            'cbctrl2_op_3',
            'cbctrl2_op_4',
            'cbctrl2_op_5',
            'cbctrl2_cl_1',
            'cbctrl2_cl_2',
            'cbctrl2_cl_3',
            'cbctrl2_cl_4',
            'cbctrl2_cl_5',
            'hltctrl_off_1',
            'hltctrl_off_2',
            'hltctrl_off_3',
            'hltctrl_off_4',
            'hltctrl_off_5',
            'hltctrl_on_1',
            'hltctrl_on_2',
            'hltctrl_on_3',
            'hltctrl_on_4',
            'hltctrl_on_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        // Validation rules
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => 'required|string|max:25',
            'nama_peny' => 'required|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'vr_rtu' => 'required|string|max:10',
            'vr_ms' => 'required|string|max:10',
            'vr_scale' => 'required|string|max:10',
            'vs_rtu' => 'required|string|max:10',
            'vs_ms' => 'required|string|max:10',
            'vs_scale' => 'required|string|max:10',
            'vt_rtu' => 'required|string|max:10',
            'vt_ms' => 'required|string|max:10',
            'vt_scale' => 'required|string|max:10',
            'sign_kp' => 'required|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'required|string|max:10',
            'id_picms' => ['required', function ($attribute, $value, $fail) use ($idPicmsArray) {
                if (empty($idPicmsArray)) {
                    $fail('The id picms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            // Set empty string for array fields if not present or empty
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // Merge preprocessed id_picms array into validated data
        $validated['id_picms'] = json_encode($idPicmsArray);

        // Log validated data before creating the record

        // Create the record
        Keypoint::create($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $keypoint = Keypoint::findOrFail($id);
        $merklbs = DB::table('tb_merklbs')->get();
        $modems = DB::table('tb_modem')->get();
        $medkom = DB::table('tb_medkom')->get();
        $garduinduk = DB::table('tb_garduinduk')->get();
        $sectoral = DB::table('tb_sectoral')->get();
        $komkp = DB::table('tb_komkp')->get();
        $picmaster = DB::table('tb_picmaster')->get();
        $selectedPicms = json_decode($keypoint->id_picms, true) ?? [];

        return view('pages.keypoint.edit', compact('keypoint', 'merklbs', 'modems', 'medkom', 'garduinduk', 'sectoral', 'komkp', 'picmaster', 'selectedPicms'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Find the keypoint record
        $keypoint = Keypoint::findOrFail($id);

        // Preprocess id_picms to ensure it's an array
        $idPicmsInput = $request->input('id_picms', '');
        $idPicmsArray = !empty($idPicmsInput) ? array_filter(array_map('trim', explode(',', $idPicmsInput))) : [];

        // Define array fields that come from checkboxes
        $arrayFields = [
            's_cb',
            's_cb2',
            's_lr',
            's_door',
            's_acf',
            's_dcf',
            's_dcd',
            's_hlt',
            's_sf6',
            's_fir',
            's_fis',
            's_fit',
            's_fin',
            's_comf',
            's_lruf',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst'
        ];

        // Define valid checkbox values
        $validCheckboxValues = [
            'open_1',
            'open_2',
            'open_3',
            'open_4',
            'open_5',
            'close_1',
            'close_2',
            'close_3',
            'close_4',
            'close_5',
            'local_1',
            'local_2',
            'local_3',
            'local_4',
            'local_5',
            'remote_1',
            'remote_2',
            'remote_3',
            'remote_4',
            'remote_5',
            'dropen_1',
            'dropen_2',
            'dropen_3',
            'dropen_4',
            'dropen_5',
            'drclose_1',
            'drclose_2',
            'drclose_3',
            'drclose_4',
            'drclose_5',
            'acnrml_1',
            'acnrml_2',
            'acnrml_3',
            'acnrml_4',
            'acnrml_5',
            'acfail_1',
            'acfail_2',
            'acfail_3',
            'acfail_4',
            'acfail_5',
            'dcnrml_1',
            'dcnrml_2',
            'dcnrml_3',
            'dcnrml_4',
            'dcnrml_5',
            'dcfail_1',
            'dcfail_2',
            'dcfail_3',
            'dcfail_4',
            'dcfail_5',
            'dcfnrml_1',
            'dcfnrml_2',
            'dcfnrml_3',
            'dcfnrml_4',
            'dcfnrml_5',
            'dcffail_1',
            'dcffail_2',
            'dcffail_3',
            'dcffail_4',
            'dcffail_5',
            'hlton_1',
            'hlton_2',
            'hlton_3',
            'hlton_4',
            'hlton_5',
            'hltoff_1',
            'hltoff_2',
            'hltoff_3',
            'hltoff_4',
            'hltoff_5',
            'sf6nrml_1',
            'sf6nrml_2',
            'sf6nrml_3',
            'sf6nrml_4',
            'sf6nrml_5',
            'sf6fail_1',
            'sf6fail_2',
            'sf6fail_3',
            'sf6fail_4',
            'sf6fail_5',
            'firnrml_1',
            'firnrml_2',
            'firnrml_3',
            'firnrml_4',
            'firnrml_5',
            'firfail_1',
            'firfail_2',
            'firfail_3',
            'firfail_4',
            'firfail_5',
            'fisnrml_1',
            'fisnrml_2',
            'fisnrml_3',
            'fisnrml_4',
            'fisnrml_5',
            'fisfail_1',
            'fisfail_2',
            'fisfail_3',
            'fisfail_4',
            'fisfail_5',
            'fitnrml_1',
            'fitnrml_2',
            'fitnrml_3',
            'fitnrml_4',
            'fitnrml_5',
            'fitfail_1',
            'fitfail_2',
            'fitfail_3',
            'fitfail_4',
            'fitfail_5',
            'finnrml_1',
            'finnrml_2',
            'finnrml_3',
            'finnrml_4',
            'finnrml_5',
            'finfail_1',
            'finfail_2',
            'finfail_3',
            'finfail_4',
            'finfail_5',
            'comf_nrml_1',
            'comf_nrml_2',
            'comf_nrml_3',
            'lruf_nrml_1',
            'lruf_nrml_2',
            'lruf_nrml_5',
            'cbctrl_op_1',
            'cbctrl_op_2',
            'cbctrl_op_3',
            'cbctrl_op_4',
            'cbctrl_op_5',
            'cbctrl_cl_1',
            'cbctrl_cl_2',
            'cbctrl_cl_3',
            'cbctrl_cl_4',
            'cbctrl_cl_5',
            'cbctrl2_op_1',
            'cbctrl2_op_2',
            'cbctrl2_op_3',
            'cbctrl2_op_4',
            'cbctrl2_op_5',
            'cbctrl2_cl_1',
            'cbctrl2_cl_2',
            'cbctrl2_cl_3',
            'cbctrl2_cl_4',
            'cbctrl2_cl_5',
            'hltctrl_off_1',
            'hltctrl_off_2',
            'hltctrl_off_3',
            'hltctrl_off_4',
            'hltctrl_off_5',
            'hltctrl_on_1',
            'hltctrl_on_2',
            'hltctrl_on_3',
            'hltctrl_on_4',
            'hltctrl_on_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        // Validation rules
        $validated = $request->validate([
            'id_formkp' => 'required|integer|exists:tb_formkp,id_formkp',
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => 'required|string|max:25',
            'nama_peny' => 'required|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'vr_rtu' => 'required|string|max:10',
            'vr_ms' => 'required|string|max:10',
            'vr_scale' => 'required|string|max:10',
            'vs_rtu' => 'required|string|max:10',
            'vs_ms' => 'required|string|max:10',
            'vs_scale' => 'required|string|max:10',
            'vt_rtu' => 'required|string|max:10',
            'vt_ms' => 'required|string|max:10',
            'vt_scale' => 'required|string|max:10',
            'sign_kp' => 'required|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'required|string|max:10',
            'id_picms' => ['required', function ($attribute, $value, $fail) use ($idPicmsArray) {
                if (empty($idPicmsArray)) {
                    $fail('The id picms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate array fields separately
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            // Set empty string for array fields if not present or empty
            $validated[$field] = $request->has($field) && is_array($request->input($field)) && !empty($request->input($field))
                ? implode(',', array_filter($request->input($field)))
                : '';
        }

        // Merge preprocessed id_picms array into validated data
        $validated['id_picms'] = json_encode($idPicmsArray);

        // Update the record
        $keypoint->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }


    public function clone($id)
    {
        try {
            $keypoint = Keypoint::findOrFail($id);
            $merklbs = DB::table('tb_merklbs')->get();
            $modems = DB::table('tb_modem')->get();
            $medkom = DB::table('tb_medkom')->get();
            $garduinduk = DB::table('tb_garduinduk')->get();
            $sectoral = DB::table('tb_sectoral')->get();
            $komkp = DB::table('tb_komkp')->get();
            $picmaster = DB::table('tb_picmaster')->get();
            $selectedPicms = json_decode($keypoint->id_picms, true) ?? [];

            return view('pages.keypoint.clone', compact(
                'keypoint',
                'merklbs',
                'modems',
                'medkom',
                'garduinduk',
                'sectoral',
                'komkp',
                'picmaster',
                'selectedPicms'
            ));
        } catch (\Exception $e) {
            Log::error('Error in clone method: ' . $e->getMessage());
            return redirect()->route('keypoint.index')->with('error', 'Failed to load clone form: ' . $e->getMessage());
        }
    }

    /**
     * Store a newly cloned keypoint in the database.
     */
    public function storeClone(Request $request)
    {
        // Preprocess id_picms to ensure it's an array
        $idPicmsInput = $request->input('id_picms', '');
        $idPicmsArray = !empty($idPicmsInput) ? array_filter(array_map('trim', explode(',', $idPicmsInput))) : [];

        // Define array fields that come from checkboxes
        $arrayFields = [
            's_cb',
            's_cb2',
            's_lr',
            's_door',
            's_acf',
            's_dcf',
            's_dcd',
            's_hlt',
            's_sf6',
            's_fir',
            's_fis',
            's_fit',
            's_fin',
            's_comf',
            's_lruf',
            'c_cb',
            'c_cb2',
            'c_hlt',
            'c_rst'
        ];

        // Define valid checkbox values
        $validCheckboxValues = [
            'open_1',
            'open_2',
            'open_3',
            'open_4',
            'open_5',
            'close_1',
            'close_2',
            'close_3',
            'close_4',
            'close_5',
            'local_1',
            'local_2',
            'local_3',
            'local_4',
            'local_5',
            'remote_1',
            'remote_2',
            'remote_3',
            'remote_4',
            'remote_5',
            'dropen_1',
            'dropen_2',
            'dropen_3',
            'dropen_4',
            'dropen_5',
            'drclose_1',
            'drclose_2',
            'drclose_3',
            'drclose_4',
            'drclose_5',
            'acnrml_1',
            'acnrml_2',
            'acnrml_3',
            'acnrml_4',
            'acnrml_5',
            'acfail_1',
            'acfail_2',
            'acfail_3',
            'acfail_4',
            'acfail_5',
            'dcnrml_1',
            'dcnrml_2',
            'dcnrml_3',
            'dcnrml_4',
            'dcnrml_5',
            'dcfail_1',
            'dcfail_2',
            'dcfail_3',
            'dcfail_4',
            'dcfail_5',
            'dcfnrml_1',
            'dcfnrml_2',
            'dcfnrml_3',
            'dcfnrml_4',
            'dcfnrml_5',
            'dcffail_1',
            'dcffail_2',
            'dcffail_3',
            'dcffail_4',
            'dcffail_5',
            'hlton_1',
            'hlton_2',
            'hlton_3',
            'hlton_4',
            'hlton_5',
            'hltoff_1',
            'hltoff_2',
            'hltoff_3',
            'hltoff_4',
            'hltoff_5',
            'sf6nrml_1',
            'sf6nrml_2',
            'sf6nrml_3',
            'sf6nrml_4',
            'sf6nrml_5',
            'sf6fail_1',
            'sf6fail_2',
            'sf6fail_3',
            'sf6fail_4',
            'sf6fail_5',
            'firnrml_1',
            'firnrml_2',
            'firnrml_3',
            'firnrml_4',
            'firnrml_5',
            'firfail_1',
            'firfail_2',
            'firfail_3',
            'firfail_4',
            'firfail_5',
            'fisnrml_1',
            'fisnrml_2',
            'fisnrml_3',
            'fisnrml_4',
            'fisnrml_5',
            'fisfail_1',
            'fisfail_2',
            'fisfail_3',
            'fisfail_4',
            'fisfail_5',
            'fitnrml_1',
            'fitnrml_2',
            'fitnrml_3',
            'fitnrml_4',
            'fitnrml_5',
            'fitfail_1',
            'fitfail_2',
            'fitfail_3',
            'fitfail_4',
            'fitfail_5',
            'finnrml_1',
            'finnrml_2',
            'finnrml_3',
            'finnrml_4',
            'finnrml_5',
            'finfail_1',
            'finfail_2',
            'finfail_3',
            'finfail_4',
            'finfail_5',
            'comf_nrml_1',
            'comf_nrml_2',
            'comf_nrml_3',
            'lruf_nrml_1',
            'lruf_nrml_2',
            'lruf_nrml_5',
            'cbctrl_op_1',
            'cbctrl_op_2',
            'cbctrl_op_3',
            'cbctrl_op_4',
            'cbctrl_op_5',
            'cbctrl_cl_1',
            'cbctrl_cl_2',
            'cbctrl_cl_3',
            'cbctrl_cl_4',
            'cbctrl_cl_5',
            'cbctrl2_op_1',
            'cbctrl2_op_2',
            'cbctrl2_op_3',
            'cbctrl2_op_4',
            'cbctrl2_op_5',
            'cbctrl2_cl_1',
            'cbctrl2_cl_2',
            'cbctrl2_cl_3',
            'cbctrl2_cl_4',
            'cbctrl2_cl_5',
            'hltctrl_off_1',
            'hltctrl_off_2',
            'hltctrl_off_3',
            'hltctrl_off_4',
            'hltctrl_off_5',
            'hltctrl_on_1',
            'hltctrl_on_2',
            'hltctrl_on_3',
            'hltctrl_on_4',
            'hltctrl_on_5',
            'rrctrl_on_1',
            'rrctrl_on_2',
            'rrctrl_on_3',
            'rrctrl_on_4',
            'rrctrl_on_5',
            'normal',
            'ok',
            'nok',
            'log',
            'sld',
            'tidak_uji'
        ];

        // Validation rules (aligned with store/update)
        $validated = $request->validate([
            'tgl_komisioning' => 'required|date',
            'nama_lbs' => 'required|string|max:50',
            'id_merkrtu' => 'required|integer|exists:tb_merklbs,id_merkrtu',
            'id_modem' => 'required|integer|exists:tb_modem,id_modem',
            'rtu_addrs' => 'required|string|max:255',
            'id_medkom' => 'required|integer|exists:tb_medkom,id_medkom',
            'ip_kp' => 'required|string|max:255',
            'id_gi' => 'required|string|max:25',
            'nama_peny' => 'required|string|max:25',
            'id_sec' => 'required|integer|exists:tb_sectoral,id_sec',
            'ir_rtu' => 'required|integer',
            'ir_ms' => 'required|integer',
            'ir_scale' => 'required|string|max:10',
            'is_rtu' => 'required|integer',
            'is_ms' => 'required|integer',
            'is_scale' => 'required|string|max:10',
            'it_rtu' => 'required|integer',
            'it_ms' => 'required|integer',
            'it_scale' => 'required|string|max:10',
            'vr_rtu' => 'required|string|max:10',
            'vr_ms' => 'required|string|max:10',
            'vr_scale' => 'required|string|max:10',
            'vs_rtu' => 'required|string|max:10',
            'vs_ms' => 'required|string|max:10',
            'vs_scale' => 'required|string|max:10',
            'vt_rtu' => 'required|string|max:10',
            'vt_ms' => 'required|string|max:10',
            'vt_scale' => 'required|string|max:10',
            'sign_kp' => 'required|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'required|string|max:10',
            'id_picms' => ['required', function ($attribute, $value, $fail) use ($idPicmsArray) {
                if (empty($idPicmsArray)) {
                    $fail('The id picms field must be an array and cannot be empty.');
                }
            }],
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ]);

        // Validate and process array fields
        foreach ($arrayFields as $field) {
            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $validCheckboxValues),
            ]);
            $value = $request->input($field);
            $validated[$field] = (is_array($value) && !empty(array_filter($value)))
                ? implode(',', array_filter($value))
                : '';
        }

        // Merge preprocessed id_picms array into validated data
        $validated['id_picms'] = json_encode($idPicmsArray);
        $validated['nama_user'] = Auth::user()->nama_admin;

        try {
            Keypoint::create($validated); // Create new record instead of update
            return redirect()->route('keypoint.index')->with('success', 'Keypoint cloned successfully.');
        } catch (\Exception $e) {
            Log::error('Error in storeClone method: ' . $e->getMessage());
            return redirect()->back()->withInput()->with('error', 'Failed to clone keypoint: ' . $e->getMessage());
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $keypoint = Keypoint::findOrFail($id);
        $keypoint->delete();

        return redirect()->route('keypoint.index')->with('success', 'Keypoint deleted successfully!');
    }

}