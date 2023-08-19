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
                    <h3><a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i></a> Persetujuan Izin</h3>
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
                                <select id="filter-bulan" class="choices form-select" onchange="loadData()">
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
                                <select id="filter-tahun" class="choices form-select" onchange="loadData()">
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
                                <select id="filter-guru" class="choices form-select" onchange="loadData()">
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
            <div class="row">
                <div id="card-container" class="row"></div>
            </div>

        </section>
        <!-- Basic Tables end -->
    </div>

    {{-- modal konfirmas --}}
    <form id="form" class="form" enctype="multipart/form-data">
        <div class="modal fade text-left" id="myModalKonfirmasi" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Konfirmasi</h5>
                        <button type="button" class="close rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                            <i data-feather="x"></i>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row mb-2">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-nama">Status</label>
                                    <br>
                                    <input type="hidden" id="input-id" name="id">
                                    <div class="form-check form-check-inline">
                                        <input name="status" class="form-check-input" type="radio"
                                            name="inlineRadioOptions" id="inlineRadio1" value="1" required>
                                        <label class="form-check-label" for="inlineRadio1">Setujui</label>
                                    </div>
                                    <div class="form-check form-check-inline">
                                        <input name="status" class="form-check-input" type="radio"
                                            name="inlineRadioOptions" id="inlineRadio2" value="2" required>
                                        <label class="form-check-label" for="inlineRadio2">Tolak</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-keterangan">Keterangan Penolakan</label>
                                    <textarea name="alasan_penolakan" id="input-keterangan" class="form-control" rows="3"></textarea>
                                    <small class="text-danger">* isi keterangan jika izin ditolak</small>
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
                                    <img id="input-bukti-foto-berkas" width="100%" src="" class="rounded"
                                        alt="...">
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-group">
                                <label for="input-keterangan-berkas">Keterangan</label>
                                <textarea id="input-keterangan-berkas" name="keterangan_berkas" class="form-control" rows="3" readonly></textarea>
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
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            ajaxSetup()
            loadData()
        });

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        function loadData() {
            let bulan = $('#filter-bulan').val()
            let tahun = $('#filter-tahun').val()
            let id_user = $('#filter-guru').val()
            $.ajax({
                url: "{{ route('izin.persetujuan-izin.index') }}",
                method: "GET",
                dataType: "json",
                data: {
                    bulan: bulan,
                    tahun: tahun,
                    id_user: id_user,
                },
                success: function(data) {
                    populateCardContainer(data);
                },
                error: function() {
                    console.log("Error fetching data.")
                }
            });
        }

        function populateCardContainer(data) {
            const cardContainer = $("#card-container");
            cardContainer.empty();
            if (data.length === 0) {
                const noDataCard = `
                    <div class="col-lg-12 col-md-12 col-sm-12 col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Belum Ada Pengajuan Izin</h5>
                            </div>
                        </div>
                    </div>
                `;
                cardContainer.append(noDataCard);
            } else {
                data.forEach(item => {
                    const card = createCard(item.id, item.nama, item.tanggal, item.dari_jam, item.sampai_jam, item
                        .jenis_izin,
                        item.status, item.bukti_foto, item.keterangan, item.alasan_penolakan);
                    cardContainer.append(card);
                });
            }
        }

        function createCard(id, nama, tanggal, dari_jam, sampai_jam, jenis_izin, status, bukti_foto, keterangan,
            alasan_penolakan) {
            return `
            <div class="col-lg-4 col-md-4 col-sm-12 col-12">
                    <div class="card">
                        <div class="card-header fw-bold text-center">
                            ${nama}
                        </div>
                        <div class="card-body">
                            <p class="text-muted">${formatDateToDMY(tanggal)}</p>
                            <p class="text-muted fw-bold">${formatTimeToHHMM(dari_jam)} - ${formatTimeToHHMM(sampai_jam)}</p>
                            <p class="text-muted"><span class="badge bg-primary">${jenis_izin}</span></p>
                            <p class="text-muted">
                                <span><a href="javascript:void(0)" onclick="detailBerkas('${bukti_foto}','${keterangan}')"><u>lihat berkas</u></a></span>
                            </p>
                            <p class="text-center">
                                <span><a class="btn btn-sm btn-success" href="javascript:void(0)" onclick="detailKonfirmasi('${id}')">Konfirmasi</a></span>
                            </p>
                        </div>
                    </div>
                </div>
        `;
        }

        function detailBerkas(bukti_foto, keterangan) {
            $('#myModalBerkas').modal('show')
            let url = "{{ asset('assets/images/izin') }}" + '/' + bukti_foto
            $("#input-bukti-foto-berkas").attr("src", url)
            $('#input-keterangan-berkas').val(keterangan)
        }

        function detailKonfirmasi(id) {
            $('#myModalKonfirmasi').modal('show')
            $('#input-id').val(id)
        }

        $('#form').submit(function(e) {
            e.preventDefault()
            let form = new FormData(this)
            $.ajax({
                url: "{{ route('izin.persetujuan-izin.store') }}",
                type: "POST",
                data: form,
                contentType: false,
                cache: false,
                processData: false,
                success: function(data) {
                    $('#myModalKonfirmasi').modal('hide')
                    $('#form').trigger("reset")
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses',
                        text: 'Sukses melakukan persetujuan izin!',
                        willClose: () => {
                            loadData()
                        }
                    })
                },
                error: function(request, msg, error) {
                    $('#myModalKonfirmasi').modal('hide')
                    $('#form').trigger("reset")
                    console.log(msg)
                }
            })
        })

        function formatDateToDMY(dateString) {
            var date = new Date(dateString);

            var day = date.getDate();
            var month = date.getMonth() + 1; // Months are zero-indexed
            var year = date.getFullYear();

            // Add leading zero if day or month is a single digit
            if (day < 10) {
                day = '0' + day;
            }
            if (month < 10) {
                month = '0' + month;
            }

            return day + '/' + month + '/' + year;
        }

        function formatTimeToHHMM(timeString) {
            // Split the time string by colon
            var parts = timeString.split(':');

            // Get the hours and minutes
            var hours = parts[0];
            var minutes = parts[1];

            return hours + ':' + minutes;
        }
    </script>
@endpush
