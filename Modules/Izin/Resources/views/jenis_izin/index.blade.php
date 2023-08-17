@extends('layouts.app')

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
                    <h3>Jenis Izin</h3>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        <button type="button" class='btn btn-primary' onclick="tambahData()">
                            Tambah Data</button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th width="60%">Nama</th>
                                    <th width="20%">Status Aktif</th>
                                    <th width="20%">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </section>
        <!-- Basic Tables end -->
    </div>

    {{-- modal --}}
    <form id="form" class="form" enctype="multipart/form-data">
        <div class="modal fade text-left" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Tambah Data</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-nama">Nama</label>
                                    <input id="input-id" type="hidden" name="id">
                                    <input id="input-is-aktif" type="hidden" name="is_aktif" value="1">
                                    <input id="input-nama" type="text" name="nama" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary ml-1">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('assets/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            ajaxSetup()
            initTable()
        })

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            })
        }

        function initTable() {
            $('#dataTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('izin.jenis-izin.index') }}"
                },
                columns: [{
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'is_aktif',
                        name: 'is_aktif'
                    },
                    {
                        data: 'aksi',
                        name: 'aksi'
                    },
                ],
            })
        }

        function reinitTable() {
            $('#dataTable').DataTable().clear().destroy()
            initTable()
        }

        function tambahData() {
            $('#form').trigger("reset")
            $('#myModal').modal('show')
        }

        $('#form').submit(function(e) {
            e.preventDefault()
            let form = new FormData(this)
            $.ajax({
                url: "{{ route('izin.jenis-izin.store') }}",
                type: "POST",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#myModal').modal('hide')
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data berhasil disimpan!',
                        willClose: () => {
                            reinitTable()
                        }
                    })
                },
                error: function(request, msg, error) {
                    console.log(msg)
                }
            })
        })

        function editData(id) {
            $('#myModal').modal('show')
            $.get("jenis-izin/" + id + "/edit", function(data) {
                $('#input-id').val(data.id)
                $('#input-nama').val(data.nama)
                $('#input-is-aktif').val(data.is_aktif)
            })
        }

        function updateData(id) {
            var isChecked = $("#checkbox" + id).prop("checked");
            var is_aktif;
            var text;
            (isChecked == true) ? is_aktif = 1: is_aktif = 0;
            var url = "{{ route('izin.jenis-izin.update', ':id') }}";
            url = url.replace(':id', id);
            $.ajax({
                type: "PATCH",
                url: url,
                data: {
                    id: id,
                    is_aktif: is_aktif
                },
                success: function(res) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Status berhasil diperbarui!',
                        willClose: () => {
                            reinitTable()
                        }
                    })
                }
            })
        }

        function deleteData(id) {
            var url = "{{ route('izin.jenis-izin.destroy', ':id') }}";
            url = url.replace(':id', id);
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
                    })
                }
            })
        }
    </script>
@endpush
