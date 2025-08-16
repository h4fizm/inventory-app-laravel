@extends('main')
@section('title', 'Laman Manage Barang')
@section('content')

{{-- CSS untuk kustomisasi pagination dan map --}}
<style>
    .pagination .page-item .page-link {
        background-color: #6c757d;
        color: #fff;
        border-color: #6c757d;
        transition: background-color 0.3s, color 0.3s;
    }
    .pagination .page-item .page-link:hover,
    .pagination .page-item.active .page-link {
        background-color: #5a6268;
        color: #fff;
        border-color: #5a6268;
    }
    .pagination .page-item.disabled .page-link {
        background-color: #e9ecef;
        color: #6c757d;
        cursor: not-allowed;
        border-color: #dee2e6;
    }
    .pagination .page-item.disabled .page-link:hover {
        background-color: #e9ecef;
        color: #6c757d;
    }
    #map-lokasi {
        height: 400px;
        z-index: 1;
        border-radius: 0.5rem;
    }
    .pagination .page-item .page-link span {
        color: #fff; /* Memastikan ikon panah berwarna putih */
    }
    .pagination .page-item.disabled .page-link span {
        color: #6c757d; /* Memastikan ikon panah berwarna abu-abu saat disabled */
    }
    /* Tambahan CSS untuk memperbaiki scroll pada modal */
    .modal-open .modal {
        overflow-x: hidden;
        overflow-y: auto;
    }
</style>

<div class="row">
    <div class="col-12">
        <h3 class="mb-0 h4 font-weight-bolder">Manage Barang</h3>
        <p class="mb-4">Daftar semua produk yang terdaftar dalam sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        {{-- Alert Notifikasi Sukses --}}
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        {{-- Alert Notifikasi Error (misal: validasi gagal) --}}
        @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Gagal memperbarui data!</strong>
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif

        <div class="card p-3">
            {{-- Bagian filter dan search --}}
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar Barang</h5>
                <div class="d-flex align-items-center flex-wrap">
                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                        <label for="tanggal_mulai" class="form-label mb-0 me-2">Dari</label>
                        <input type="date" class="form-control" id="tanggal_mulai">
                    </div>
                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                        <label for="tanggal_akhir" class="form-label mb-0 me-2">Hingga</label>
                        <input type="date" class="form-control" id="tanggal_akhir">
                    </div>
                    <div class="input-group w-auto me-3 mb-2 mb-md-0">
                        <span class="input-group-text"><i class="material-symbols-rounded opacity-10">search</i></span>
                        <input type="text" class="form-control" id="search-input" placeholder="Cari...">
                    </div>
                </div>
            </div>
            
            <div class="table-responsive p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Barang</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kode Barang</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Barang</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Lokasi Barang</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Terakhir Update</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if($data_barang->isEmpty())
                            <tr id="no-data-row">
                                <td colspan="8" class="text-center text-secondary">Data barang tidak ditemukan.</td>
                            </tr>
                        @else
                            @foreach($data_barang as $index => $item)
                                <tr class="data-row" data-id="{{ $item->id }}" data-updated-at="{{ $item->updated_at }}">
                                    <td><p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p></td>
                                    <td class="nama-barang-cell"><p class="text-xs font-weight-bold mb-0">{{ $item->nama_barang }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->kode_barang }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->kategori->nama_kategori ?? 'N/A' }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->jumlah_barang }}</p></td>
                                    <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->lokasi_barang }}</p></td>
                                    <td class="text-center">
                                        <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                                    </td>
                                    <td class="text-center">
                                        <a href="#" class="btn btn-sm btn-dark mb-0 lokasi-btn" data-bs-toggle="modal" data-bs-target="#lokasiModal"
                                            data-latitude="{{ $item->latitude }}"
                                            data-longitude="{{ $item->longitude }}"
                                            data-lokasi-barang="{{ $item->lokasi_barang }}"
                                        >Lokasi</a>
                                        <a href="#" class="btn btn-sm btn-warning mb-0 edit-btn"
                                            data-bs-toggle="modal"
                                            data-bs-target="#editBarangModal"
                                            data-id="{{ $item->id }}"
                                            data-nama="{{ $item->nama_barang }}"
                                            data-kode="{{ $item->kode_barang }}"
                                            data-jumlah="{{ $item->jumlah_barang }}"
                                            data-kategori-id="{{ $item->category_id }}">
                                            Edit
                                        </a>
                                        <a href="#" class="btn btn-sm btn-danger mb-0 delete-btn" data-id="{{ $item->id }}">Delete</a>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        <tr id="no-data-row-js" style="display: none;">
                            <td colspan="8" class="text-center text-secondary">Data Tidak Ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            {{-- Pagination --}}
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" id="first-page">
                            <a class="page-link" href="#">&laquo;</a>
                        </li>
                        <li class="page-item" id="prev-page">
                            <a class="page-link" href="#">&lt;</a>
                        </li>
                        <div id="page-numbers" class="d-flex"></div>
                        <li class="page-item" id="next-page">
                            <a class="page-link" href="#">&gt;</a>
                        </li>
                        <li class="page-item" id="last-page">
                            <a class="page-link" href="#">&raquo;</a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>

{{-- Edit Barang Modal --}}
<div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editBarangForm" method="POST">
                    @csrf
                    @method('PUT')
                    {{-- Perbaikan: Hapus 'name="id"' untuk menghindari konflik dengan Route Model Binding --}}
                    <input type="hidden" id="edit_item_id"> 
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama_barang" name="nama_barang">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="edit_kode_barang" name="kode_barang">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_jumlah_barang" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="edit_jumlah_barang" name="jumlah_barang">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <select class="form-select" id="edit_nama_kategori" name="category_id">
                            {{-- Dropdown kategori diisi oleh JavaScript --}}
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveChangesBtn">Simpan Perubahan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal untuk menampilkan dan mengedit peta lokasi --}}
<div class="modal fade" id="lokasiModal" tabindex="-1" aria-labelledby="lokasiModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="lokasiModalLabel">Lokasi Barang: <span id="lokasi-nama-barang"></span></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="lokasiForm" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" id="lokasi_row_id">
                    <p class="text-sm text-secondary">Klik pada peta untuk menentukan lokasi baru.</p>
                    <div id="map-lokasi" class="mb-3"></div>
                    <div class="row">
                        <div class="col-12 mb-3">
                            <div class="input-group input-group-outline my-3">
                                <label for="lokasi_barang_input" class="form-label">Nama Lokasi Barang</label>
                                <input type="text" class="form-control" id="lokasi_barang_input" name="lokasi_barang" required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline my-3">
                                <label for="lokasi_latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="lokasi_latitude" name="latitude" readonly required>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline my-3">
                                <label for="lokasi_longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="lokasi_longitude" name="longitude" readonly required>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveLokasiBtn">Simpan Lokasi</button>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('.table tbody');
        const paginationContainer = document.querySelector('nav[aria-label="Page navigation example"]');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const searchInput = document.getElementById('search-input');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');
        
        // Mengambil semua baris dari tabel
        const allRows = Array.from(document.querySelectorAll('.table tbody tr.data-row'));
        const noDataRow = document.getElementById('no-data-row');
        const noDataRowJS = document.getElementById('no-data-row-js');
        const rowsPerPage = 10;
        let currentPage = 1;
        let visibleRows = [];
        let mapLokasi;
        let mapMarker;
        const lokasiModalElement = document.getElementById('lokasiModal');
        const editBarangModalElement = document.getElementById('editBarangModal');

        // Tampilkan notifikasi sukses dan error jika ada
        const successAlert = document.querySelector('.alert.alert-success');
        if (successAlert) {
            setTimeout(() => {
                const bootstrapAlert = bootstrap.Alert.getOrCreateInstance(successAlert);
                bootstrapAlert.close();
            }, 5000);
        }

        const errorAlert = document.querySelector('.alert.alert-danger');
        if (errorAlert) {
            setTimeout(() => {
                const bootstrapAlert = bootstrap.Alert.getOrCreateInstance(errorAlert);
                bootstrapAlert.close();
            }, 8000);
        }

        function cleanupModalBackdrops() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        function closeModalWithCleanup(modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            modalElement.addEventListener('hidden.bs.modal', function handler() {
                cleanupModalBackdrops();
                modalElement.removeEventListener('hidden.bs.modal', handler);
            }, { once: true });
        }
        
        // Fungsi untuk memperbarui daftar baris yang terlihat
        function updateVisibleRows() {
            const searchQuery = searchInput.value.toLowerCase();
            const startDate = tanggalMulaiInput.value;
            const endDate = tanggalAkhirInput.value;

            visibleRows = allRows.filter(row => {
                const rowText = row.textContent.toLowerCase();
                const rowDate = row.getAttribute('data-updated-at');
                const searchMatch = rowText.includes(searchQuery);
                let dateMatch = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
                return searchMatch && dateMatch;
            });
        }
        
        // Fungsi untuk menampilkan halaman tertentu
        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;
            let currentNumber = start + 1;

            allRows.forEach(row => row.style.display = 'none');
            for (let i = start; i < end && i < visibleRows.length; i++) {
                const row = visibleRows[i];
                row.querySelector('td:first-child p').textContent = currentNumber++;
                row.style.display = '';
            }
        }
        
        // Fungsi untuk merender pagination
        function renderPagination() {
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage);
            pageNumbersContainer.innerHTML = '';
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = `page-item${i === currentPage ? ' active' : ''}`;
                li.setAttribute('data-page', i);
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                pageNumbersContainer.appendChild(li);
            }

            const firstPageBtn = document.getElementById('first-page');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            const lastPageBtn = document.getElementById('last-page');
            
            firstPageBtn.classList.toggle('disabled', currentPage === 1 || totalPages === 0);
            prevPageBtn.classList.toggle('disabled', currentPage === 1 || totalPages === 0);
            nextPageBtn.classList.toggle('disabled', currentPage === totalPages || totalPages === 0);
            lastPageBtn.classList.toggle('disabled', currentPage === totalPages || totalPages === 0);
            
            // Logika menampilkan atau menyembunyikan pesan "Data Tidak Ditemukan"
            if (noDataRow) {
                noDataRow.style.display = 'none'; // Selalu sembunyikan yang dari PHP
            }
            if (noDataRowJS) {
                noDataRowJS.style.display = visibleRows.length === 0 ? '' : 'none';
            }

            paginationContainer.style.display = visibleRows.length > rowsPerPage || visibleRows.length === 0 ? 'block' : 'none';
        }

        function filterAndRender() {
            updateVisibleRows();
            currentPage = 1;
            showPage(currentPage);
            renderPagination();
        }

        paginationContainer.addEventListener('click', function(e) {
            e.preventDefault();
            const clickedItem = e.target.closest('.page-item');
            if (!clickedItem || clickedItem.classList.contains('disabled') || clickedItem.classList.contains('active')) return;
            
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage);
            if (clickedItem.id === 'first-page') {
                currentPage = 1;
            } else if (clickedItem.id === 'last-page') {
                currentPage = totalPages;
            } else if (clickedItem.id === 'prev-page') {
                currentPage = Math.max(1, currentPage - 1);
            } else if (clickedItem.id === 'next-page') {
                currentPage = Math.min(totalPages, currentPage + 1);
            } else {
                currentPage = parseInt(clickedItem.getAttribute('data-page'));
            }

            showPage(currentPage);
            renderPagination();
        });

        tableBody.addEventListener('click', function(e) {
            const btn = e.target.closest('a');
            if (!btn) return;
            
            const row = e.target.closest('tr');
            const itemId = row.getAttribute('data-id');

            if (btn.classList.contains('edit-btn')) {
                e.preventDefault();
                const namaBarang = btn.getAttribute('data-nama');
                const kodeBarang = btn.getAttribute('data-kode');
                const jumlahBarang = btn.getAttribute('data-jumlah');
                const kategoriId = btn.getAttribute('data-kategori-id');

                document.getElementById('edit_item_id').value = itemId;
                document.getElementById('edit_nama_barang').value = namaBarang;
                document.getElementById('edit_kode_barang').value = kodeBarang;
                document.getElementById('edit_jumlah_barang').value = jumlahBarang;

                document.getElementById('editBarangModal').querySelectorAll('.form-control').forEach(el => {
                    el.parentElement.classList.add('is-filled');
                });

                const kategoriSelect = document.getElementById('edit_nama_kategori');
                kategoriSelect.innerHTML = ''; 
                
                const uniqueCategories = @json($unique_categories);
                
                uniqueCategories.forEach(kategori => {
                    const option = document.createElement('option');
                    option.value = kategori.id;
                    option.textContent = kategori.nama_kategori;
                    if (kategori.id == kategoriId) {
                        option.selected = true;
                    }
                    kategoriSelect.appendChild(option);
                });
                kategoriSelect.parentElement.classList.add('is-filled');
            }

            if (btn.classList.contains('delete-btn')) {
                e.preventDefault();
                Swal.fire({
                    title: 'Anda yakin?',
                    text: "Data ini akan dihapus permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = `{{ route('data-barang.destroy', ['barang' => 'TEMP_ID']) }}`.replace('TEMP_ID', itemId);
                        form.style.display = 'none';
                        form.innerHTML = `
                            @csrf
                            @method('DELETE')
                        `;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            if (btn.classList.contains('lokasi-btn')) {
                const namaBarang = row.querySelector('.nama-barang-cell').textContent;
                const lokasiBarang = btn.getAttribute('data-lokasi-barang');
                const latitude = parseFloat(btn.getAttribute('data-latitude'));
                const longitude = parseFloat(btn.getAttribute('data-longitude'));
                
                document.getElementById('lokasi-nama-barang').textContent = namaBarang;
                document.getElementById('lokasi_barang_input').value = lokasiBarang;
                document.getElementById('lokasi_latitude').value = latitude.toFixed(6);
                document.getElementById('lokasi_longitude').value = longitude.toFixed(6);
                document.getElementById('lokasi_row_id').value = itemId;

                document.querySelectorAll('#lokasiForm .form-control').forEach(el => {
                    el.parentElement.classList.add('is-filled');
                });
                
                const lokasiModal = new bootstrap.Modal(lokasiModalElement);
                lokasiModal.show();
            }
        });

        document.getElementById('saveChangesBtn').addEventListener('click', function() {
            const form = document.getElementById('editBarangForm');
            const itemId = document.getElementById('edit_item_id').value;
            form.action = `{{ route('data-barang.update', ['barang' => 'TEMP_ID']) }}`.replace('TEMP_ID', itemId);
            form.submit();
        });

        lokasiModalElement.addEventListener('shown.bs.modal', () => {
            const itemId = document.getElementById('lokasi_row_id').value;
            const row = document.querySelector(`tr[data-id="${itemId}"]`);
            const namaBarang = row.querySelector('.nama-barang-cell').textContent;
            const lokasiBarang = row.querySelector('.lokasi-btn').getAttribute('data-lokasi-barang');
            const latitude = parseFloat(row.querySelector('.lokasi-btn').getAttribute('data-latitude'));
            const longitude = parseFloat(row.querySelector('.lokasi-btn').getAttribute('data-longitude'));
            
            if (mapLokasi) {
                mapLokasi.remove();
            }
            
            mapLokasi = L.map('map-lokasi').setView([latitude, longitude], 15);
            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(mapLokasi);
            
            if (mapMarker) {
                mapMarker.remove();
            }
            const popupContent = `<b>${lokasiBarang}</b><br>${namaBarang}`;
            mapMarker = L.marker([latitude, longitude]).addTo(mapLokasi).bindPopup(popupContent).openPopup();

            mapLokasi.on('click', function(e) {
                const newLatlng = e.latlng;
                if (mapMarker) {
                    mapMarker.setLatLng(newLatlng);
                } else {
                    mapMarker = L.marker(newLatlng).addTo(mapLokasi).bindPopup(popupContent).openPopup();
                }
                document.getElementById('lokasi_latitude').value = newLatlng.lat.toFixed(6);
                document.getElementById('lokasi_longitude').value = newLatlng.lng.toFixed(6);
                document.getElementById('lokasi_latitude').parentElement.classList.add('is-filled');
                document.getElementById('lokasi_longitude').parentElement.classList.add('is-filled');
            });
            
            setTimeout(() => {
                mapLokasi.invalidateSize();
            }, 300);
        });
        
        // Tambahkan event listener untuk tombol Simpan Lokasi
        document.getElementById('saveLokasiBtn').addEventListener('click', function() {
            const form = document.getElementById('lokasiForm');
            const itemId = document.getElementById('lokasi_row_id').value;
            form.action = `{{ route('data-barang.update', ['barang' => 'TEMP_ID']) }}`.replace('TEMP_ID', itemId);
            form.submit();
        });

        // Hapus `hidden.bs.modal` dan `cleanupModalBackdrops`
        // Agar modal-open class tidak di hapus sehingga scrolling di body di biarkan
        document.querySelectorAll('.modal').forEach(modal => {
             // modal.addEventListener('hidden.bs.modal', function() {
             //     cleanupModalBackdrops();
             // });
        });

        searchInput.addEventListener('keyup', filterAndRender);
        tanggalMulaiInput.addEventListener('change', filterAndRender);
        tanggalAkhirInput.addEventListener('change', filterAndRender);
        
        filterAndRender();
    });
</script>
@endsection