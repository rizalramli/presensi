@extends('layouts.app')

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
                    <h3>Daftar Absensi</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Daftar Cuti</li>
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
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
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
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
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
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                            <div class="form-group">
                                <label for="filter-guru">Nama Guru</label>
                                <select id="filter-guru" class="choices form-select" onchange="reinitTable()">
                                    <option value="">Semua Guru</option>
                                    @foreach ($daftar_guru as $item)
                                        <option value="{{ $item->id_guru }}">
                                            {{ $item->nama }}
                                        </option>
                                    @endforeach
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
                                    <th class="text-center" rowspan="2" width="10%">Nama</th>
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
                                    <td class="text-center">Rizal Ramli</td>
                                    <td class="text-center">01/08/2023</td>
                                    <td class="text-center">Selasa</td>
                                    <td class="text-center">07:19:59
                                        <span><a href="#" data-bs-toggle="modal" data-bs-target="#myModalBerkas">lihat
                                                detail</a></span>
                                    </td>
                                    <td class="text-center">16:04:24
                                        <span><a href="#" data-bs-toggle="modal" data-bs-target="#myModalBerkas">lihat
                                                detail</a></span>
                                    </td>
                                    <td class="text-center">08:44</td>
                                    <td class="text-center"> <span class="text-success me-4">&#10004;</span></td>
                                </tr>
                                <tr>
                                    <td class="text-center">2</td>
                                    <td class="text-center">Hasri Wiji Aqsari</td>
                                    <td class="text-center">01/08/2023</td>
                                    <td class="text-center">Selasa</td>
                                    <td class="text-center">07:19:59
                                        <span><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#myModalBerkas">lihat
                                                detail</a></span>
                                    </td>
                                    <td class="text-center">16:04:24
                                        <span><a href="#" data-bs-toggle="modal"
                                                data-bs-target="#myModalBerkas">lihat
                                                detail</a></span>
                                    </td>
                                    <td class="text-center">08:44</td>
                                    <td class="text-center"> <span class="text-warning me-4">&#10004;</span></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>

        <form id="form" class="form" enctype="multipart/form-data">
            <div class="modal fade text-left" id="myModalBerkas" tabindex="-1" role="dialog"
                aria-labelledby="myModalLabel1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-scrollable" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel1">Berkas</h5>
                            <button type="button" class="close rounded-pill" data-bs-dismiss="modal"
                                aria-label="Close">
                                <i data-feather="x"></i>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="row mb-2">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="input-kuota">Foto</label>
                                        <div class="text-center">
                                            <img width="100%"
                                                src="https://upload.wikimedia.org/wikipedia/commons/7/7f/Contour_buffer_strips_NRCS.jpg"
                                                class="rounded" alt="...">
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="input-keterangan">Lokasi</label>
                                        <div class="googlemaps">
                                            <iframe
                                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126748.6091242787!2d107.57311654129782!3d-6.903273917028756!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e68e6398252477f%3A0x146a1f93d3e815b2!2sBandung%2C%20Bandung%20City%2C%20West%20Java!5e0!3m2!1sen!2sid!4v1633023222539!5m2!1sen!2sid"
                                                width="100%" height="300" style="border: 0" allowfullscreen=""
                                                loading="lazy"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
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
