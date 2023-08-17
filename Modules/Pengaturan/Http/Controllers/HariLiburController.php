<?php

namespace Modules\Pengaturan\Http\Controllers;

use App\Models\HariLibur;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class HariLiburController extends Controller
{

    public function index()
    {
        if (request()->ajax()) {
            $data = HariLibur::getData();

            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-warning me-1"><a href="javascript:void(0)" onclick="editData(' . $row->id . ')" class="text-white">edit</a></span>';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(' . $row->id . ')" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->tanggal));
                })
                ->editColumn('is_aktif', function ($row) {
                    $checked = $row->is_aktif == 1 ? 'checked' : '';
                    return '<input id="checkbox' . $row->id . '" onclick="updateData(' . $row->id . ')" type="checkbox" ' . $checked . '>';
                })
                ->rawColumns(['is_aktif', 'aksi'])
                ->toJson();
        }
        return view('pengaturan::hari_libur.index');
    }

    public function store()
    {
        $data = HariLibur::simpanData(request());
        return Response()->json($data);
    }

    public function edit($id)
    {
        $data = HariLibur::editData($id);
        return response()->json($data);
    }

    public function update(Request $request, $id)
    {
        $data = HariLibur::updateData($request, $id);
        return Response()->json($data);
    }

    public function destroy($id)
    {
        $data = HariLibur::deleteData($id);
        return Response()->json($data);
    }
}
