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
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3><a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i></a> Laporan Absensi</h3>
                </div>
            </div>
        </div>

        <div class="form-check form-switch fs-6 d-none">
            <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
            <label class="form-check-label"></label>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
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
                        <div class="col-6">
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
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <p><b><span class="text-success me-4">&#10004; : Tepat Waktu</span></b></p>
                    <p><b><span class="text-warning me-4">&#10004; : Terlambat Dengan Toleransi</span></b></p>
                    <p><b><span class="text-danger me-4">&#10004; : Terlambat Tanpa Toleransi</span></b></p>
                    <p><b><span class="me-4">&ndash; : Tidak Hadir</span></b></p>
                    <div class="table-responsive mt-3">
                        <table class="table table-bordered" id="data-table">
                            <thead>
                                <tr>
                                    <th class="text-center" rowspan="2" width="2%">No</th>
                                    <th class="text-center" rowspan="2" width="10%">Tanggal</th>
                                    <th class="text-center" rowspan="2" width="10%">Hari</th>
                                    <th class="text-center" colspan="2" width="10%">Waktu</th>
                                    <th class="text-center" rowspan="2" width="10%">Jumlah Jam Kerja</th>
                                    <th class="text-center" rowspan="2" width="10%">Status</th>
                                </tr>
                                <tr>
                                    <th class="text-center">Masuk</th>
                                    <th class="text-center">Pulang</th>
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
            $.ajax({
                url: "{{ route('absensi.laporan-absensi.index') }}",
                method: "GET",
                dataType: "json",
                data: {
                    bulan: bulan,
                    tahun: tahun,
                },
                success: function(data) {
                    populateCardContainer(data.tanggal, data.absensi, data.cuti, data.hari_libur_normal, data
                        .hari_libur_nasional);
                },
                error: function() {
                    console.log("Error fetching data.")
                }
            });
        }

        function populateCardContainer(tanggal, absensi, cuti, hari_libur_normal, hari_libur_nasional) {
            var tableBody = $('#data-table tbody');
            tableBody.empty();
            tanggal.forEach((value, index) => {
                let data = `<tr>
                    <td class="text-center">${index + 1}</td>
                    <td class="text-center">${formatDateToDMY(value)}</td>
                    <td class="text-center">${getNameDay(value)}</td>`
                const data_absensi = absensi.find(item => item.tanggal === value)
                const data_cuti = cuti.find(item => value >= item.dari_tanggal && value <= item.sampai_tanggal)
                const isLiburNormal = hari_libur_normal.some(item => item.hari === getNameDay(value))
                const libur_nasional = hari_libur_nasional.find(item => item.tanggal === value)

                if (data_absensi) {
                    let jam_pulang = '-';
                    let jumlah_jam_kerja = '-';
                    let status_absensi;
                    if (data_absensi.jam_pulang) {
                        const timeDifference = calculateTimeDifference(data_absensi.jam_masuk, data_absensi
                            .jam_pulang);
                        jam_pulang = data_absensi.jam_pulang ? formatTimeToHHMM(data_absensi.jam_pulang) :
                            '-';
                        jumlah_jam_kerja = data_absensi.jam_pulang ? timeDifference.hours + ' jam ' +
                            timeDifference.minutes + ' menit' :
                            '-';
                    }

                    switch (data_absensi.status_absensi) {
                        case 1:
                            status_absensi = '<b><span class="text-success">&#10004;</span></b>';
                            break;
                        case 2:
                            status_absensi = '<b><span class="text-warning">&#10004;</span></b>';
                            break;
                        case 3:
                            status_absensi = '<b><span class="text-danger">&#10008;</span></b>';
                            break;
                        default:
                            status_absensi = '<b><span class="text-dark">-</span></b>';
                    }

                    data +=
                        `<td class="text-center">${formatTimeToHHMM(data_absensi.jam_masuk)}</td>
                        <td class="text-center">${jam_pulang}</td>
                        <td class="text-center">${jumlah_jam_kerja}</td>
                        <td class="text-center">${status_absensi}</td>`
                }

                if (data_cuti) {
                    if (value >= data_cuti.dari_tanggal && value <= data_cuti.sampai_tanggal) {
                        data +=
                            `<td colspan="4" class="bg-warning text-white text-center">${data_cuti.jenis_cuti}</td>`
                    }
                }

                if (isLiburNormal) {
                    data += `<td colspan="4" class="text-center">Hari Libur</td>`
                }

                if (libur_nasional) {
                    data += `<td colspan="4" class="bg-danger text-white text-center">${libur_nasional.nama}</td>`
                }
                data += `</tr>`
                tableBody.append(data)
            });
        }

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

        function getNameDay(dateString) {
            const date = new Date(dateString);

            const options = {
                weekday: 'long',
                timeZone: 'UTC'
            }; // 'long' gives the full day name
            const formatter = new Intl.DateTimeFormat('id-ID', options);

            const dayName = formatter.format(date);

            return dayName;
        }

        function formatTimeToHHMM(timeString) {
            // Split the time string by colon
            var parts = timeString.split(':');

            // Get the hours and minutes
            var hours = parts[0];
            var minutes = parts[1];

            return hours + ':' + minutes;
        }

        function calculateTimeDifference(startTime, endTime) {
            const [startHours, startMinutes, startSeconds] = startTime.split(":").map(Number);
            const [endHours, endMinutes, endSeconds] = endTime.split(":").map(Number);

            const totalStartMinutes = startHours * 60 + startMinutes + startSeconds / 60;
            const totalEndMinutes = endHours * 60 + endMinutes + endSeconds / 60;

            const timeDifference = totalEndMinutes - totalStartMinutes;

            const hours = Math.floor(timeDifference / 60);
            const minutes = Math.floor(timeDifference % 60);

            return {
                hours,
                minutes
            };
        }
    </script>
@endpush
