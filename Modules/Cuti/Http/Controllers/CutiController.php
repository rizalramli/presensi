<?php

namespace Modules\Cuti\Http\Controllers;

use App\Models\Cuti;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class CutiController extends Controller
{

    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_guru = Cuti::getDataGuru();

        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $guru = request()->guru;

            $data = Cuti::getData($bulan, $tahun, $guru);
            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(' . $row->id . ')" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('dari_tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->dari_tanggal));
                })
                ->editColumn('sampai_tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->sampai_tanggal));
                })
                ->editColumn('lama_hari', function ($row) {
                    return $row->lama_hari . " Hari";
                })
                ->editColumn('bukti_foto', function ($row) {
                    return  '<span><a href="javascript:void(0)" onclick="detailBerkas(\'' . $row->bukti_foto . '\',\'' . $row->keterangan . '\')"><u>lihat berkas</u></a></span>';
                })
                ->editColumn('status', function ($row) {
                    switch ($row->status) {
                        case "0":
                            return "<span class='badge bg-warning'>menunggu persetujuan</span>";
                            break;
                        case "1":
                            return "<span class='badge bg-success'>disetujui</span>";
                            break;
                        default:
                            return '<span class="badge bg-danger">ditolak</span><br><span><a href="javascript:void(0)" onclick="detailPenolakan(\'' . $row->alasan_penolakan . '\')"><u>lihat alasan</u></a></span>';
                    }
                })
                ->rawColumns(['bukti_foto', 'status', 'aksi'])
                ->toJson();
        }

        return view('cuti::cuti.index', compact('daftar_bulan', 'daftar_guru'));
    }

    public function destroy($id)
    {
        $data = Cuti::deleteData($id);
        return Response()->json($data);
    }
}
