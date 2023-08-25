@php
    $sql = 'SELECT * FROM instansi';
    
    $result = DB::selectOne($sql);
@endphp
<div id="sidebar" class="active">
    <div class="sidebar-wrapper active">
        <div class="px-4 pt-4">
            <table width="100%">
                <tr>
                    <td width="10%">
                        <div class="logo me-3"><img width="50px" height="50px"
                                src="{{ asset('assets/images/logo/' . $result->logo) }}" alt="Logo" srcset="">
                        </div>
                    </td>
                    <td>
                        <span><small>{{ $result->nama_sekolah }}</small></span>
                    </td>
                </tr>
            </table>
        </div>
        <div class="sidebar-header position-relative pb-0">
            <div class="d-flex justify-content-between align-items-center">
                <div class="logo">
                    <small class="fs-6">Ubah Tema</small>
                </div>
                <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
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
                                <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                            </g>
                        </g>
                    </svg>
                    <div class="form-check form-switch fs-6">
                        <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                        <label class="form-check-label"></label>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                        aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20"
                        preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                        <path fill="currentColor"
                            d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                        </path>
                    </svg>
                </div>
                <div class="sidebar-toggler  x">
                    <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                </div>
            </div>
        </div>
        <div class="sidebar-menu">
            <ul class="menu">
                <li class="sidebar-title">Absensi</li>
                <li class="sidebar-item {{ Request::is('home2') ? 'active' : '' }}">
                    <a href="{{ route('home2') }}" class='sidebar-link'>
                        <i class="bi bi-house"></i>
                        <span>Home</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('absensi/daftar-absensi') ? 'active' : '' }}">
                    <a href="{{ route('absensi.daftar-absensi.index') }}" class='sidebar-link'>
                        <i class="bi bi-person-bounding-box"></i>
                        <span>Daftar Absensi</span>
                    </a>
                </li>

                <li class="sidebar-title">Izin</li>
                <li class="sidebar-item {{ Request::is('izin/daftar-izin') ? 'active' : '' }}">
                    <a href="{{ route('izin.daftar-izin.index') }}" class='sidebar-link'>
                        <i class="bi bi-clock"></i>
                        <span>Daftar Izin</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('izin/jenis-izin') ? 'active' : '' }}">
                    <a href="{{ route('izin.jenis-izin.index') }}" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>Jenis Izin</span>
                    </a>
                </li>

                <li class="sidebar-title">Cuti</li>
                <li class="sidebar-item {{ Request::is('cuti/daftar-cuti') ? 'active' : '' }}">
                    <a href="{{ route('cuti.daftar-cuti.index') }}" class='sidebar-link'>
                        <i class="bi bi-calendar2-date"></i>
                        <span>Daftar Cuti</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('cuti/jenis-cuti') ? 'active' : '' }}">
                    <a href="{{ route('cuti.jenis-cuti.index') }}" class='sidebar-link'>
                        <i class="bi bi-gear"></i>
                        <span>Jenis Cuti</span>
                    </a>
                </li>

                <li class="sidebar-title">Pengaturan</li>
                <li class="sidebar-item {{ Request::is('pengaturan/daftar-user') ? 'active' : '' }}">
                    <a href="{{ route('pengaturan.daftar-user.index') }}" class='sidebar-link'>
                        <i class="bi bi-people"></i>
                        <span>Daftar User</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('pengaturan/hari-libur') ? 'active' : '' }}">
                    <a href="{{ route('pengaturan.hari-libur.index') }}" class='sidebar-link'>
                        <i class="bi bi-calendar3"></i>
                        <span>Hari Libur</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('pengaturan/instansi') ? 'active' : '' }}">
                    <a href="{{ route('pengaturan.instansi.index') }}" class='sidebar-link'>
                        <i class="bi bi-building"></i>
                        <span>Instansi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('pengaturan/lokasi') ? 'active' : '' }}">
                    <a href="{{ route('pengaturan.lokasi.index') }}" class='sidebar-link'>
                        <i class="bi bi-geo-alt"></i>
                        <span>Lokasi</span>
                    </a>
                </li>
                <li class="sidebar-item {{ Request::is('pengaturan/jam-kerja') ? 'active' : '' }}">
                    <a href="{{ route('pengaturan.jam-kerja.index') }}" class='sidebar-link'>
                        <i class="bi bi-clock-history"></i>
                        <span>Jam Kerja</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class='sidebar-link' data-bs-toggle="modal" data-bs-target="#border-less">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Keluar</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
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
