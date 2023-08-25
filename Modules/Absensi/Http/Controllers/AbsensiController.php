<?php

namespace Modules\Absensi\Http\Controllers;

use App\Models\Absensi;
use App\Models\Instansi;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class AbsensiController extends Controller
{

    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_guru = Absensi::getDataGuru();

        if (request()->ajax()) {
            $bulan = request()->bulan;
            $tahun = request()->tahun;
            $guru = request()->guru;

            $data = Absensi::getData($bulan, $tahun, $guru);
            $instansi = Instansi::getData();
            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(' . $row->id . ')" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->tanggal));
                })
                ->addColumn('hari', function ($row) {
                    $date =  date('l', strtotime($row->tanggal));
                    switch ($date) {
                        case "Monday":
                            return "Senin";
                            break;
                        case "Tuesday":
                            return "Selasa";
                            break;
                        case "Wednesday":
                            return "Rabu";
                            break;
                        case "Thursday":
                            return "Kamis";
                            break;
                        case "Friday":
                            return "Jum'at";
                            break;
                        case "Saturday":
                            return "Sabtu";
                            break;
                        case "Sunday":
                            return "Minggu";
                            break;
                        default:
                            return 'tidak diketahui';
                    }
                })
                ->editColumn('jam_masuk', function ($row) use ($instansi) {
                    $status_lokasi_masuk = $row->status_lokasi_masuk == 1 ? 'didalam radius' : 'diluar radius';
                    $detail = '<div>' . date('H:i', strtotime($row->jam_masuk)) . '</div>';
                    $detail .= '<span><a href="javascript:void(0)" onclick="detailBerkas(\'' . $row->foto_masuk . '\',\'' . $row->latitude_masuk . '\',\'' . $row->longitude_masuk . '\',\'' . $instansi->latitude . '\',\'' . $instansi->longitude . '\',\'' . $instansi->radius_absensi . '\',\'' . $status_lokasi_masuk . '\')"><u>lihat berkas</u></a></span>';
                    return $detail;
                })
                ->editColumn('jam_pulang', function ($row) use ($instansi) {
                    if ($row->jam_pulang != null) {
                        $status_lokasi_pulang = $row->status_lokasi_pulang == 1 ? 'didalam radius' : 'diluar radius';
                        $detail = '<div>' . date('H:i', strtotime($row->jam_pulang)) . '</div>';
                        $detail .= '<span><a href="javascript:void(0)" onclick="detailBerkas(\'' . $row->foto_pulang . '\',\'' . $row->latitude_pulang . '\',\'' . $row->longitude_pulang . '\',\'' . $instansi->latitude . '\',\'' . $instansi->longitude . '\',\'' . $instansi->radius_absensi . '\',\'' . $status_lokasi_pulang . '\')"><u>lihat berkas</u></a></span>';
                        return $detail;
                    } else {
                        return "-";
                    }
                })
                ->addColumn('jam_kerja', function ($row) {
                    if ($row->jam_pulang != null) {
                        // Mengubah waktu masuk dan waktu keluar menjadi timestamp
                        $timestamp_masuk = strtotime($row->jam_masuk);
                        $timestamp_keluar = strtotime($row->jam_pulang);

                        // Menghitung selisih waktu dalam detik
                        $selisih_detik = $timestamp_keluar - $timestamp_masuk;

                        // Menghitung jam, menit, dan detik dari selisih
                        $jam = floor($selisih_detik / 3600);
                        $sisa_detik = $selisih_detik % 3600;
                        $menit = floor($sisa_detik / 60);

                        return $jam . " jam " . $menit . " menit ";
                    } else {
                        return "-";
                    }
                })
                ->editColumn('status_absensi', function ($row) {
                    switch ($row->status_absensi) {
                        case "1":
                            return '<b><span class="text-success">&#10004;</span></b>';
                            break;
                        case "2":
                            return '<b><span class="text-warning">&#10004;</span></b>';
                            break;
                        case "2":
                            return '<b><span class="text-danger">&#10004;</span></b>';
                            break;
                        default:
                            return '<b><span class="text-dark">-</span></b>';
                    }
                })
                ->addColumn('jam_masuk_export', function ($row) {
                    return date('H:i', strtotime($row->jam_masuk));
                })
                ->addColumn('jam_pulang_export', function ($row) {
                    if ($row->jam_pulang != null) {
                        return date('H:i', strtotime($row->jam_pulang));
                    } else {
                        return '-';
                    }
                })
                ->addColumn('status_export', function ($row) {
                    switch ($row->status_absensi) {
                        case "1":
                            return "tepat waktu";
                            break;
                        case "2":
                            return "terlambat dengan toleransi";
                            break;
                        case "3":
                            return "terlambat tanpa toleransi";
                            break;
                        default:
                            return 'tidak hadir';
                    }
                })
                ->addColumn('status_lokasi_masuk_export', function ($row) {
                    $status_lokasi_masuk = $row->status_lokasi_masuk == 1 ? 'didalam radius' : 'diluar radius';
                    return $status_lokasi_masuk;
                })
                ->addColumn('status_lokasi_pulang_export', function ($row) {
                    if ($row->status_lokasi_pulang != null) {
                        $status_lokasi_pulang = $row->status_lokasi_pulang == 1 ? 'didalam radius' : 'diluar radius';
                    } else {
                        $status_lokasi_pulang = '-';
                    }
                    return $status_lokasi_pulang;
                })
                ->rawColumns(['jam_masuk', 'jam_pulang', 'status_absensi', 'aksi'])
                ->toJson();
        }

        return view('absensi::absensi.index', compact('daftar_bulan', 'daftar_guru'));
    }
}
