<?php

namespace Modules\Izin\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\DataTables;

class IzinController extends Controller
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
                    'jenis_izin' => 'Izin Pulang Cepat',
                    'tanggal' => '2023-08-11',
                    'jam_awal' => '2023-08-12 13:00:00',
                    'jam_akhir' => '2023-08-12 15:00:00',
                    'status' => 0,
                ],
                (object)[
                    'nama' => 'Hasri Wiji',
                    'jenis_izin' => 'Izin Datang Terlambat',
                    'tanggal' => '2023-08-11',
                    'jam_awal' => '2023-08-12 07:00:00',
                    'jam_akhir' => '2023-08-12 08:00:00',
                    'status' => 1,
                ],
            ];
            return DataTables::of($data)
                ->addColumn('aksi', function ($row) {
                    $aksi = '';
                    $aksi .= '<span class="badge bg-warning me-1"><a href="javascript:void(0)" onclick="editData(1)" class="text-white">edit</a></span>';
                    $aksi .= '<span class="badge bg-danger"><a href="javascript:void(0)" onclick="deleteData(1)" class="text-white">hapus</a></span>';
                    return $aksi;
                })
                ->editColumn('tanggal', function ($row) {
                    return date('d/m/Y', strtotime($row->tanggal));
                })
                ->editColumn('jam_awal', function ($row) {
                    return date('H:i', strtotime($row->jam_awal)) . " - " . date('H:i', strtotime($row->jam_akhir));
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
                            return "<span class='badge bg-danger'>ditolak</span><br><span><u><a href='#'>lihat alasan</u></a></span>";
                    }
                })
                ->rawColumns(['status', 'aksi'])
                ->toJson();
        }

        return view('izin::izin.index', compact('daftar_bulan', 'daftar_guru'));
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
