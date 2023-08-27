<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $id_user = Auth::id();
        $absensi_hari_ini = Absensi::getDataAbsensiHariIni($id_user, date('Y-m-d'));
        if (empty($absensi_hari_ini)) {
            $jam_masuk = '-';
            $jam_pulang = '-';
            $total_jam_kerja = '-';
        } else {
            $jam_masuk = date('H:i', strtotime($absensi_hari_ini->jam_masuk));
            if ($absensi_hari_ini->jam_pulang != null) {
                $jam_pulang = date('H:i', strtotime($absensi_hari_ini->jam_pulang));
                $timestamp_masuk = strtotime($absensi_hari_ini->jam_masuk);
                $timestamp_keluar = strtotime($absensi_hari_ini->jam_pulang != null ? $absensi_hari_ini->jam_pulang : date('H:i:s'));

                // Menghitung selisih waktu dalam detik
                $selisih_detik = $timestamp_keluar - $timestamp_masuk;

                // Menghitung jam, menit, dan detik dari selisih
                $jam = floor($selisih_detik / 3600);
                $sisa_detik = $selisih_detik % 3600;
                $menit = floor($sisa_detik / 60);

                $total_jam_kerja =  $jam . " jam " . $menit . " menit ";
            } else {
                $jam_pulang = '-';
                $jam_pulang = date('H:i');
                $timestamp_masuk = strtotime($absensi_hari_ini->jam_masuk);
                $timestamp_keluar = strtotime($absensi_hari_ini->jam_pulang != null ? $absensi_hari_ini->jam_pulang : date('H:i:s'));

                // Menghitung selisih waktu dalam detik
                $selisih_detik = $timestamp_keluar - $timestamp_masuk;

                // Menghitung jam, menit, dan detik dari selisih
                $jam = floor($selisih_detik / 3600);
                $sisa_detik = $selisih_detik % 3600;
                $menit = floor($sisa_detik / 60);

                $total_jam_kerja =  $jam . " jam " . $menit . " menit ";

                if ($absensi_hari_ini->tanggal != date('Y-m-d')) {
                    $total_jam_kerja = '-';
                }
            }
        }

        $instansi = Instansi::getData();
        $user = Auth::user();
        $role = $user->getRoleNames()->first();
        $absensi = (object)[
            'jam_masuk' => $jam_masuk,
            'jam_pulang' => $jam_pulang,
            'total_jam_kerja' => $total_jam_kerja
        ];

        return view('home', compact('instansi', 'absensi', 'role'));
    }

    public function index2()
    {
        return view('home2');
    }
}
