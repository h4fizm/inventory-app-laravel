@extends('main')
@section('title', 'Manage Kategori')
@section('content')

{{-- CSS untuk kustomisasi pagination --}}
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
</style>

<div class="row">
    <div class="col-12">
        <h3 class="mb-0 h4 font-weight-bolder">Manage Kategori</h3>
        <p class="mb-4">Daftar semua kategori barang yang terdaftar dalam sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            {{-- Bagian judul, filter, search, dan tombol tambah --}}
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="mb-0">Daftar Kategori</h5>
                <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">+ Tambah Kategori</button>
            </div>
            <div class="d-flex justify-content-end align-items-center flex-wrap mb-3">
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
            
            <div class="table-responsive p-0">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Kategori</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Terakhir Update</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $rowsPerPage = 5;
                        
                        $hari_indonesia = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                        $bulan_indonesia = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
                        @endphp
                        @forelse($data_kategori as $index => $item)
                        @php
                            $tanggal_obj = date_create($item->updated_at->toDateString());
                            $tanggal_terformat = str_replace(array_keys($hari_indonesia), array_values($hari_indonesia), $tanggal_obj->format('l'));
                            $tanggal_terformat .= ', ' . $tanggal_obj->format('d');
                            $tanggal_terformat .= ' ' . str_replace(array_keys($bulan_indonesia), array_values($bulan_indonesia), $tanggal_obj->format('F'));
                            $tanggal_terformat .= ' ' . $tanggal_obj->format('Y');
                        @endphp
                        <tr class="data-row" data-page="{{ floor($index / $rowsPerPage) + 1 }}" data-row-id="{{ $index }}" data-original-date="{{ $item->updated_at->toDateString() }}" style="display: {{ (floor($index / $rowsPerPage) + 1) == 1 ? '' : 'none' }}">
                            <td><p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p></td>
                            <td class="nama_kategori_td"><p class="text-xs font-weight-bold mb-0">{{ $item->nama_kategori }}</p></td>
                            <td class="text-center tanggal-update" data-original-date="{{ $item->updated_at->toDateString() }}">
                                <p class="text-xs font-weight-bold mb-0">{{ $tanggal_terformat }}</p>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-warning mb-0 edit-btn" data-bs-toggle="modal" data-bs-target="#editKategoriModal">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger mb-0 delete-btn">Delete</a>
                            </td>
                        </tr>
                        @empty
                        <tr id="no-data-row" style="display: none;">
                            <td colspan="4" class="text-center text-secondary">Kategori tidak ditemukan.</td>
                        </tr>
                        @endforelse
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

{{-- Modal Tambah Kategori --}}
<div class="modal fade" id="tambahKategoriModal" tabindex="-1" aria-labelledby="tambahKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahKategoriModalLabel">Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tambahKategoriForm">
                    <div class="input-group input-group-outline mb-3">
                        <label for="tambah_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="tambah_nama_kategori" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveTambahKategoriBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit Kategori --}}
<div class="modal fade" id="editKategoriModal" tabindex="-1" aria-labelledby="editKategoriModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editKategoriModalLabel">Edit Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editKategoriForm">
                    <input type="hidden" id="edit_row_id">
                    <div class="input-group input-group-outline mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('.table tbody');
        const paginationList = document.querySelector('.pagination');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const firstPageBtn = document.getElementById('first-page');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const lastPageBtn = document.getElementById('last-page');
        const searchInput = document.getElementById('search-input');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');
        
        let rows = tableBody.querySelectorAll('tr.data-row');
        const noDataRow = document.getElementById('no-data-row');
        const rowsPerPage = 5;
        let currentPage = 1;
        let visibleRows = [];

        function updateVisibleRows() {
            const searchQuery = searchInput.value.toLowerCase();
            const startDate = tanggalMulaiInput.value;
            const endDate = tanggalAkhirInput.value;

            visibleRows = Array.from(rows).filter(row => {
                const rowText = row.textContent.toLowerCase();
                const rowDate = row.querySelector('.tanggal-update').getAttribute('data-original-date');
                
                const searchMatch = rowText.includes(searchQuery);
                let dateMatch = true;
                
                if (startDate && rowDate < startDate) {
                    dateMatch = false;
                }
                if (endDate && rowDate > endDate) {
                    dateMatch = false;
                }
                
                return searchMatch && dateMatch;
            });
            
            if (visibleRows.length === 0) {
                noDataRow.style.display = '';
                paginationList.style.display = 'none';
            } else {
                noDataRow.style.display = 'none';
                paginationList.style.display = 'flex';
            }
        }
        
        function showPage(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach(row => row.style.display = 'none');
            for (let i = start; i < end && i < visibleRows.length; i++) {
                visibleRows[i].style.display = '';
            }
        }
        
        function renderPageButtons() {
            pageNumbersContainer.innerHTML = '';
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage);
            for (let i = 1; i <= totalPages; i++) {
                const li = document.createElement('li');
                li.className = 'page-item';
                li.setAttribute('data-page', i);
                li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                pageNumbersContainer.appendChild(li);
            }
        }

        function updatePaginationButtons() {
            const paginationListItems = document.querySelectorAll('.pagination .page-item');
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage);
            
            paginationListItems.forEach(item => {
                item.classList.remove('active', 'disabled');
            });
            const activePageLink = document.querySelector(`.pagination .page-item[data-page="${currentPage}"]`);
            if (activePageLink) {
                activePageLink.classList.add('active');
            }

            if (currentPage === 1 || totalPages === 0) {
                firstPageBtn.classList.add('disabled');
                prevPageBtn.classList.add('disabled');
            }
            if (currentPage === totalPages || totalPages === 0) {
                lastPageBtn.classList.add('disabled');
                nextPageBtn.classList.add('disabled');
            }
        }

        function filterAndRender() {
            currentPage = 1;
            updateVisibleRows();
            showPage(currentPage);
            renderPageButtons(); 
            updatePaginationButtons();
        }

        // --- Event Listeners ---
        searchInput.addEventListener('keyup', filterAndRender);
        tanggalMulaiInput.addEventListener('change', filterAndRender);
        tanggalAkhirInput.addEventListener('change', filterAndRender);

        paginationList.addEventListener('click', function(e) {
            e.preventDefault();
            const clickedItem = e.target.closest('.page-item');
            if (!clickedItem || clickedItem.classList.contains('disabled')) return;
            
            const totalPages = Math.ceil(visibleRows.length / rowsPerPage);
            const page = parseInt(clickedItem.getAttribute('data-page'));
            if (!isNaN(page)) {
                currentPage = page;
            } else if (clickedItem.id === 'first-page') {
                currentPage = 1;
            } else if (clickedItem.id === 'last-page') {
                currentPage = totalPages;
            } else if (clickedItem.id === 'prev-page') {
                currentPage = Math.max(1, currentPage - 1);
            } else if (clickedItem.id === 'next-page') {
                currentPage = Math.min(totalPages, currentPage + 1);
            }

            showPage(currentPage);
            updatePaginationButtons();
        });

        // Event listener untuk tombol Edit
        tableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('edit-btn')) {
                const row = e.target.closest('tr');
                const rowId = row.getAttribute('data-row-id');
                const namaKategori = row.querySelector('.nama_kategori_td p').textContent;
                
                document.getElementById('edit_row_id').value = rowId;
                document.getElementById('edit_nama_kategori').value = namaKategori;

                // Tambahkan class is-filled untuk form input-group-outline yang sudah terisi
                document.getElementById('edit_nama_kategori').parentElement.classList.add('is-filled');
            }
        });

        // Event listener untuk tombol Simpan Perubahan di modal Edit
        document.getElementById('saveChangesBtn').addEventListener('click', function() {
            const rowId = document.getElementById('edit_row_id').value;
            const namaKategoriBaru = document.getElementById('edit_nama_kategori').value;

            if (namaKategoriBaru.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nama kategori tidak boleh kosong!',
                });
                return;
            }

            const rowToUpdate = document.querySelector(`tr[data-row-id="${rowId}"]`);
            if (rowToUpdate) {
                rowToUpdate.querySelector('.nama_kategori_td p').textContent = namaKategoriBaru;
            }
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('editKategoriModal'));
            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data kategori berhasil diperbarui!',
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Event listener untuk tombol Tambah Kategori di modal
        document.getElementById('saveTambahKategoriBtn').addEventListener('click', function() {
            const namaKategoriBaru = document.getElementById('tambah_nama_kategori').value;

            if (namaKategoriBaru.trim() === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nama kategori tidak boleh kosong!',
                });
                return;
            }

            const newIndex = rows.length;
            const newRow = document.createElement('tr');
            newRow.className = 'data-row';
            newRow.setAttribute('data-page', Math.ceil((newIndex + 1) / rowsPerPage));
            newRow.setAttribute('data-row-id', newIndex);

            const today = new Date();
            const tanggalSekarang = today.toISOString().slice(0, 10);
            const formattedDate = new Intl.DateTimeFormat('id-ID', {
                weekday: 'long',
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            }).format(today);

            newRow.innerHTML = `
                <td><p class="text-xs font-weight-bold mb-0">${newIndex + 1}</p></td>
                <td class="nama_kategori_td"><p class="text-xs font-weight-bold mb-0">${namaKategoriBaru}</p></td>
                <td class="text-center tanggal-update" data-original-date="${tanggalSekarang}">
                    <p class="text-xs font-weight-bold mb-0">${formattedDate}</p>
                </td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-warning mb-0 edit-btn" data-bs-toggle="modal" data-bs-target="#editKategoriModal">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger mb-0 delete-btn">Delete</a>
                </td>
            `;

            tableBody.appendChild(newRow);
            rows = tableBody.querySelectorAll('tr.data-row');
            filterAndRender();

            const modal = bootstrap.Modal.getInstance(document.getElementById('tambahKategoriModal'));
            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Kategori baru berhasil ditambahkan!',
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Event listener untuk tombol Delete
        tableBody.addEventListener('click', function(e) {
            if (e.target.classList.contains('delete-btn')) {
                e.preventDefault();
                const row = e.target.closest('tr');
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
                        rows = tableBody.querySelectorAll('tr.data-row');
                        rows.forEach((r, i) => {
                            r.querySelector('td p').textContent = i + 1;
                            r.setAttribute('data-row-id', i);
                        });
                        filterAndRender();
                        Swal.fire(
                            'Dihapus!',
                            'Data berhasil dihapus.',
                            'success'
                        );
                    }
                });
            }
        });

        // Memperbaiki masalah backdrop modal yang tidak hilang setelah ditutup
        const editModalElement = document.getElementById('editKategoriModal');
        editModalElement.addEventListener('hidden.bs.modal', function (event) {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });

        const tambahModalElement = document.getElementById('tambahKategoriModal');
        tambahModalElement.addEventListener('hidden.bs.modal', function (event) {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.getElementById('tambahKategoriForm').reset();
        });
        
        filterAndRender();
    });
</script>
@endsection