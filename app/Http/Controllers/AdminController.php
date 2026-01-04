<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::all(); // Fetch all admin records
        return view('pages.admin.index', compact('admins')); // Pass admins to the view
    }

    /**
     * Show the form for adding a new resource.
     */
    public function add()
    {
        return view('pages.admin.add');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Log::info('Store method called', ['input' => $request->all()]);
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tb_admin',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'nama_admin' => $request->nama_admin,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'temp_password' => $request->password, // Store plain-text password
        ]);

        Log::info('Registration successful for user: ', ['id' => $admin->id_admin]);
        return redirect()->route('admin.index')->with('success', '✅ Admin berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        return view('pages.admin.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        return view('pages.admin.edit', compact('admin')); // Return the edit form view
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tb_admin,username,' . $admin->id_admin . ',id_admin',
            'password' => 'nullable|string|min:6',
        ]);

        $admin->update([
            'nama_admin' => $request->nama_admin,
            'username' => $request->username,
            'password' => $request->password ? Hash::make($request->password) : $admin->password,
            'temp_password' => $request->password ? $request->password : $admin->temp_password, // Update temp_password if new password provided
        ]);

        Log::info('Admin updated successfully: ', ['id' => $admin->id_admin]);
        return redirect()->route('admin.index')->with('success', '✅ Admin berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Admin $admin)
    {
        $admin->delete();
        Log::info('Admin deleted successfully: ', ['id' => $admin->id_admin]);
        return redirect()->route('admin.index')->with('success', '✅ Admin berhasil dihapus!');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');
        Log::info('Login attempt with credentials: ', ['username' => $credentials['username']]);

        if (Auth::guard('admin')->attempt($credentials)) {
            $admin = Auth::guard('admin')->user();
            Log::info('Login successful for user: ', ['id' => $admin->id_admin, 'username' => $admin->username]);
            Session::put('admin_id', $admin->id_admin);
            return redirect()->route('dashboard')->with('success', '✅ Login berhasil!');
        }

        Log::error('Login failed for username: ', ['username' => $credentials['username']]);
        return redirect()->back()->with('error', '⚠️ Username atau password salah!');
    }

    /**
     * Handle register request
     */
    public function register(Request $request)
    {
        $request->validate([
            'nama_admin' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:tb_admin',
            'password' => 'required|string|min:6',
        ]);

        $admin = Admin::create([
            'nama_admin' => $request->nama_admin,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'temp_password' => $request->password, // Store plain-text password
        ]);

        Log::info('Registration successful for user: ', ['id' => $admin->id_admin]);
        return redirect()->route('login')->with('success', '✅ Registrasi berhasil! Silakan login.');
    }

    /**
     * Handle logout request
     */
    public function logout()
    {
        Auth::guard('admin')->logout();
        Session::flush();
        return redirect()->route('login')->with('success', '✅ Logout berhasil!');
    }

    public function dashboard(Request $request)
    {
        // Find the latest date from both tables to set intelligent defaults
        $latestKp = DB::table('tb_formkp')->max('tgl_komisioning');
        $latestPeny = DB::table('tb_formpeny')->max('tgl_kom');
        $latestDateStr = $latestKp && $latestPeny ? max($latestKp, $latestPeny) : ($latestKp ?: ($latestPeny ?: null));

        $defaultDate = $latestDateStr ? Carbon::parse($latestDateStr) : Carbon::now();

        // Get selected date or default to latest or today
        $selectedDate = $request->get('date');
        $selectedDate = $selectedDate ?: $defaultDate->format('Y-m-d');

        $selectedMonth = $request->get('month');
        $selectedMonth = $selectedMonth ?: $defaultDate->format('Y-m');

        // Parse with error handling
        try {
            $date = Carbon::parse($selectedDate);
            $displayDate = $date->format('d F Y');
        } catch (\Exception $e) {
            Log::error('Invalid date format', ['date' => $selectedDate, 'error' => $e->getMessage()]);
            $date = $defaultDate;
            $displayDate = $date->format('d F Y');
            $selectedDate = $date->format('Y-m-d');
        }

        try {
            $monthDate = Carbon::parse($selectedMonth . '-01');
            $monthStart = $monthDate->startOfMonth();
            $monthEnd = $monthDate->endOfMonth();
            $displayMonth = $monthDate->format('F Y');
        } catch (\Exception $e) {
            Log::error('Invalid month format', ['month' => $selectedMonth, 'error' => $e->getMessage()]);
            $monthDate = $defaultDate->startOfMonth();
            $monthStart = $monthDate->startOfMonth();
            $monthEnd = $monthDate->endOfMonth();
            $displayMonth = $monthDate->format('F Y');
            $selectedMonth = $monthDate->format('Y-m');
        }

        // ========== KEYPOINT STATISTICS (tb_formkp) ==========
        $keypointTotal = DB::table('tb_formkp')->count();

        $keypointDaily = DB::table('tb_formkp')
            ->whereDate('tgl_komisioning', $date->format('Y-m-d'))
            ->count();

        $keypointMonthly = DB::table('tb_formkp')
            ->where('tgl_komisioning', '>=', $monthStart)
            ->where('tgl_komisioning', '<=', $monthEnd->endOfDay())
            ->count();

        // Keypoint by Gardu Induk
        $keypointGarduIndukDaily = DB::table('tb_formkp')
            ->whereDate('tgl_komisioning', $date->format('Y-m-d'))
            ->whereNotNull('id_gi')
            ->where('id_gi', '!=', '')
            ->count();

        $keypointGarduIndukMonthly = DB::table('tb_formkp')
            ->where('tgl_komisioning', '>=', $monthStart)
            ->where('tgl_komisioning', '<=', $monthEnd->endOfDay())
            ->whereNotNull('id_gi')
            ->where('id_gi', '!=', '')
            ->count();

        // Keypoint by Sectoral
        $keypointSectoralDaily = DB::table('tb_formkp')
            ->whereDate('tgl_komisioning', $date->format('Y-m-d'))
            ->whereNotNull('id_sec')
            ->where('id_sec', '!=', '')
            ->count();

        $keypointSectoralMonthly = DB::table('tb_formkp')
            ->where('tgl_komisioning', '>=', $monthStart)
            ->where('tgl_komisioning', '<=', $monthEnd->endOfDay())
            ->whereNotNull('id_sec')
            ->where('id_sec', '!=', '')
            ->count();

        // ========== PENYULANG STATISTICS (tb_formpeny) ==========
        $penyulangTotal = DB::table('tb_formpeny')->count();

        $penyulangDaily = DB::table('tb_formpeny')
            ->whereDate('tgl_kom', $date->format('Y-m-d'))
            ->count();

        $penyulangMonthly = DB::table('tb_formpeny')
            ->where('tgl_kom', '>=', $monthStart)
            ->where('tgl_kom', '<=', $monthEnd->endOfDay())
            ->count();

        // Penyulang by Gardu Induk
        $penyulangGarduIndukDaily = DB::table('tb_formpeny')
            ->whereDate('tgl_kom', $date->format('Y-m-d'))
            ->whereNotNull('id_gi')
            ->where('id_gi', '!=', '')
            ->count();

        $penyulangGarduIndukMonthly = DB::table('tb_formpeny')
            ->where('tgl_kom', '>=', $monthStart)
            ->where('tgl_kom', '<=', $monthEnd->endOfDay())
            ->whereNotNull('id_gi')
            ->where('id_gi', '!=', '')
            ->count();

        // Penyulang by RTU GI
        $penyulangRtuGiDaily = DB::table('tb_formpeny')
            ->whereDate('tgl_kom', $date->format('Y-m-d'))
            ->whereNotNull('id_rtugi')
            ->where('id_rtugi', '>', 0)
            ->count();

        $penyulangRtuGiMonthly = DB::table('tb_formpeny')
            ->where('tgl_kom', '>=', $monthStart)
            ->where('tgl_kom', '<=', $monthEnd->endOfDay())
            ->whereNotNull('id_rtugi')
            ->where('id_rtugi', '>', 0)
            ->count();

        return view('pages.dashboard.index', compact(
            'selectedDate',
            'selectedMonth',
            'displayMonth',
            'displayDate',
            'keypointTotal',
            'keypointDaily',
            'keypointMonthly',
            'keypointGarduIndukDaily',
            'keypointGarduIndukMonthly',
            'keypointSectoralDaily',
            'keypointSectoralMonthly',
            'penyulangTotal',
            'penyulangDaily',
            'penyulangMonthly',
            'penyulangGarduIndukDaily',
            'penyulangGarduIndukMonthly',
            'penyulangRtuGiDaily',
            'penyulangRtuGiMonthly',
            'monthStart',
            'monthEnd'
        ));
    }
}
