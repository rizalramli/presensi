<?php

namespace Modules\Absensi\Http\Controllers;

use App\Models\AbsensiMasuk;
use App\Models\Instansi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class MasukAbsensiController extends Controller
{
    public function index()
    {
        $id_user = Auth::id();
        $tanggal = date('Y-m-d');
        $hari = date('l');

        $is_absensi = AbsensiMasuk::IsAbsenHariIni($id_user, $tanggal);
        $is_cuti = AbsensiMasuk::IsCutiHariIni($id_user, $tanggal);
        $is_libur_normal = AbsensiMasuk::IsLiburNormal($hari);
        $is_libur_nasional = AbsensiMasuk::IsLiburNasional($tanggal);
        $instansi = Instansi::getData();

        return view('absensi::masuk_absensi.index', compact(
            'is_absensi',
            'is_cuti',
            'is_libur_normal',
            'is_libur_nasional',
            'instansi'
        ));
    }

    public function store()
    {
        $imageContent = file_get_contents(request()->image);
        if ($imageContent !== false) {
            $filename = 'masuk_' . uniqid() . '.jpg';
            $destination = public_path('assets/images/absensi/' . $filename);
            $image = Image::make($imageContent);
            $compressionQuality = 80;
            $image->save($destination, $compressionQuality);
            request()->foto_masuk = $filename;
            request()->id_user = Auth::id();

            $instansi = Instansi::getData();
            $toleransi_keterlambatan = $instansi->toleransi_keterlambatan;

            $hari = date('l');
            $jam_kerja = AbsensiMasuk::getJamMasuk($hari)->jam_masuk;

            $jam_sekarang = date('H:i:s');

            $jam_kerja_unix = strtotime($jam_kerja);
            $jam_sekarang_unix = strtotime($jam_sekarang);

            $selisih = $jam_sekarang_unix - $jam_kerja_unix;
            $selisih_menit = $selisih / 60;

            if ($selisih_menit <= 0) {
                request()->status_absensi = 1;
            } elseif ($selisih_menit <= $toleransi_keterlambatan) {
                request()->status_absensi = 2;
            } else {
                request()->status_absensi = 3;
            }

            $data = AbsensiMasuk::simpanData(request());
            return Response()->json($data);
        } else {
            dd("Failed to fetch image content from the URL.");
        }
    }
}
