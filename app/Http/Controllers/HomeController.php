<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $isSuperAdmin = $user->hasRole('super_admin');

        $stats = [
            'total_users' => 0,
            'rapat_bulan_ini' => 0,
            'total_kegiatan' => 0,
            'kehadiran_saya' => 0,
            'survey_aktif' => 0,
        ];

        if ($isSuperAdmin) {
            $stats['total_users'] = \App\Models\User::count();
            $stats['rapat_bulan_ini'] = \App\Models\Rapat::whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->count();
            $stats['total_kegiatan'] = \App\Models\Presence::count();
            $stats['survey_aktif'] = \App\Models\Survey::where('status', 'Aktif')->count();
        } else {
            $stats['kehadiran_saya'] = \App\Models\PresenceDetail::where('user_id', $user->id)->count();
            $stats['rapat_bulan_ini'] = \App\Models\Rapat::where('user_id', $user->id)
                ->whereMonth('tanggal', date('m'))
                ->whereYear('tanggal', date('Y'))
                ->count();
            $stats['survey_aktif'] = \App\Models\Survey::where('status', 'Aktif')->count();
        }

        return view('home', compact('stats', 'isSuperAdmin'));
    }
}
