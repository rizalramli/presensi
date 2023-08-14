<?php

namespace Modules\Cuti\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class CutiController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $daftar_bulan = ['', 'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
        $daftar_guru = [
            (object)[
                'id_guru' => 1,
                'nama' => 'Rizal Ramli'
            ],
            (object)[
                'id_guru' => 1,
                'nama' => 'Hasri Wiji'
            ]
        ];

        if (request()->ajax()) {
            $data = [
                (object)[
                    'nama' => 'Rizal Ramli',
                    'jenis_cuti' => 'Sakit',
                    'dari_tanggal' => '2023-08-11',
                    'sampai_tanggal' => '2023-08-12',
                    'jumlah_hari' => 2,
                    'status' => 0,
                ],
                (object)[
                    'nama' => 'Hasri Wiji',
                    'jenis_cuti' => 'Melahirkan',
                    'dari_tanggal' => '2023-07-01',
                    'sampai_tanggal' => '2023-10-01',
                    'jumlah_hari' => 90,
                    'status' => 1,
                ],
                (object)[
                    'nama' => 'Rizal Ramli',
                    'jenis_cuti' => 'Sakit',
                    'dari_tanggal' => '2023-08-01',
                    'sampai_tanggal' => '2023-08-01',
                    'jumlah_hari' => 2,
                    'status' => 2,
                ],
            ];
            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-warning me-1"><a href="javascript:void(0)" onclick="editData(1)" class="text-white">edit</a></span>';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(1)" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('dari_tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->dari_tanggal));
                })
                ->editColumn('sampai_tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->sampai_tanggal));
                })
                ->editColumn('jumlah_hari', function ($row) {
                    return $row->jumlah_hari . " Hari";
                })
                ->editColumn('status', function ($row) {
                    switch ($row->status) {
                        case "0":
                            return "<span class='badge bg-warning'>menunggu persetujuan</span>";
                            break;
                        case "1":
                            return "<span class='badge bg-success'>disetujui</span>";
                            break;
                        default:
                            return "<span class='badge bg-danger'>ditolak</span>";
                    }
                })
                ->rawColumns(['status', 'aksi'])
                ->toJson();
        }

        return view('cuti::cuti.index', compact('daftar_bulan', 'daftar_guru'));
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
