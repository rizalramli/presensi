@extends('layouts.app_guru')

@push('custom-css-start')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3><a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i></a> Laporan Absensi</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Laporan Absensi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="filter-bulan">Bulan</label>
                                <select id="filter-bulan" class="choices form-select" onchange="reinitTable()">
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}" {{ date('n') == $i ? 'selected' : '' }}>
                                            {{ $daftar_bulan[$i] }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="filter-tahun">Tahun</label>
                                <select id="filter-tahun" class="choices form-select" onchange="reinitTable()">
                                    @for ($i = date('Y', strtotime('-2 year')); $i <= date('Y'); $i++)
                                        <option value="{{ $i }}" {{ date('Y') == $i ? 'selected' : '' }}>
                                            {{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <p><span class="text-success me-4">&#10004; : Tepat Waktu</span></p>
                    <p><span class="text-warning me-4">&#10004; : Terlambat Dengan Toleransi</span></p>
                    <p><span class="text-danger me-4">&#10004; : Terlambat Tanpa Toleransi</span></p>
                    <p><span class="me-4">&ndash; : Tidak Hadir</span></p>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" width="2%">No</th>
                                    <th class="text-center" rowspan="2" width="10%">Tanggal</th>
                                    <th class="text-center" rowspan="2" width="10%">Hari</th>
                                    <th class="text-center" colspan="2" width="10%">Waktu</th>
                                    <th class="text-center" rowspan="2" width="10%">Jumlah Jam Kerja</th>
                                    <th class="text-center" rowspan="2" width="10%">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Masuk</th>
                                    <th class="text-center">Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="text-center">1</td>
                                    <td class="text-center">01/08/2023</td>
                                    <td class="text-center">Selasa</td>
                                    <td class="text-center">07:19:59</td>
                                    <td class="text-center">16:04:24</td>
                                    <td class="text-center">08:44</td>
                                    <td class="text-center"> <span class="text-success me-4">&#10004;</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">02/08/2023</td>
                                    <td class="text-center">Rabu</td>
                                    <td class="text-center">07:19:59</td>
                                    <td class="text-center">16:04:24</td>
                                    <td class="text-center">08:44</td>
                                    <td class="text-center"><span class="text-warning me-4">&#10004;</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center">3</td>
                                    <td class="text-center">03/08/2023</td>
                                    <td class="text-center">Kamis</td>
                                    <td class="text-center">07:19:59</td>
                                    <td class="text-center">16:04:24</td>
                                    <td class="text-center">08:44</td>
                                    <td class="text-center"><span class="text-danger me-4">&#10004;</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
        <!-- Basic Tables end -->
    </div>
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            ajaxSetup()
        });

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }
    </script>
@endpush
