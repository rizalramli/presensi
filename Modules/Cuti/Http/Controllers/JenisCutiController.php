<?php

namespace Modules\Cuti\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class JenisCutiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        if (request()->ajax()) {
            $data = [
                (object)[
                    'nama' => 'Tahunan',
                    'kuota' => 12,
                    'status' => 1,
                ],
                (object)[
                    'nama' => 'Sakit',
                    'kuota' => 12,
                    'status' => 1,
                ],
                (object)[
                    'nama' => 'Melahirkan',
                    'kuota' => 90,
                    'status' => 1,
                ]
            ];
            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-warning me-1"><a href="javascript:void(0)" onclick="editData(1)" class="text-white">edit</a></span>';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(1)" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('kuota', function ($row) {
                    return $row->kuota . " Hari";
                })
                ->editColumn('status', function ($row) {
                    switch ($row->status) {
                        case "0":
                            return "<span class='badge bg-danger'>tidak Aktif</span>";
                            break;
                        case "1":
                            return "<span class='badge bg-success'>aktif</span>";
                            break;
                        default:
                            return "<span class='badge bg-danger'>Tidak Diketahui</span>";
                    }
                })
                ->rawColumns(['status', 'aksi'])
                ->toJson();
        }
        return view('cuti::jenis_cuti.index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('cuti::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('cuti::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('cuti::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        //
    }
}
