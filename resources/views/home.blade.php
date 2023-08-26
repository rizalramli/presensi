@php
    $role_user = '';
@endphp
@if (Auth::check())
    @foreach (auth()->user()->getRoleNames() as $role)
        @php
            $role_user = $role;
        @endphp
    @endforeach
@endif

@extends('layouts.app_guru')

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header pb-0">
                    <h4 class="card-title">
                        <table width="100%">
                            <tr>
                                <td width="10%">
                                    <div class="logo me-3"><img width="50px" height="50px"
                                            src="{{ asset('assets/images/logo/' . $instansi->logo) }}" alt="Logo"
                                            srcset="">
                                    </div>
                                </td>
                                <td>
                                    <span><small>{{ $instansi->nama_sekolah }}</small></span>
                                </td>
                            </tr>
                        </table>
                    </h4>
                </div>
                <hr>
                <div class="card-body">
                    <table width="100%">
                        <tr>
                            <td width="10%" rowspan="2">

                            </td>
                            <td colspan="1"><span class="fw-bold fs-6">{{ Auth::user()->name }}</span></td>
                            <td rowspan="2" class="text-right"><span class="fw-bold"> <a href="javascript:void(0)"
                                        class='sidebar-link' data-bs-toggle="modal" data-bs-target="#border-less"><i
                                            class="bi bi-box-arrow-right h3"></i></a></span>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="1"><span class="fs-6">{{ $role }}</span></td>
                        </tr>
                    </table>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-center">
                            <small class="fw-bold fs-6">Ubah Tema</small>
                            <div class="theme-toggle d-flex justify-content-center gap-2 mt-2">
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20"
                                    height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                    <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <path
                                            d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                            opacity=".3"></path>
                                        <g transform="translate(-210 -1)">
                                            <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                            <circle cx="220.5" cy="11.5" r="4"></circle>
                                            <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2">
                                            </path>
                                        </g>
                                    </g>
                                </svg>
                                <div class="form-check form-switch fs-6">
                                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                                    <label class="form-check-label"></label>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                    aria-hidden="true" role="img" class="iconify iconify--mdi" width="20"
                                    height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                    <path fill="currentColor"
                                        d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                    </path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-12 text-center">
                            <span class="fw-bold fs-6 text-primary">
                                <div id="clock"></div>
                            </span>
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
                                    <span class="fw-bold text-primary fs-5">{{ $absensi->jam_masuk }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6 text-center">
                            <span class="text-white fs-6">Pulang</span>
                            <div class="card mt-3">
                                <div class="card-body">
                                    <span class="fw-bold text-primary fs-5">{{ $absensi->jam_pulang }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 text-center">
                            <span class="fw-bold text-white fs-6">Total Jam Kerja :
                                {{ $absensi->total_jam_kerja }}</span>
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

                @if ($role_user == 'Kepala Sekolah')
                    <div class="col-6 text-center">
                        <a href="{{ route('izin.persetujuan-izin.index') }}" class="text-primary">
                            <div class="card">
                                <div class="card-body">
                                    <p class="py-2">
                                        <i class="bi bi-check2-circle h1"></i>
                                    </p>
                                    <p class="fw-bold">Persetujuan Izin</p>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-6 text-center">
                        <a href="{{ route('cuti.persetujuan-cuti.index') }}" class="text-primary">
                            <div class="card">
                                <div class="card-body">
                                    <p class="py-2">
                                        <i class="bi bi-calendar-check h1"></i>
                                    </p>
                                    <p class="fw-bold">Persetujuan Cuti</p>
                                </div>
                            </div>
                        </a>
                    </div>
                @endif

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
                <div class="col-6 text-center">
                    <a href="{{ route('pengaturan.ubah-password.index') }}" class="text-primary">
                        <div class="card">
                            <div class="card-body">
                                <p class="py-2">
                                    <i class="bi bi-shield-lock h1"></i>
                                </p>
                                <p class="fw-bold">Ubah Password</p>
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

        function updateIndonesianTime() {
            const months = [
                "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                "Juli", "Agustus", "September", "Oktober", "November", "Desember"
            ];

            const days = [
                "Minggu", "Senin", "Selasa", "Rabu", "Kamis", "Jumat", "Sabtu"
            ];

            const now = new Date();
            const year = now.getFullYear();
            const month = now.getMonth();
            const dayOfWeek = now.getDay();
            const dayOfMonth = now.getDate();
            const hours = now.getHours();
            const minutes = now.getMinutes();
            const seconds = now.getSeconds();

            const indonesianDateTime =
                `${days[dayOfWeek]}, ${dayOfMonth} ${months[month]} ${year}\n${hours}:${minutes}:${seconds}`;

            $('#clock').css('white-space', 'pre-line').text(indonesianDateTime);
        }

        // Memperbarui waktu setiap detik
        setInterval(updateIndonesianTime, 1000);
    </script>
@endpush
