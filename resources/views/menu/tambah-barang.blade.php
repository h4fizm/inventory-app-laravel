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

@if ($errors->any())
    <div class="row mt-4">
        <div class="col-12">
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Gagal!</strong> Terdapat beberapa masalah dengan input Anda.
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <h5 class="mb-3">Form Data Barang</h5>
            <form action="{{ route('tambah-barang.store') }}" method="POST" id="form-tambah-barang" novalidate>
                @csrf 
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="text" placeholder="Nama Barang" class="form-control" id="nama_barang" name="nama_barang" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <select class="form-select" id="category_id" name="category_id" required>
                                <option selected disabled value="">Pilih Kategori...</option>
                                @foreach($unique_categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                                @endforeach
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
                <div class="row">
                    <div class="col-12 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="text" placeholder="Letak Lokasi Barang" class="form-control" id="lokasi_barang" name="lokasi_barang" required>
                        </div>
                    </div>
                </div>
                
                <div class="row">
                    <div class="col-12">
                        {{-- Judul teks untuk peta --}}
                        <h5 class="mb-3">Pilih Lokasi Letak Barang</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="text" placeholder="Latitude" class="form-control" id="latitude" name="latitude" readonly required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <input type="text" placeholder="Longitude" class="form-control" id="longitude" name="longitude" readonly required>
                        </div>
                    </div>
                    <div class="col-12">
                        <div id="map"></div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Tambah Barang</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const latitudeInput = document.getElementById('latitude');
        const longitudeInput = document.getElementById('longitude');

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
    });
</script>
@endsection