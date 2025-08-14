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
</style>

<div class="row">
    <div class="col-12">
        <h3 class="mb-0 h4 font-weight-bolder">Manage Barang</h3>
        <p class="mb-4">Daftar semua produk yang terdaftar dalam sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
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
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Barang</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Terakhir Update</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $data_barang = [
                            ['nama_barang' => 'Keyboard Mekanik RGB', 'kode_barang' => 'KB-001', 'jumlah_barang' => 12, 'nama_kategori' => 'Aksesoris PC', 'tanggal_update' => '2025-08-10', 'latitude' => -7.2608, 'longitude' => 112.7482],
                            ['nama_barang' => 'Mouse Gaming Wireless', 'kode_barang' => 'MS-005', 'jumlah_barang' => 8, 'nama_kategori' => 'Aksesoris PC', 'tanggal_update' => '2025-08-11', 'latitude' => -7.2533, 'longitude' => 112.7567],
                            ['nama_barang' => 'SSD M.2 512GB', 'kode_barang' => 'SS-010', 'jumlah_barang' => 15, 'nama_kategori' => 'Komponen PC', 'tanggal_update' => '2025-08-12', 'latitude' => -7.2450, 'longitude' => 112.7401],
                            ['nama_barang' => 'Monitor 24 Inch 144Hz', 'kode_barang' => 'MN-007', 'jumlah_barang' => 6, 'nama_kategori' => 'Hardware', 'tanggal_update' => '2025-08-13', 'latitude' => -7.2588, 'longitude' => 112.7605],
                            ['nama_barang' => 'Headset Gaming', 'kode_barang' => 'HS-003', 'jumlah_barang' => 20, 'nama_kategori' => 'Aksesoris PC', 'tanggal_update' => '2025-08-10', 'latitude' => -7.2655, 'longitude' => 112.7533],
                            ['nama_barang' => 'Webcam HD 1080p', 'kode_barang' => 'WC-001', 'jumlah_barang' => 11, 'nama_kategori' => 'Periferal', 'tanggal_update' => '2025-08-11', 'latitude' => -7.2512, 'longitude' => 112.7420],
                            ['nama_barang' => 'Speaker Bluetooth', 'kode_barang' => 'SP-002', 'jumlah_barang' => 18, 'nama_kategori' => 'Audio', 'tanggal_update' => '2025-08-12', 'latitude' => -7.2489, 'longitude' => 112.7651],
                            ['nama_barang' => 'CPU Intel i9-12900K', 'kode_barang' => 'CPU-020', 'jumlah_barang' => 7, 'nama_kategori' => 'Komponen PC', 'tanggal_update' => '2025-08-13', 'latitude' => -7.2615, 'longitude' => 112.7490],
                            ['nama_barang' => 'VGA NVIDIA RTX 3080', 'kode_barang' => 'VGA-015', 'jumlah_barang' => 4, 'nama_kategori' => 'Komponen PC', 'tanggal_update' => '2025-08-10', 'latitude' => -7.2503, 'longitude' => 112.7548],
                            ['nama_barang' => 'RAM Corsair Vengeance', 'kode_barang' => 'RAM-008', 'jumlah_barang' => 9, 'nama_kategori' => 'Komponen PC', 'tanggal_update' => '2025-08-11', 'latitude' => -7.2631, 'longitude' => 112.7410],
                            ['nama_barang' => 'Motherboard ASUS ROG', 'kode_barang' => 'MB-012', 'jumlah_barang' => 13, 'nama_kategori' => 'Komponen PC', 'tanggal_update' => '2025-08-12', 'latitude' => -7.2555, 'longitude' => 112.7588],
                            ['nama_barang' => 'Power Supply 750W', 'kode_barang' => 'PS-004', 'jumlah_barang' => 17, 'nama_kategori' => 'Komponen PC', 'tanggal_update' => '2025-08-13', 'latitude' => -7.2499, 'longitude' => 112.7511],
                            ['nama_barang' => 'Casing PC Corsair', 'kode_barang' => 'CS-009', 'jumlah_barang' => 14, 'nama_kategori' => 'Hardware', 'tanggal_update' => '2025-08-10', 'latitude' => -7.2622, 'longitude' => 112.7634],
                            ['nama_barang' => 'Printer Epson L3110', 'kode_barang' => 'PR-006', 'jumlah_barang' => 16, 'nama_kategori' => 'Periferal', 'tanggal_update' => '2025-08-11', 'latitude' => -7.2580, 'longitude' => 112.7570],
                            ['nama_barang' => 'Harddisk Eksternal 1TB', 'kode_barang' => 'HD-003', 'jumlah_barang' => 19, 'nama_kategori' => 'Penyimpanan', 'tanggal_update' => '2025-08-12', 'latitude' => -7.2530, 'longitude' => 112.7455],
                            ['nama_barang' => 'Webcam 4K', 'kode_barang' => 'WC-002', 'jumlah_barang' => 10, 'nama_kategori' => 'Periferal', 'tanggal_update' => '2025-08-13', 'latitude' => -7.2644, 'longitude' => 112.7505],
                            ['nama_barang' => 'Mousepad Gaming XL', 'kode_barang' => 'MP-001', 'jumlah_barang' => 22, 'nama_kategori' => 'Aksesoris PC', 'tanggal_update' => '2025-08-10', 'latitude' => -7.2471, 'longitude' => 112.7618],
                            ['nama_barang' => 'Kabel HDMI 2 Meter', 'kode_barang' => 'CB-004', 'jumlah_barang' => 25, 'nama_kategori' => 'Kabel & Adaptor', 'tanggal_update' => '2025-08-11', 'latitude' => -7.2598, 'longitude' => 112.7432],
                            ['nama_barang' => 'Webcam 1080p', 'kode_barang' => 'WC-001', 'jumlah_barang' => 12, 'nama_kategori' => 'Periferal', 'tanggal_update' => '2025-08-12', 'latitude' => -7.2562, 'longitude' => 112.7523],
                            ['nama_barang' => 'Harddisk Eksternal 2TB', 'kode_barang' => 'HD-004', 'jumlah_barang' => 15, 'nama_kategori' => 'Penyimpanan', 'tanggal_update' => '2025-08-13', 'latitude' => -7.2440, 'longitude' => 112.7599],
                        ];
                        $rowsPerPage = 10;
                        
                        $hari_indonesia = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                        $bulan_indonesia = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
                        
                        // Ambil daftar kategori unik dari data_barang untuk dropdown
                        $unique_categories = array_unique(array_column($data_barang, 'nama_kategori'));
                        @endphp
                        @foreach($data_barang as $index => $item)
                        @php
                            $tanggal_obj = date_create($item['tanggal_update']);
                            $tanggal_terformat = str_replace(array_keys($hari_indonesia), array_values($hari_indonesia), $tanggal_obj->format('l'));
                            $tanggal_terformat .= ', ' . $tanggal_obj->format('d');
                            $tanggal_terformat .= ' ' . str_replace(array_keys($bulan_indonesia), array_values($bulan_indonesia), $tanggal_obj->format('F'));
                            $tanggal_terformat .= ' ' . $tanggal_obj->format('Y');
                        @endphp
                        <tr class="data-row" data-page="{{ floor($index / $rowsPerPage) + 1 }}" data-row-id="{{ $index }}" style="display: {{ (floor($index / $rowsPerPage) + 1) == 1 ? '' : 'none' }}">
                            <td><p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p></td>
                            <td class="nama_barang_td"><p class="text-xs font-weight-bold mb-0">{{ $item['nama_barang'] }}</p></td>
                            <td class="text-center kode_barang_td"><p class="text-xs font-weight-bold mb-0">{{ $item['kode_barang'] }}</p></td>
                            <td class="text-center jumlah_barang_td"><p class="text-xs font-weight-bold mb-0">{{ $item['jumlah_barang'] }}</p></td>
                            <td class="text-center nama_kategori_td"><p class="text-xs font-weight-bold mb-0">{{ $item['nama_kategori'] }}</p></td>
                            <td class="text-center tanggal-update" data-original-date="{{ $item['tanggal_update'] }}">
                                <p class="text-xs font-weight-bold mb-0">{{ $tanggal_terformat }}</p>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-dark mb-0 lokasi-btn" data-bs-toggle="modal" data-bs-target="#lokasiModal" data-row-id="{{ $index }}" data-latitude="{{ $item['latitude'] }}" data-longitude="{{ $item['longitude'] }}">Lokasi</a>
                                <a href="#" class="btn btn-sm btn-warning mb-0 edit-btn" data-bs-toggle="modal" data-bs-target="#editBarangModal">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger mb-0 delete-btn">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr id="no-data-row" style="display: none;">
                            <td colspan="7" class="text-center text-secondary">Barang tidak ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination">
                        <li class="page-item" id="first-page">
                            <a class="page-link" href="#">&laquo;</a>
                        </li>
                        <li class="page-item" id="prev-page">
                            <a class="page-link" href="#" tabindex="-1" aria-disabled="true">&lt;</a>
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
                <form id="editBarangForm">
                    <input type="hidden" id="edit_row_id">
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_nama_barang" class="form-label">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_nama_barang">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_kode_barang" class="form-label">Kode Barang</label>
                        <input type="text" class="form-control" id="edit_kode_barang">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_jumlah_barang" class="form-label">Jumlah Barang</label>
                        <input type="number" class="form-control" id="edit_jumlah_barang">
                    </div>
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <select class="form-select" id="edit_nama_kategori">
                            @foreach($unique_categories as $category)
                                <option value="{{ $category }}">{{ $category }}</option>
                            @endforeach
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
                <form id="lokasiForm">
                    <input type="hidden" id="lokasi_row_id">
                    <p class="text-sm text-secondary">Klik pada peta untuk menentukan lokasi baru.</p>
                    <div id="map-lokasi" class="mb-3"></div>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline my-3">
                                <label for="lokasi_latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="lokasi_latitude" readonly>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="input-group input-group-outline my-3">
                                <label for="lokasi_longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="lokasi_longitude" readonly>
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
        const paginationList = document.querySelector('.pagination');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const searchInput = document.getElementById('search-input');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');
        
        const allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));
        const noDataRow = document.getElementById('no-data-row');
        const rowsPerPage = 10;
        let currentPage = 1;
        let visibleRows = [];
        let mapLokasi;
        let mapMarker;
        const lokasiModalElement = document.getElementById('lokasiModal');
        const editBarangModalElement = document.getElementById('editBarangModal');

        // Fungsi untuk membersihkan backdrop modal
        function cleanupModalBackdrops() {
            const backdrops = document.querySelectorAll('.modal-backdrop');
            backdrops.forEach(backdrop => backdrop.remove());
            document.body.classList.remove('modal-open');
            document.body.style.overflow = '';
            document.body.style.paddingRight = '';
        }

        // Fungsi untuk menutup modal dan membersihkan backdrop
        function closeModalWithCleanup(modalElement) {
            const modal = bootstrap.Modal.getInstance(modalElement);
            modal.hide();
            
            // Cleanup setelah modal benar-benar tertutup
            modalElement.addEventListener('hidden.bs.modal', function handler() {
                cleanupModalBackdrops();
                modalElement.removeEventListener('hidden.bs.modal', handler);
            }, { once: true });
        }

        function updateVisibleRows() {
            const searchQuery = searchInput.value.toLowerCase();
            const startDate = tanggalMulaiInput.value;
            const endDate = tanggalAkhirInput.value;

            visibleRows = allRows.filter(row => {
                const rowText = row.textContent.toLowerCase();
                const rowDate = row.querySelector('.tanggal-update').getAttribute('data-original-date');
                const searchMatch = rowText.includes(searchQuery);
                let dateMatch = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
                return searchMatch && dateMatch;
            });
        }
        
        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            allRows.forEach(row => row.style.display = 'none');
            for (let i = start; i < end && i < visibleRows.length; i++) {
                visibleRows[i].style.display = '';
            }
        }
        
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

            noDataRow.style.display = visibleRows.length === 0 ? '' : 'none';
            paginationList.style.display = visibleRows.length === 0 ? 'none' : 'flex';
        }

        function filterAndRender() {
            updateVisibleRows();
            currentPage = 1;
            showPage(currentPage);
            renderPagination();
        }

        paginationList.addEventListener('click', function(e) {
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
            const rowId = row.getAttribute('data-row-id');

            if (btn.classList.contains('edit-btn')) {
                const namaBarang = row.querySelector('.nama_barang_td p').textContent;
                const kodeBarang = row.querySelector('.kode_barang_td p').textContent;
                const jumlahBarang = row.querySelector('.jumlah_barang_td p').textContent;
                const namaKategori = row.querySelector('.nama_kategori_td p').textContent;
                
                document.getElementById('edit_row_id').value = rowId;
                document.getElementById('edit_nama_barang').value = namaBarang;
                document.getElementById('edit_kode_barang').value = kodeBarang;
                document.getElementById('edit_jumlah_barang').value = jumlahBarang;
                document.getElementById('edit_nama_kategori').value = namaKategori;

                document.querySelectorAll('#editBarangForm .form-control, #editBarangForm .form-select').forEach(el => {
                    el.parentElement.classList.add('is-filled');
                });

                const editBarangModal = new bootstrap.Modal(editBarangModalElement);
                editBarangModal.show();
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
                        row.remove();
                        const indexToRemove = allRows.findIndex(r => r === row);
                        if (indexToRemove > -1) {
                            allRows.splice(indexToRemove, 1);
                        }
                        filterAndRender();
                        Swal.fire(
                            'Dihapus!',
                            'Data berhasil dihapus.',
                            'success'
                        );
                    }
                });
            }

            if (btn.classList.contains('lokasi-btn')) {
                const namaBarang = row.querySelector('.nama_barang_td p').textContent;
                const latitude = parseFloat(btn.getAttribute('data-latitude'));
                const longitude = parseFloat(btn.getAttribute('data-longitude'));
                
                document.getElementById('lokasi-nama-barang').textContent = namaBarang;
                document.getElementById('lokasi_latitude').value = latitude.toFixed(6);
                document.getElementById('lokasi_longitude').value = longitude.toFixed(6);
                document.getElementById('lokasi_row_id').value = rowId;

                document.querySelectorAll('#lokasiForm .form-control').forEach(el => {
                    el.parentElement.classList.add('is-filled');
                });
                
                const lokasiModal = new bootstrap.Modal(lokasiModalElement);
                lokasiModal.show();
            }
        });

        document.getElementById('saveChangesBtn').addEventListener('click', function() {
            const rowId = document.getElementById('edit_row_id').value;
            const namaBarangBaru = document.getElementById('edit_nama_barang').value;
            const kodeBarangBaru = document.getElementById('edit_kode_barang').value;
            const jumlahBarangBaru = document.getElementById('edit_jumlah_barang').value;
            const namaKategoriBaru = document.getElementById('edit_nama_kategori').value;

            if (namaBarangBaru.trim() === '' || kodeBarangBaru.trim() === '' || jumlahBarangBaru.trim() === '') {
                Swal.fire({ icon: 'error', title: 'Gagal', text: 'Semua kolom wajib diisi!' });
                return;
            }

            const rowToUpdate = document.querySelector(`tr[data-row-id="${rowId}"]`);
            if (rowToUpdate) {
                rowToUpdate.querySelector('.nama_barang_td p').textContent = namaBarangBaru;
                rowToUpdate.querySelector('.kode_barang_td p').textContent = kodeBarangBaru;
                rowToUpdate.querySelector('.jumlah_barang_td p').textContent = jumlahBarangBaru;
                rowToUpdate.querySelector('.nama_kategori_td p').textContent = namaKategoriBaru;
            }
            
            closeModalWithCleanup(editBarangModalElement);
            
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data barang berhasil diperbarui!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 100);
        });

        document.getElementById('saveLokasiBtn').addEventListener('click', function() {
            const rowId = document.getElementById('lokasi_row_id').value;
            const newLatitude = document.getElementById('lokasi_latitude').value;
            const newLongitude = document.getElementById('lokasi_longitude').value;
            
            const rowToUpdate = document.querySelector(`tr[data-row-id="${rowId}"]`);
            if (rowToUpdate) {
                const lokasiBtn = rowToUpdate.querySelector('.lokasi-btn');
                lokasiBtn.setAttribute('data-latitude', newLatitude);
                lokasiBtn.setAttribute('data-longitude', newLongitude);
            }
            
            closeModalWithCleanup(lokasiModalElement);
            
            setTimeout(() => {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Lokasi barang berhasil diperbarui!',
                    showConfirmButton: false,
                    timer: 1500
                });
            }, 100);
        });

        lokasiModalElement.addEventListener('shown.bs.modal', () => {
            const rowId = document.getElementById('lokasi_row_id').value;
            const row = document.querySelector(`tr[data-row-id="${rowId}"]`);
            const namaBarang = row.querySelector('.nama_barang_td p').textContent;
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
            mapMarker = L.marker([latitude, longitude]).addTo(mapLokasi).bindPopup(namaBarang).openPopup();

            mapLokasi.on('click', function(e) {
                const newLatlng = e.latlng;
                if (mapMarker) {
                    mapMarker.setLatLng(newLatlng);
                } else {
                    mapMarker = L.marker(newLatlng).addTo(mapLokasi).bindPopup(namaBarang).openPopup();
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

        // Setup cleanup untuk semua modal
        document.querySelectorAll('.modal').forEach(modal => {
            modal.addEventListener('hidden.bs.modal', function() {
                cleanupModalBackdrops();
            });
        });

        searchInput.addEventListener('keyup', filterAndRender);
        tanggalMulaiInput.addEventListener('change', filterAndRender);
        tanggalAkhirInput.addEventListener('change', filterAndRender);
        
        filterAndRender();
    });
</script>
@endsection