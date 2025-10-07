<?php

namespace App\Http\Controllers;

use App\Models\Keypoint;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Routing\Controller;

class KeypointController extends Controller
{
    use AuthorizesRequests;

    // Define array fields for checkboxes
    private const ARRAY_FIELDS = [
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

    // Define valid checkbox options (removed 'normal' as it has no value)
    private const CHECKBOX_OPTIONS = ['','ok', 'nok', 'log', 'sld', 'tidak_uji'];

    private const SPECIAL_CHECKBOX_FIELDS = ['s_comf', 's_lruf'];
    private const SPECIAL_CHECKBOX_OPTIONS = ['ok', 'nok', 'tidak_ada'];

    /**
     * Get validation rules for store, update, and storeClone methods.
     *
     * @return array
     */
    private function getValidationRules(): array
    {
        return [
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
            'vr_rtu' => 'nullable|numeric',
            'vr_ms' => 'nullable|numeric',
            'vr_scale' => 'nullable|string|max:10',
            'vs_rtu' => 'nullable|numeric',
            'vs_ms' => 'nullable|numeric',
            'vs_scale' => 'nullable|string|max:10',
            'vt_rtu' => 'nullable|numeric',
            'vt_ms' => 'nullable|numeric',
            'vt_scale' => 'nullable|string|max:10',
            'sign_kp' => 'nullable|string|max:10',
            'id_komkp' => 'required|integer|exists:tb_komkp,id_komkp',
            'nama_user' => 'nullable|string|max:10',
            'id_picms' => 'required|integer|exists:tb_picmaster,id_picmaster',
            'pelrtu' => 'required|string|max:25',
            'ketkp' => 'required|string|max:500',
        ];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // $this->authorize('viewAny', Keypoint::class);

        $keypoints = Keypoint::select([
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
        ])->get();

        return view('pages.keypoint.index', compact('keypoints'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        // $this->authorize('create', Keypoint::class);

        $data = $this->getFormData();
        return view('pages.keypoint.add', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        // $this->authorize('create', Keypoint::class);

        // Validate input
        $validated = $request->validate($this->getValidationRules());

        // Validate checkbox fields
        foreach (self::ARRAY_FIELDS as $field) {
            $options = in_array($field, self::SPECIAL_CHECKBOX_FIELDS)
                ? self::SPECIAL_CHECKBOX_OPTIONS
                : self::CHECKBOX_OPTIONS;

            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $options),
            ]);
        }

        // Process array fields: implode into comma-separated string
        foreach (self::ARRAY_FIELDS as $field) {
            $validated[$field] = $request->has($field) && !empty($request->input($field))
                ? implode(',', $request->input($field))
                : '';
        }

        // Transform text fields to uppercase
        $validated['nama_lbs'] = strtoupper($validated['nama_lbs']);
        $validated['nama_peny'] = strtoupper($validated['nama_peny'] ?? '');
        $validated['pelrtu'] = strtoupper($validated['pelrtu']);
        $validated['ketkp'] = strtoupper($validated['ketkp']);

        // Create the record
        Keypoint::create($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint created successfully!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Keypoint  $keypoint
     * @return \Illuminate\View\View
     */
    public function show(Keypoint $keypoint)
    {
        // $this->authorize('view', $keypoint);
        return view('pages.keypoint.show', compact('keypoint'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Keypoint  $keypoint
     * @return \Illuminate\View\View
     */
    public function edit(Keypoint $keypoint)
    {
        // $this->authorize('update', $keypoint);

        $data = $this->getFormData();
        $data['keypoint'] = $this->prepareKeypointForForm($keypoint);

        return view('pages.keypoint.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Keypoint  $keypoint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Keypoint $keypoint)
    {
        // $this->authorize('update', $keypoint);

        // Validate input
        $validated = $request->validate($this->getValidationRules());

        // Validate checkbox fields
        foreach (self::ARRAY_FIELDS as $field) {
            $options = in_array($field, self::SPECIAL_CHECKBOX_FIELDS)
                ? self::SPECIAL_CHECKBOX_OPTIONS
                : self::CHECKBOX_OPTIONS;

            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $options),
            ]);
        }

        // Process array fields: implode into comma-separated string
        foreach (self::ARRAY_FIELDS as $field) {
            $validated[$field] = $request->has($field) && !empty($request->input($field))
                ? implode(',', $request->input($field))
                : '';
        }

        // Transform text fields to uppercase
        $validated['nama_lbs'] = strtoupper($validated['nama_lbs']);
        $validated['nama_peny'] = strtoupper($validated['nama_peny'] ?? '');
        $validated['pelrtu'] = strtoupper($validated['pelrtu']);
        $validated['ketkp'] = strtoupper($validated['ketkp']);

        // Update the record
        $keypoint->update($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Keypoint  $keypoint
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Keypoint $keypoint)
    {
        // $this->authorize('delete', $keypoint);

        $keypoint->delete();
        return redirect()->route('keypoint.index')->with('success', 'Keypoint deleted successfully!');
    }

    /**
     * Display notes for the specified resource.
     *
     * @param  \App\Models\Keypoint  $keypoint
     * @return \Illuminate\View\View
     */
    public function note(Keypoint $keypoint)
    {
        // $this->authorize('view', $keypoint);
        return view('pages.keypoint.note', compact('keypoint'));
    }

    /**
     * Show the form for cloning a keypoint.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function clone($id)
    {
        // $this->authorize('create', Keypoint::class);

        $keypoint = Keypoint::find($id);

        if (!$keypoint) {
            return redirect()->route('keypoint.index')->with('error', 'Keypoint not found.');
        }

        $data = $this->getFormData();
        $data['keypoint'] = $this->prepareKeypointForForm($keypoint);

        return view('pages.keypoint.clone', $data);
    }

    /**
     * Store a cloned keypoint.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeClone(Request $request, $id)
    {
        // $this->authorize('create', Keypoint::class);

        $keypoint = Keypoint::find($id);

        if (!$keypoint) {
            return redirect()->route('keypoint.index')->with('error', 'Keypoint not found.');
        }

        // Validate and create new record
        $validated = $request->validate($this->getValidationRules());

        // Validate checkbox fields
        foreach (self::ARRAY_FIELDS as $field) {
            $options = in_array($field, self::SPECIAL_CHECKBOX_FIELDS)
                ? self::SPECIAL_CHECKBOX_OPTIONS
                : self::CHECKBOX_OPTIONS;

            $request->validate([
                $field => 'nullable|array',
                $field . '.*' => 'string|in:' . implode(',', $options),
            ]);
        }

        // Process array fields
        foreach (self::ARRAY_FIELDS as $field) {
            $validated[$field] = $request->has($field) && !empty($request->input($field))
                ? implode(',', $request->input($field))
                : '';
        }

        // Transform text fields to uppercase
        $validated['nama_lbs'] = strtoupper($validated['nama_lbs']);
        $validated['nama_peny'] = strtoupper($validated['nama_peny'] ?? '');
        $validated['pelrtu'] = strtoupper($validated['pelrtu']);
        $validated['ketkp'] = strtoupper($validated['ketkp']);

        // Create new record
        Keypoint::create($validated);

        return redirect()->route('keypoint.index')->with('success', 'Keypoint cloned successfully!');
    }

    /**
     * Export a Keypoint record as a PDF.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Helper method to fetch common form data.
     *
     * @return array
     */
    private function getFormData(): array
    {
        return [
            'merklbs' => DB::table('tb_merklbs')->get(),
            'modems' => DB::table('tb_modem')->get(),
            'medkom' => DB::table('tb_medkom')->get(),
            'garduinduk' => DB::table('tb_garduinduk')->get(),
            'sectoral' => DB::table('tb_sectoral')->get(),
            'komkp' => DB::table('tb_komkp')->get(),
            'picmaster' => DB::table('tb_picmaster')->get(),
            'admin' => DB::table('tb_admin')->get(),
        ];
    }

    /**
     * Prepare keypoint data for form (explode array fields).
     *
     * @param  \App\Models\Keypoint  $keypoint
     * @return \App\Models\Keypoint
     */
    private function prepareKeypointForForm(Keypoint $keypoint): Keypoint
    {
        foreach (self::ARRAY_FIELDS as $field) {
            $keypoint->$field = $keypoint->$field ? explode(',', $keypoint->$field) : [];
        }
        return $keypoint;
    }
}
