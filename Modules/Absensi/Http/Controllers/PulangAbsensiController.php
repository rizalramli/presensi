<?php

namespace Modules\Absensi\Http\Controllers;

use App\Models\AbsensiPulang;
use App\Models\Instansi;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;

class PulangAbsensiController extends Controller
{
    public function index()
    {
        $id_user = Auth::id();
        $tanggal = date('Y-m-d');
        $hari = date('l');

        $is_absensi_masuk = AbsensiPulang::IsAbsenMasukHariIni($id_user, $tanggal);
        $is_absensi = AbsensiPulang::IsAbsenHariIni($id_user, $tanggal);
        $is_cuti = AbsensiPulang::IsCutiHariIni($id_user, $tanggal);
        $is_libur_normal = AbsensiPulang::IsLiburNormal($hari);
        $is_libur_nasional = AbsensiPulang::IsLiburNasional($tanggal);
        $instansi = Instansi::getData();

        return view('absensi::pulang_absensi.index', compact(
            'is_absensi_masuk',
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
            $filename = 'pulang_' . uniqid() . '.jpg';
            $destination = public_path('assets/images/absensi/' . $filename);
            $image = Image::make($imageContent);
            $compressionQuality = 80;
            $image->save($destination, $compressionQuality);
            request()->tanggal = date('Y-m-d');
            request()->foto_pulang = $filename;
            request()->id_user = Auth::id();

            $data = AbsensiPulang::simpanData(request());
            return Response()->json($data);
        } else {
            dd("Failed to fetch image content from the URL.");
        }
    }
}
