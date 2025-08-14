@extends('main')
@section('title', 'Preview Barang')
@section('content')

<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20n6bbA1zwWThERD8M5nS1kZT4fC/eW1fofZ61/1x4u0=" crossorigin=""></script>

<style>
    #map {
        height: 350px;
        z-index: 1; 
        border-radius: 0.5rem;
    }
    .input-group.input-group-outline .form-label {
        background-color: #fff;
        padding: 0 5px;
        transform: translateY(-0.85rem);
    }
</style>

<div class="row">
    <div class="col-12">
        <h3 class="mb-0 h4 font-weight-bolder">Preview Barang</h3>
        <p class="mb-4">Pratinjau data barang yang terdaftar dalam sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <h5 class="mb-3">Informasi Barang</h5>
            <form>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" value="Keyboard Mekanik RGB" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Nama Kategori</label>
                            <input type="text" class="form-control" value="Aksesoris PC" readonly>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Kode Barang</label>
                            <input type="text" class="form-control" value="KB-001" readonly>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Jumlah Barang</label>
                            <input type="number" class="form-control" value="12" readonly>
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
            <h5 class="mb-3">Lokasi Barang</h5>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-outline my-3 is-filled">
                        <label class="form-label">Latitude</label>
                        <input type="text" class="form-control" id="latitude" value="-7.257500" readonly>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="input-group input-group-outline my-3 is-filled">
                        <label class="form-label">Longitude</label>
                        <input type="text" class="form-control" id="longitude" value="112.752100" readonly>
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
        <a href="/menu/dashboard" class="btn btn-secondary">Kembali</a>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const map = L.map('map').setView([-7.2575, 112.7521], 13);

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);

        // Tambahkan marker di lokasi dummy
        L.marker([-7.2575, 112.7521]).addTo(map)
            .bindPopup('Lokasi Barang')
            .openPopup();

        setTimeout(function() {
            map.invalidateSize();
        }, 100);
    });
</script>

@endsection