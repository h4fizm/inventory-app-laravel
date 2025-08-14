@extends('main')
@section('title', 'Tambah Barang')
@section('content')

<style>
    #map {
        height: 350px;
        z-index: 1; 
        border-radius: 0.5rem;
    }
</style>

<div class="row">
    <div class="col-12">
        <h3 class="mb-0 h4 font-weight-bolder">Tambah Barang</h3>
        <p class="mb-4">Tambahkan data barang baru ke dalam sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <h5 class="mb-3">Form Data Barang</h5>
            <form action="#" id="form-tambah-barang" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="text" placeholder="Nama Barang" class="form-control" id="nama_barang" name="nama_barang" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <select class="form-select" id="nama_kategori" name="nama_kategori" required>
                                <option selected disabled value="">Pilih Kategori...</option>
                                <option value="kategori-1">Kategori 1</option>
                                <option value="kategori-2">Kategori 2</option>
                                <option value="kategori-3">Kategori 3</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="text" placeholder="Kode Barang" class="form-control" id="kode_barang" name="kode_barang" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="number" placeholder="Jumlah Barang" class="form-control" id="jumlah_barang" name="jumlah_barang" required>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <h5 class="mb-3">Tentukan Lokasi Barang</h5>
            <p class="text-sm text-secondary">Klik pada peta untuk menentukan lokasi dan mengisi koordinat.</p>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-outline my-3">
                        <input type="text" placeholder="Latitude" class="form-control" id="latitude" name="latitude" form="form-tambah-barang" readonly required>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-outline my-3">
                        <input type="text" placeholder="Longitude" class="form-control" id="longitude" name="longitude" form="form-tambah-barang" readonly required>
                    </div>
                </div>
                <div class="col-12">
                    <div id="map"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12 text-end">
        <button type="submit" class="btn btn-primary" form="form-tambah-barang">Tambah Barang</button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');
        const formTambahBarang = document.getElementById('form-tambah-barang');

        const surabayaCoords = [-7.2575, 112.7521];

        const map = L.map('map').setView(surabayaCoords, 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        let marker;

        function updateMarker(latlng) {
            if (marker) {
                map.removeLayer(marker);
            }
            marker = L.marker(latlng).addTo(map);
            latitudeInput.value = latlng.lat.toFixed(6);
            longitudeInput.value = latlng.lng.toFixed(6);
            latitudeInput.parentElement.classList.add('is-filled');
            longitudeInput.parentElement.classList.add('is-filled');
        }

        map.on('click', function(e) {
            updateMarker(e.latlng);
        });

        updateMarker(surabayaCoords);
        
        setTimeout(function() {
            map.invalidateSize();
        }, 100);

        formTambahBarang.addEventListener('submit', function(e) {
            e.preventDefault(); 
            
            // Validasi manual semua field
            let allFieldsFilled = true;
            const requiredFields = formTambahBarang.querySelectorAll('[required]');

            requiredFields.forEach(field => {
                if (!field.value || (field.tagName === 'SELECT' && field.value === '')) {
                    allFieldsFilled = false;
                    // Tambahkan highlight pada field yang kosong (opsional)
                    // field.parentElement.classList.add('is-invalid');
                }
            });

            if (!allFieldsFilled) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Semua kolom wajib diisi!',
                });
                return;
            }

            // Validasi manual untuk latitude dan longitude
            if (!latitudeInput.value || !longitudeInput.value) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Koordinat lokasi wajib diisi. Silakan klik pada peta.',
                });
                return; 
            }
            
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data barang berhasil disimpan!',
                showConfirmButton: false,
                timer: 1500
            });

            formTambahBarang.reset();
            
            if (marker) {
                map.removeLayer(marker);
            }
            latitudeInput.parentElement.classList.remove('is-filled');
            longitudeInput.parentElement.classList.remove('is-filled');
            
            updateMarker(surabayaCoords);
        });
    });
</script>
@endsection