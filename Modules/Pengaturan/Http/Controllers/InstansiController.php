<?php

namespace Modules\Pengaturan\Http\Controllers;

use App\Models\Instansi;
use Illuminate\Routing\Controller;

class InstansiController extends Controller
{

    public function index()
    {
        $data = Instansi::getData();
        return view('pengaturan::instansi.index', compact('data'));
    }

    public function store()
    {
        if (request()->file('logo')) {
            $file = request()->file('logo');
            $file_name = 'logo-' . time() . '.' . $file->extension();

            request()->file('logo')->move('assets/images/logo', $file_name);

            request()->logo = $file_name;
        } else {
            request()->logo = request()->logo_before;
            if (request()->remove == 1) {
                request()->logo = null;
            }
        }

        $data = Instansi::simpanData(request());
        return Response()->json($data);
    }
}
