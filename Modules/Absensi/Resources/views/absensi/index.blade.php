@extends('layouts.app')

@push('custom-css-start')
    <link rel="stylesheet" href="{{ asset('assets/extensions/choices.js/public/assets/styles/choices.css') }}">
@endpush

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/pages/datatables.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        #map {
            height: 480px;
        }
    </style>
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Daftar Absensi</h3>
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
                        <div class="col-lg-4 col-md-4 col-sm-12 col-12 mt-3">
                            <div class="form-group">
                                <button id="unduh-excel" class="btn btn-success"><i
                                        class="bi bi-file-earmark-arrow-down"></i>
                                    Unduh Excel</button>
                                <button id="unduh-pdf" class="btn btn-danger"><i class="bi bi-file-earmark-arrow-down"></i>
                                    Unduh PDF</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <p><span class="text-success me-4">&#10004; : Tepat Waktu</span></p>
                    <p><span class="text-warning me-4">&#10004; : Terlambat Dengan Toleransi</span></p>
                    <p><span class="text-danger me-4">&#10004; : Terlambat Tanpa Toleransi</span></p>
                    <p><span class="me-4">&ndash; : Tidak Hadir</span></p>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered" id="dataTable" width="100%">
                            <thead>
                                <tr>
                                    <th class="d-none">Nomor</th>
                                    <th class="text-center" width="20%">Nama</th>
                                    <th class="text-center" width="15%">Tanggal</th>
                                    <th class="text-center" width="10%">Hari</th>
                                    <th class="text-center" width="10%">Jam Masuk</th>
                                    <th class="text-center" width="10%">Jam Pulang</th>
                                    <th class="text-center" width="15%">Jam Kerja</th>
                                    <th class="text-center" width="10%">Status</th>
                                    <th class="none">Jam Masuk</th>
                                    <th class="none">Jam Pulang</th>
                                    <th class="none">Status Absensi</th>
                                    <th class="none">Status Lokasi Masuk</th>
                                    <th class="none">Status Lokasi Pulang</th>
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
                                    <label for="input-status-lokasi">Status Lokasi</label>
                                    <input id="input-status-lokasi" name="status_lokasi" class="form-control"
                                        readonly></input>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="map">Lokasi</label>
                                    <div id="map"></div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="input-kuota">Foto</label>
                                    <div class="text-center">
                                        <img id="input-bukti-foto" width="100%" src="" class="rounded"
                                            alt="...">
                                    </div>
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
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.2.3/js/buttons.print.min.js"></script>
    <script src="{{ asset('assets/extensions/choices.js/public/assets/scripts/choices.js') }}"></script>
    <script src="{{ asset('assets/js/pages/form-element-select.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
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
                    url: "{{ route('absensi.daftar-absensi.index') }}",
                    data: function(d) {
                        d.bulan = $('#filter-bulan').val(),
                            d.tahun = $('#filter-tahun').val(),
                            d.guru = $('#filter-guru').val()
                    }
                },
                columnDefs: [{
                    "targets": 0,
                    "render": function(data, type, row, meta) {
                        return meta.row + 1
                    }
                }],
                columns: [{
                        data: 'nomor',
                        name: 'nomor',
                        visible: false
                    },
                    {
                        data: 'nama',
                        name: 'nama'
                    },
                    {
                        data: 'tanggal',
                        name: 'tanggal',
                        className: 'text-center'
                    },
                    {
                        data: 'hari',
                        name: 'hari',
                        className: 'text-center'
                    },
                    {
                        data: 'jam_masuk',
                        name: 'jam_masuk',
                        className: 'text-center'
                    },
                    {
                        data: 'jam_pulang',
                        name: 'jam_pulang',
                        className: 'text-center'
                    },
                    {
                        data: 'jam_kerja',
                        name: 'jam_kerja',
                        className: 'text-center'
                    },
                    {
                        data: 'status_absensi',
                        name: 'status_absensi',
                        className: 'text-center'
                    },
                    {
                        data: 'jam_masuk_export',
                        name: 'jam_masuk_export',
                        visible: false
                    },
                    {
                        data: 'jam_pulang_export',
                        name: 'jam_pulang_export',
                        visible: false
                    },
                    {
                        data: 'status_export',
                        name: 'status_export',
                        visible: false
                    },
                    {
                        data: 'status_lokasi_masuk_export',
                        name: 'status_lokasi_masuk_export',
                        visible: false
                    },
                    {
                        data: 'status_lokasi_pulang_export',
                        name: 'status_lokasi_pulang_export',
                        visible: false
                    },
                    {
                        data: 'aksi',
                        name: 'aksi',
                        className: 'text-center'
                    }
                ],
                dom: 'Blfrtip',
                buttons: [{
                        extend: 'excelHtml5',
                        text: 'excel',
                        title: function() {
                            let bulan = $("#filter-bulan").find(":selected").text()
                            let tahun = $("#filter-tahun").find(":selected").text()
                            return 'Daftar Absensi ' + $.trim(bulan) + ' ' + $.trim(tahun)
                        },
                        filename: function() {
                            let bulan = $("#filter-bulan").find(":selected").text()
                            let tahun = $("#filter-tahun").find(":selected").text()
                            return 'Daftar Absensi ' + $.trim(bulan) + ' ' + $.trim(tahun)
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 8, 9, 10, 11, 12]
                        },
                    },
                    {
                        extend: 'pdfHtml5',
                        text: 'pdf',
                        orientation: 'potrait',
                        title: function() {
                            let bulan = $("#filter-bulan").find(":selected").text()
                            let tahun = $("#filter-tahun").find(":selected").text()
                            return 'Daftar Absensi ' + $.trim(bulan) + ' ' + $.trim(tahun)
                        },
                        filename: function() {
                            let bulan = $("#filter-bulan").find(":selected").text()
                            let tahun = $("#filter-tahun").find(":selected").text()
                            return 'Daftar Absensi ' + $.trim(bulan) + ' ' + $.trim(tahun)
                        },
                        exportOptions: {
                            columns: [0, 1, 2, 3, 8, 9, 10, 11, 12]
                        },
                    }
                ],
                drawCallback: function(settings) {
                    $('.dt-buttons').hide()
                }
            });
        }

        $('#unduh-excel').click(function(e) {
            $('#dataTable_wrapper .dt-buttons .buttons-excel').click()
        })

        $('#unduh-pdf').click(function(e) {
            $('#dataTable_wrapper .dt-buttons .buttons-pdf').click();
        });

        function reinitTable() {
            $('#dataTable').DataTable().clear().destroy()
            initTable()
        }

        var map;

        function detailBerkas(foto, lat_absensi, long_absensi, lat_instansi, long_instansi, radius, status) {
            $('#myModalBerkas').modal('show');
            let url = "{{ asset('assets/images/absensi') }}" + '/' + foto;
            $("#input-bukti-foto").attr("src", url);
            $("#input-status-lokasi").val(status);

            $('#myModalBerkas').on('shown.bs.modal', function() {
                if (map) {
                    map.remove(); // Remove the previous map and its components
                }
                initMap(lat_absensi, long_absensi, lat_instansi, long_instansi, radius);
            });
        }

        function initMap(lat_absensi, long_absensi, lat_instansi, long_instansi, radius) {
            var mapContainer = document.getElementById('map');
            map = L.map(mapContainer).setView([lat_absensi, long_absensi], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
            }).addTo(map);

            var officeLocation = [lat_instansi, long_instansi];
            var myLocation = [lat_absensi, long_absensi];

            var officeIcon = L.icon({
                iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
                iconSize: [25, 41],
                iconAnchor: [12, 41],
                popupAnchor: [1, -34]
            });

            var officeMarker = L.marker(officeLocation, {
                    icon: officeIcon
                }).addTo(map)
                .bindPopup('Lokasi Sekolah')
                .openPopup();

            var myMarker = L.marker(myLocation).addTo(map)
                .bindPopup('Lokasi Absensi')
                .openPopup();

            var circle = L.circle(officeLocation, {
                color: 'green',
                fillColor: 'rgba(255, 0, 0, 0)',
                fillOpacity: 0.3,
                radius: radius
            }).addTo(map);

            officeMarker.addTo(map);
            myMarker.addTo(map);
            circle.addTo(map);
        }
    </script>
@endpush
