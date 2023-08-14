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
                    <h3>Jam Kerja</h3>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ url('/') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Jam Kerja</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="col-12">
                        <div class="form-group">
                            <label for="input-kuota">Toleransi Keterlambatan (menit)</label>
                            <input id="input-kuota" type="number" name="kuota" value="10" class="form-control">
                        </div>
                    </div>
                    <h6>Atur Jam Masuk & Jam Pulang</h6>
                    <table class="table table-bordered" id="dataTable">
                        <thead>
                            <tr>
                                <th>Hari</th>
                                <th>Jam Masuk</th>
                                <th>Jam Pulang</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Senin</td>
                                <td><input type="text" class="form-control" value="07:00"></td>
                                <td><input type="text" class="form-control" value="14:00"></td>
                            </tr>
                            <tr>
                                <td>Selasa</td>
                                <td><input type="text" class="form-control" value="07:00"></td>
                                <td><input type="text" class="form-control" value="14:00"></td>
                            </tr>
                            <tr>
                                <td>Rabu</td>
                                <td><input type="text" class="form-control" value="07:00"></td>
                                <td><input type="text" class="form-control" value="14:00"></td>
                            </tr>
                            <tr>
                                <td>Kamis</td>
                                <td><input type="text" class="form-control" value="07:00"></td>
                                <td><input type="text" class="form-control" value="14:00"></td>
                            </tr>
                            <tr>
                                <td>Jum'at</td>
                                <td><input type="text" class="form-control" value="07:00"></td>
                                <td><input type="text" class="form-control" value="14:00"></td>
                            </tr>
                            <tr>
                                <td>Sabtu</td>
                                <td><input type="text" class="form-control" value="-"></td>
                                <td><input type="text" class="form-control" value="-"></td>
                            </tr>
                            <tr>
                                <td>Minggu</td>
                                <td><input type="text" class="form-control" value="-"></td>
                                <td><input type="text" class="form-control" value="-"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <button class="btn btn-primary">Simpan</button>
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
