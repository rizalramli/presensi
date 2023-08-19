<?php

namespace Modules\Cuti\Http\Controllers;

use App\Models\PengajuanCuti;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class PengajuanCutiController extends Controller
{
    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_jenis_cuti = PengajuanCuti::getDataJenisCuti();
        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $id_user = Auth::id();
            $data = PengajuanCuti::getData($bulan, $tahun, $id_user);
            return response()->json($data);
        }
        return view('cuti::pengajuan_cuti.index', compact('daftar_bulan', 'daftar_jenis_cuti'));
    }

    public function store()
    {
        if (request()->file('bukti_foto')) {
            $file = request()->file('bukti_foto');
            $file_name = 'cuti-' . time() . '.' . $file->extension();

            request()->file('bukti_foto')->move('assets/images/cuti', $file_name);

            request()->bukti_foto = $file_name;
        }

        request()->id_user = Auth::id();

        $data = PengajuanCuti::simpanData(request());
        return Response()->json($data);
    }
}
