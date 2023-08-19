<?php

namespace Modules\Izin\Http\Controllers;

use App\Models\PersetujuanIzin;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PersetujuanIzinController extends Controller
{

    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_guru = PersetujuanIzin::getDataGuru();
        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $id_user = request()->id_user;
            $data = PersetujuanIzin::getData($bulan, $tahun, $id_user);
            return response()->json($data);
        }
        return view('izin::persetujuan_izin.index', compact('daftar_bulan', 'daftar_guru'));
    }

    public function store()
    {
        request()->id_user_konfirmasi = Auth::id();

        $data = PersetujuanIzin::simpanData(request());
        return Response()->json($data);
    }
}
