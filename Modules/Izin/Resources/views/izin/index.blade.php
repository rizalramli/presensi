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
                    <h3>Daftar Izin</h3>
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
                                        <option value="{{ $item->id }}">
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
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="20%">Nama</th>
                                    <th width="20%">Jenis Izin</th>
                                    <th width="10%">Tanggal</th>
                                    <th width="15%">Jam</th>
                                    <th width="10%">Berkas</th>
                                    <th width="20%">Status</th>
                                    <th width="5%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        {{-- Detail Berkas --}}
        <div class="modal fade text-left" id="myModalBerkas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Berkas</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-kuota">Foto</label>
                                    <div class="text-center">
                                        <img id="input-bukti-foto" width="100%" src="" class="rounded"
                                            alt="...">
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-keterangan">Keterangan</label>
                                    <textarea id="input-keterangan" name="keterangan" class="form-control" rows="3"></textarea>
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

        {{-- Detail Berkas --}}
        <div class="modal fade text-left" id="myModalPenolakan" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Alasan Penolakan</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-keterangan-penolakan">Keterangan</label>
                                    <textarea id="input-keterangan-penolakan" name="keterangan" class="form-control" rows="3"></textarea>
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
            initTable()
        });

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function initTable() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('izin.daftar-izin.index') }}",
                    data: function(d) {
                        d.bulan = $('#filter-bulan').val(),
                            d.tahun = $('#filter-tahun').val(),
                            d.guru = $('#filter-guru').val()
                    }
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'jenis_izin',
                        name: 'jenis_izin'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal'
                    },
                    {
                        data: 'dari_jam',
                        name: 'dari_jam'
                    },
                    {
                        data: 'bukti_foto',
                        name: 'bukti_foto'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    }
                ],
            });
        }

        function reinitTable() {
            $('#dataTable').DataTable().clear().destroy()
            initTable()
        }

        function detailBerkas(bukti_foto, keterangan) {
            $('#myModalBerkas').modal('show')
            let url = "{{ asset('assets/images/izin') }}" + '/' + bukti_foto
            $("#input-bukti-foto").attr("src", url)
            $('#input-keterangan').val(keterangan)
        }

        function detailPenolakan(keterangan) {
            $('#myModalPenolakan').modal('show')
            $('#input-keterangan-penolakan').val(keterangan)
        }

        function deleteData(id) {
            let url = "{{ route('izin.daftar-izin.destroy', ':id') }}"
            url = url.replace(':id', id)
            Swal.fire({
                title: 'Konfirmasi',
                text: "Apakah anda yakin ingin menghapus?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya, saya yakin!',
                cancelButtonText: "Batal",
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        type: "DELETE",
                        url: url,
                        success: function(res) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: 'Data berhasil dihapus!',
                                willClose: () => {
                                    reinitTable()
                                }
                            })
                        }
                    });
                }
            })
        }
    </script>
@endpush
