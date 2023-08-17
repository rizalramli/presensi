@extends('layouts.app')

@push('custom-css-start')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/flatpickr/flatpickr.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Jam Kerja</h3>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <form id="form" class="form">
                <div class="card">
                    <div class="card-body">
                        <div class="col-12 pb-3">
                            <div class="form-group">
                                <label for="input-toleransi-keterlambatan"><b>Toleransi Keterlambatan (menit)</b></label>
                                <input id="input-toleransi-keterlambatan" type="number" name="toleransi_keterlambatan"
                                    value="{{ $instansi->toleransi_keterlambatan }}" class="form-control">
                            </div>
                        </div>
                        <b>Atur Jam Masuk & Jam Pulang</b>
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th class="text-center">Hari</th>
                                    <th class="text-center">Jam Masuk</th>
                                    <th class="text-center">Jam Pulang</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($jam_kerja as $item)
                                    <tr>
                                        <td>{{ $item->hari }}</td>
                                        <td>
                                            <input type="hidden" class="form-control" value="{{ $item->id }}"
                                                name="id[]" readonly>
                                            <input type="text" name="jam_masuk[]"
                                                class="form-control flatpickr-time-picker-24h"
                                                value="{{ $item->jam_masuk != null ? date('H:i', strtotime($item->jam_masuk)) : '' }}">
                                        </td>
                                        <td>
                                            <input type="text" name="jam_pulang[]"
                                                class="form-control flatpickr-time-picker-24h"
                                                value="{{ $item->jam_pulang != null ? date('H:i', strtotime($item->jam_pulang)) : '' }}">
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
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
    <script src="{{ asset('assets/extensions/flatpickr/flatpickr.min.js') }}"></script>
    <script src="{{ asset('assets/static/js/page/date-picker.js') }}"></script>
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

        $('#form').submit(function(e) {
            e.preventDefault()
            let form = new FormData(this)
            $.ajax({
                url: "{{ route('pengaturan.jam-kerja.store') }}",
                type: "POST",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Data berhasil disimpan!',
                        willClose: () => {}
                    })
                },
                error: function(request, msg, error) {
                    console.log(msg)
                }
            })
        })
    </script>
@endpush
