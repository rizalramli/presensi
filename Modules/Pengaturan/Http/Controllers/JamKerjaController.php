<?php

namespace Modules\Pengaturan\Http\Controllers;

use App\Models\Instansi;
use App\Models\JamKerja;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class JamKerjaController extends Controller
{

    public function index()
    {
        $jam_kerja = JamKerja::getData();
        $instansi = Instansi::getData();
        return view('pengaturan::jam_kerja.index', compact('jam_kerja', 'instansi'));
    }

    public function store()
    {
        $data = JamKerja::simpanData(request());
        return Response()->json($data);
    }
}
