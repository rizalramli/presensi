<?php

namespace Modules\Izin\Http\Controllers;

use App\Models\PengajuanIzin;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PengajuanIzinController extends Controller
{
    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_jenis_izin = PengajuanIzin::getDataJenisIzin();
        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $id_user = Auth::id();
            $data = PengajuanIzin::getData($bulan, $tahun, $id_user);
            return response()->json($data);
        }
        return view('izin::pengajuan_izin.index', compact('daftar_bulan', 'daftar_jenis_izin'));
    }

    public function store()
    {
        if (request()->file('bukti_foto')) {
            $file = request()->file('bukti_foto');
            $file_name = 'izin-' . time() . '.' . $file->extension();

            request()->file('bukti_foto')->move('assets/images/izin', $file_name);

            request()->bukti_foto = $file_name;
        }

        request()->id_user = Auth::id();

        $data = PengajuanIzin::simpanData(request());
        return Response()->json($data);
    }
}
