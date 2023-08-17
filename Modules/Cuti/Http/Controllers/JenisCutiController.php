<?php

namespace Modules\Cuti\Http\Controllers;

use App\Models\JenisCuti;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class JenisCutiController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = JenisCuti::getData();

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
        return view('cuti::jenis_cuti.index');
    }

    public function store()
    {
        $data = JenisCuti::simpanData(request());
        return Response()->json($data);
    }

    public function edit($id)
    {
        $data = JenisCuti::editData($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = JenisCuti::updateData($request, $id);
        return Response()->json($data);
    }

    public function destroy($id)
    {
        $data = JenisCuti::deleteData($id);
        return Response()->json($data);
    }
}
