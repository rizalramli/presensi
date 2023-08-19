<?php

namespace Modules\Cuti\Http\Controllers;

use App\Models\PersetujuanCuti;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PersetujuanCutiController extends Controller
{
    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_guru = PersetujuanCuti::getDataGuru();

        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $id_user = request()->id_user;
            $data = PersetujuanCuti::getData($bulan, $tahun, $id_user);
            return response()->json($data);
        }

        return view('cuti::persetujuan_cuti.index', compact('daftar_bulan', 'daftar_guru'));
    }

    public function store()
    {
        request()->id_user_konfirmasi = Auth::id();

        $data = PersetujuanCuti::simpanData(request());
        return Response()->json($data);
    }
}
