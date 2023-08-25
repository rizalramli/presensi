@extends('layouts.app_guru')

@push('custom-css-start')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3><a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i></a> Ubah Password</h3>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <form id="form">
            <section class="section">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="old-password">Password lama</label>
                                    <input type="password" id="old-password" name="old_password" class="form-control"
                                        required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="password">Password Baru</label>
                                    <input type="password" id="password" name="password" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="konfirmasi-password">Konfirmasi Password</label>
                                    <input type="password" id="konfirmasi-password" name="konfirmasi_password"
                                        class="form-control" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>

            </section>
        </form>
        <!-- Basic Tables end -->
    </div>
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
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
            let password = $('#password').val()
            let konfirmasi_password = $('#konfirmasi-password').val()
            if (password != konfirmasi_password) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan',
                    text: 'Password dan konfirmasi password harus sama!'
                })
            } else {
                $.ajax({
                    url: "{{ route('pengaturan.ubah-password.store') }}",
                    type: "POST",
                    data: form,
                    contentType: false,
                    cache: false,
                    processData: false,
                    success: function(data) {
                        if (data.status === true) {
                            $('#form').trigger("reset")
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses',
                                text: data.message,
                            })
                        } else {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Peringatan',
                                text: data.message,
                            })
                        }
                    },
                    error: function(request, msg, error) {
                        $('#form').trigger("reset")
                        console.log(msg)
                    }
                })
            }
        })
    </script>
@endpush
