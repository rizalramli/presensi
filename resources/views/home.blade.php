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

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-title text-primary">Selamat Pagi !</h4>
                </div>
                <div class="card-body">
                    <table width="100%">
                        <tr>
                            <td width="10%" rowspan="2">
                                <div class="avatar avatar-xl me-3">
                                    <img src="{{ asset('assets/images/faces/2.jpg') }}" alt="" srcset="" />
                                </div>
                            </td>
                            <td colspan="1"><span class="fw-bold fs-6">Rizal Ramli</span></td>
                            <td rowspan="2" class="text-right"><span class="fw-bold"> <a href="#"
                                        class='sidebar-link' data-bs-toggle="modal" data-bs-target="#border-less"><i
                                            class="bi bi-box-arrow-right h3"></i></a></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"><span class="fs-6">Guru Kelas</span></td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="fw-bold fs-6 text-primary">12 Agustus 2023 08:00:11</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="section">
            <div class="card bg-primary">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6 text-center">
                            <span class="text-white fs-6">Masuk</span>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <span class="fw-bold text-primary fs-5">08:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <span class="text-white fs-6">Pulang</span>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <span class="fw-bold text-primary fs-5">16:00</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <span class="fw-bold text-white fs-6">Total Jam Kerja : 8 Jam 9 Menit</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="row">
                <div class="col-6 text-center">
                    <a href="{{ route('absensi.masuk-absensi.index') }}" class="text-primary">
                        <div class="card">
                            <div class="card-body">
                                <p class="py-2">
                                    <i class="bi bi-person-bounding-box h1"></i>
                                </p>
                                <p class="fw-bold">Absensi Masuk</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('absensi.pulang-absensi.index') }}" class="text-primary">
                        <div class="card">
                            <div class="card-body">
                                <p class="py-2">
                                    <i class="bi bi-person-bounding-box h1"></i>
                                </p>
                                <p class="fw-bold">Absensi Keluar</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('izin.pengajuan-izin.index') }}" class="text-primary">
                        <div class="card">
                            <div class="card-body">
                                <p class="py-2">
                                    <i class="bi bi-clock h1"></i>
                                </p>
                                <p class="fw-bold">Pengajuan Izin</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('cuti.pengajuan-cuti.index') }}" class="text-primary">
                        <div class="card">
                            <div class="card-body">
                                <p class="py-2">
                                    <i class="bi bi-calendar2-date h1"></i>
                                </p>
                                <p class="fw-bold">Pengajuan Cuti</p>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-6 text-center">
                    <a href="{{ route('absensi.laporan-absensi.index') }}" class="text-primary">
                        <div class="card">
                            <div class="card-body">
                                <p class="py-2">
                                    <i class="bi bi-file-earmark-check h1"></i>
                                </p>
                                <p class="fw-bold">Laporan Absensi</p>
                            </div>
                        </div>
                    </a>
                </div>
            </div>
        </section>
    </div>

    <!--Modal Logout -->
    <div class="modal fade text-left modal-borderless" id="border-less" tabindex="-1" role="dialog"
        aria-labelledby="myModalLabel1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi</h5>
                    <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        Halo {{ Auth::user()->name }} apakah anda yakin ingin keluar dari aplikasi?
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-primary" data-bs-dismiss="modal">
                        <i class="bx bx-x"></i>
                        <span>Batal</span>
                    </button>

                    <a class="btn btn-primary ml-1" href="{{ route('logout') }}"
                        onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="bx bx-check"></i>
                        <span>Ya, Saya Yakin !</span>
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </div>
            </div>
        </div>
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
