<?php

namespace Modules\Izin\Http\Controllers;

use App\Models\Izin;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class IzinController extends Controller
{

    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_guru = Izin::getDataGuru();

        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $guru = request()->guru;

            $data = Izin::getData($bulan, $tahun, $guru);
            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(' . $row->id . ')" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->tanggal));
                })
                ->editColumn('dari_jam', function ($row) {
                    return date('H:i', strtotime($row->dari_jam)) . " - " . date('H:i', strtotime($row->sampai_jam));
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
                        case "2":
                            return '<span class="badge bg-danger">ditolak</span><br><span><a href="javascript:void(0)" onclick="detailPenolakan(\'' . $row->alasan_penolakan . '\')"><u>lihat alasan</u></a></span>';
                            break;
                        default:
                            return "<span class='badge bg-danger'>tidak diketahui</span>";
                    }
                })
                ->addColumn('status_export', function ($row) {
                    switch ($row->status) {
                        case "0":
                            return "menunggu persetujuan";
                            break;
                        case "1":
                            return "disetujui";
                            break;
                        case "2":
                            return "ditolak";
                            break;
                        default:
                            return 'tidak diketahui';
                    }
                })
                ->rawColumns(['bukti_foto', 'status', 'aksi'])
                ->toJson();
        }

        return view('izin::izin.index', compact('daftar_bulan', 'daftar_guru'));
    }

    public function destroy($id)
    {
        $data = Izin::deleteData($id);
        return Response()->json($data);
    }
}
