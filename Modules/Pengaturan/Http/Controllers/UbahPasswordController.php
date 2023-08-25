<?php

namespace Modules\Pengaturan\Http\Controllers;

use App\Models\User;
use Illuminate\Routing\Controller;

class UbahPasswordController extends Controller
{

    public function index()
    {
        return view('pengaturan::ubah_password.index');
    }

    public function store()
    {
        $data = User::UbahPassword(request());
        return $data;
    }
}
