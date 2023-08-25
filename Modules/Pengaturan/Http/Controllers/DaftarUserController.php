<?php

namespace Modules\Pengaturan\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;

class DaftarUserController extends Controller
{

    public function index()
    {
        $daftar_role = Role::orderBy('id', 'asc')->pluck('name', 'name');
        if (request()->ajax()) {
            $data = User::getData();

            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-warning me-1"><a href="javascript:void(0)" onclick="editData(' . $row->id . ')" class="text-white">edit</a></span>';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(' . $row->id . ')" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('is_aktif', function ($row) {
                    $checked = $row->is_aktif == 1 ? 'checked' : '';
                    return '<input id="checkbox' . $row->id . '" onclick="updateData(' . $row->id . ')" type="checkbox" ' . $checked . '>';
                })
                ->rawColumns(['is_aktif', 'aksi'])
                ->toJson();
        }
        return view('pengaturan::daftar_user.index', compact('daftar_role'));
    }

    public function store()
    {
        $data = User::simpanData(request());
        return Response()->json($data);
    }

    public function edit($id)
    {
        $data = User::editData($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = User::updateData($request, $id);
        return Response()->json($data);
    }

    public function destroy($id)
    {
        $data = User::deleteData($id);
        return Response()->json($data);
    }
}
