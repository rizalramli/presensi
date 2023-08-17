<?php

namespace Modules\Pengaturan\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Routing\Controller;

class LokasiController extends Controller
{
    public function index()
    {
        $data = Instansi::getData();
        return view('pengaturan::lokasi.index', compact('data'));
    }

    public function store()
    {
        $data = Instansi::simpanDataLokasi(request());
        return Response()->json($data);
    }
}
