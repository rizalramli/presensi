<?php

namespace Modules\Absensi\Http\Controllers;

use App\Models\LaporanAbsensi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class LaporanAbsensiController extends Controller
{

    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $id_guru = Auth::id();

            $absensi = LaporanAbsensi::getData($bulan, $tahun, $id_guru);
            $cuti = LaporanAbsensi::getDataCuti($bulan, $tahun, $id_guru);
            $hari_libur_normal = LaporanAbsensi::getDataLiburNormal();
            $hari_libur_nasional = LaporanAbsensi::getDataLiburNasional($bulan, $tahun);

            $tanggalAwal = strtotime("$tahun-$bulan-01");
            $tanggalAkhir = strtotime("last day of $tahun-$bulan");

            $date = array();

            while ($tanggalAwal <= $tanggalAkhir) {
                $date[] = date('Y-m-d', $tanggalAwal);
                $tanggalAwal = strtotime('+1 day', $tanggalAwal);
            }

            return response()->json([
                'tanggal' => $date,
                'absensi' => $absensi,
                'cuti' => $cuti,
                'hari_libur_normal' => $hari_libur_normal,
                'hari_libur_nasional' => $hari_libur_nasional
            ]);
        }
        return view('absensi::laporan_absensi.index', compact('daftar_bulan'));
    }
}
