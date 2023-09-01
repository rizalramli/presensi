@extends('layouts.app_guru')

@push('custom-css-end')
    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.css') }}">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <style>
        #map {
            height: 400px;
            width: 100%;
        }
    </style>
    <meta name="csrf-token" content="{{ csrf_token() }}">
@endpush

@section('content')
    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3><a href="{{ route('home') }}"><i class="bi bi-arrow-left"></i></a> Absensi
                        Pulang</h3>
                </div>
            </div>
        </div>

        <div class="form-check form-switch fs-6 d-none">
            <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
            <label class="form-check-label"></label>
        </div>

        <!-- Basic Tables start -->
        <section class="section">
            <div class="row">
                @if (empty($is_absensi_masuk))
                    <div class="col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Anda belum melakukan absen masuk</h5>
                            </div>
                        </div>
                    </div>
                @elseif (!empty($is_absensi))
                    <div class="col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Anda sudah melakukan absen pulang pada pukul
                                    {{ date('H:i', strtotime($is_absensi->jam_pulang)) }}</h5>
                            </div>
                        </div>
                    </div>
                @elseif (!empty($is_cuti))
                    <div class="col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Anda hari ini telah melakukan cuti dengan jenis
                                    {{ $is_cuti->jenis_cuti }}</h5>
                            </div>
                        </div>
                    </div>
                @elseif (!empty($is_libur_normal))
                    <div class="col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Hari ini adalah hari libur karena hari {{ $is_libur_normal->hari }}
                                </h5>
                            </div>
                        </div>
                    </div>
                @elseif (!empty($is_libur_nasional))
                    <div class="col-12">
                        <div class="card text-center">
                            <div class="card-body">
                                <h5 class="card-title">Hari ini adalah hari libur yang memperingati
                                    {{ $is_libur_nasional->nama }}</h5>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <a href="{{ route('absensi.pulang-absensi.index') }}" class="btn btn-sm btn-primary mb-3">
                                    <i class="bi bi-arrow-clockwise"></i></i>
                                    Refresh
                                    Halaman</a>
                                <button id="captureButton" class="btn btn-sm btn-primary mb-3"> <i
                                        class="bi bi-camera"></i></i> Ambil
                                    Foto</button>

                                <div class="modal" id="pictureModal" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-body">
                                                <video style="width: 100%" id="cameraVideo" autoplay playsinline></video>
                                            </div>
                                            <div class="modal-footer">
                                                <button id="captureSnapshot" class="btn btn-primary">Ambil Foto</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div id="map"></div>
                            </div>
                            <div class="card-footer">
                                <button id="submitButton" class="btn btn-primary"> Simpan Absensi</button>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
        <!-- Basic Tables end -->
    </div>
@endsection

@push('custom-script')
    <script src="{{ asset('assets/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/extensions/sweetalert2/sweetalert2.min.js') }}"></script>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <script>
        $(document).ready(function() {
            ajaxSetup()
            const captureButton = $("#captureButton");
            const pictureModal = $("#pictureModal");
            const captureSnapshotButton = $("#captureSnapshot");
            const cameraVideo = document.getElementById("cameraVideo");
            let cameraStream = null;

            captureButton.on("click", function() {
                if (!cameraStream) {
                    navigator.mediaDevices.getUserMedia({
                            video: true,
                        })
                        .then(function(stream) {
                            cameraStream = stream;
                            cameraVideo.srcObject = stream;
                            pictureModal.modal("show");

                            captureSnapshotButton.on("click", function() {
                                captureSnapshot();
                                stopCamera();
                                pictureModal.modal("hide");
                            });
                        })
                        .catch(function(error) {
                            console.error("Error accessing camera:", error);
                        });
                } else {
                    resetCapture();
                    pictureModal.modal("show");
                }
            });

            function resetCapture() {
                // Clear the previously captured image
                $(".modal-body").empty();

                // Reset video stream
                cameraVideo.srcObject = cameraStream;

                // Clear the current stream from the canvas
                const canvas = document.createElement("canvas");
                canvas.width = cameraVideo.videoWidth;
                canvas.height = cameraVideo.videoHeight;
                const context = canvas.getContext("2d");
                context.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);

                // Append the canvas to the modal body
                $(".modal-body").append(canvas);
            }

            function stopCamera() {
                if (cameraStream) {
                    cameraStream.getTracks().forEach((track) => track.stop());
                    cameraStream = null;
                }
            }

            function captureSnapshot() {
                if (cameraStream) {
                    const canvas = document.createElement("canvas");
                    canvas.width = cameraVideo.videoWidth;
                    canvas.height = cameraVideo.videoHeight;
                    const context = canvas.getContext("2d");
                    context.drawImage(cameraVideo, 0, 0, canvas.width, canvas.height);

                    const capturedImage = document.createElement("img");
                    capturedImage.id = "capturedImage";
                    capturedImage.src = canvas.toDataURL("image/png");
                    capturedImage.style.width = "100%";

                    // Append the captured image to the modal body
                    $("#captureButton").hide();
                    $(".modal-body").empty();
                    $(".modal-body").append(capturedImage);
                }
            }

        });

        function ajaxSetup() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        }

        var map = L.map('map').setView([0, 0], 15);
        let latitude = "{{ $instansi->latitude }}"
        let longitude = "{{ $instansi->longitude }}"
        let radius = "{{ $instansi->radius_absensi }}"

        // Add a tile layer to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Set the latitude and longitude of your office
        var officeLocation = [latitude, longitude];

        var officeIcon = L.icon({
            iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
            iconSize: [25, 41],
            iconAnchor: [12, 41],
            popupAnchor: [1, -34]
        });

        // Create a marker for your office's location
        var officeMarker = L.marker(officeLocation, {
            icon: officeIcon
        }).addTo(map).bindPopup("Lokasi Sekolah");

        var userMarker;

        // Get the user's location
        function onLocationFound(e) {
            var userLocation = e.latlng;

            if (userMarker) {
                map.removeLayer(userMarker);
            }

            // Create a marker for the user's location
            userMarker = L.marker(userLocation).addTo(map).bindPopup("Lokasi Anda").openPopup();

            // Create a circle radius indicator
            var radiusCircle = L.circle(officeLocation, {
                color: 'green',
                fillColor: 'rgba(255, 0, 0, 0)',
                fillOpacity: 0.3,
                radius: radius
            }).addTo(map);

            // Fit the map bounds to include the user's location and radius circle
            var bounds = L.latLngBounds([userLocation, officeLocation, radiusCircle.getBounds()]);
            map.fitBounds(bounds);
        }

        function onLocationError(e) {
            if (e.code === 1) {
                Swal.fire({
                    icon: 'info',
                    title: 'Informasi!',
                    text: 'Akses geolokasi telah ditolak. Harap aktifkan geolokasi di pengaturan browser Anda.'
                })
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Terjadi kesalahan saat mendapatkan lokasi Anda: ' + e.message
                })
            }
        }

        map.on('locationfound', onLocationFound);
        map.on('locationerror', onLocationError);

        // Locate the user
        map.locate({
            setView: true,
            maxZoom: 16
        });

        function submitLocation() {
            if (userMarker) {
                var userLocation = userMarker.getLatLng();

                var distance = userLocation.distanceTo(L.latLng(officeLocation));
                let status_lokasi;
                let capturedImage = $("#capturedImage");
                if (capturedImage.length === 0 || !capturedImage.attr("src")) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan!',
                        text: 'Silahkan ambil foto terlebih dahulu.'
                    })
                } else {
                    capturedImage = $("#capturedImage").attr("src");
                    if (distance > radius) {
                        status_lokasi = 0
                    } else {
                        status_lokasi = 1
                    }

                    $.ajax({
                        type: "POST",
                        url: "{{ route('absensi.pulang-absensi.store') }}",
                        data: {
                            latitude_pulang: userLocation.lat,
                            longitude_pulang: userLocation.lng,
                            status_lokasi_pulang: status_lokasi,
                            image: capturedImage
                        },
                        success: function(response) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Sukses melakukan absensi pulang',
                                willClose: () => {
                                    window.location.href = "{{ route('home') }}";
                                }
                            })
                        },
                        error: function(xhr, status, error) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi error di kesalahan server.' + error
                            })
                        }
                    });
                }
            } else {
                Swal.fire({
                    icon: 'warning',
                    title: 'Peringatan!',
                    text: 'Lokasi pengguna tidak tersedia.'
                })
            }
        }

        var submitButton = document.getElementById('submitButton');
        submitButton.addEventListener('click', submitLocation);
    </script>
@endpush
