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
                    <h3>Lokasi</h3>
                </div>
            </div>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <form id="form" class="form" enctype="multipart/form-data">
                <input type="hidden" id="input-id" name="id" value="{{ $data->id }}">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input-nama-sekolah">Nama</label>
                                    <input id="input-nama-sekolah" type="text" name="nama_sekolah"
                                        value="{{ $data->nama_sekolah }}" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input-alamat">Alamat</label>
                                    <input id="input-alamat" type="text" name="alamat" value="{{ $data->alamat }}"
                                        class="form-control" required>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="input-radius-absensi">Logo</label>
                                    <input id="logo" type="file" class="form-control form-control-sm"
                                        name="logo">
                                    <input value="{{ $data->logo }}" type="hidden" class="form-control form-control-sm"
                                        name="logo_before">
                                    <input id="remove" value="0" type="hidden" class="form-control form-control-sm"
                                        name="remove">
                                    <br>
                                    <button type="button" class="btn btn-danger btn-sm"
                                        id="btn-delete-image">Hapus</button>
                                    <br>
                                    <br>
                                    @if ($data->logo != null)
                                        <img height="100" width="100" id="imgPreview" class="img-thumbnail"
                                            src="{{ asset('assets/images/logo/' . $data->logo) }}" />
                                    @else
                                        <img height="100" width="100" id="imgPreview" class="img-thumbnail"
                                            src="{{ asset('assets/images/logo/noimage.png') }}" />
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </section>

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

            let default_image = "{{ asset('assets/images/logo/noimage.png') }}";

            $("#logo").change(function() {
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function(event) {
                        $("#imgPreview")
                            .attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $('#btn-delete-image').click(function() {
                $('#imgPreview').attr('src', default_image);
                $('#remove').val(1);
            });
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
                url: "{{ route('pengaturan.instansi.store') }}",
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
