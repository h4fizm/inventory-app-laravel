@extends('main')
@section('title', 'Manage Kategori')
@section('content')

{{-- CSS untuk kustomisasi pagination dan tabel --}}
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

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif
@if($errors->any())
    <div class="alert alert-danger">
        <ul class="mb-0">
            @foreach ($errors->all() as $err)
                <li>{{ $err }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            {{-- Bagian judul, tombol tambah, dan pencarian/filter --}}
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h5 class="mb-0">Daftar Kategori</h5>
                <div class="d-flex align-items-center flex-wrap">
                    {{-- Filter Tanggal --}}
                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                        <label for="tanggal_mulai" class="form-label mb-0 me-2">Dari</label>
                        <input type="date" class="form-control" id="tanggal_mulai">
                    </div>
                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                        <label for="tanggal_akhir" class="form-label mb-0 me-2">Hingga</label>
                        <input type="date" class="form-control" id="tanggal_akhir">
                    </div>
                    {{-- Pencarian --}}
                    <div class="input-group w-auto me-3 mb-2 mb-md-0">
                        <span class="input-group-text"><i class="material-symbols-rounded opacity-10">search</i></span>
                        <input type="text" class="form-control" id="search-input" placeholder="Cari...">
                    </div>
                    <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#tambahKategoriModal">+ Tambah Kategori</button>
                </div>
            </div>
            
            <div class="table-responsive p-0 mt-3">
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">Nama Kategori</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Terakhir Update</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($data_kategori as $index => $item)
                        <tr class="data-row" data-id="{{ $item->id }}" data-tanggal-update="{{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}">
                            <td><p class="text-xs font-weight-bold mb-0 text-start">{{ $index + 1 }}</p></td>
                            <td class="nama_kategori_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $item->nama_kategori }}</p></td>
                            <td class="tanggal_update_td text-center">
                                <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning mb-0 edit-btn" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#editKategoriModal"
                                    data-id="{{ $item->id }}"
                                    data-nama="{{ $item->nama_kategori }}">
                                    Edit
                                </button>

                                <form action="{{ route('kategori.destroy', $item->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-0 btn-delete" data-kategori-nama="{{ $item->nama_kategori }}">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr id="no-data-row-php">
                            <td colspan="4" class="text-center text-secondary">Kategori tidak ditemukan.</td>
                        </tr>
                        @endforelse
                        <tr id="no-data-row-js" style="display: none;">
                            <td colspan="4" class="text-center text-secondary">Data Tidak Ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            {{-- Pagination HTML --}}
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination" id="kategori-pagination">
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
            <form action="{{ route('kategori.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="tambah_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="tambah_nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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
           <form id="editKategoriForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="edit_nama_kategori" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="edit_nama_kategori" name="nama_kategori" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('.table tbody');
        const paginationList = document.getElementById('kategori-pagination');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const searchInput = document.getElementById('search-input');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');
        
        const allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));
        const noDataRowPHP = document.getElementById('no-data-row-php');
        const noDataRowJS = document.getElementById('no-data-row-js');
        const rowsPerPage = 10;
        let currentPage = 1;
        let visibleRows = [];

        function updateVisibleRows() {
            const searchQuery = searchInput.value.toLowerCase();
            const startDate = tanggalMulaiInput.value;
            const endDate = tanggalAkhirInput.value;
            
            visibleRows = allRows.filter(row => {
                const rowText = row.textContent.toLowerCase();
                const rowDate = row.getAttribute('data-tanggal-update');
                const searchMatch = rowText.includes(searchQuery);
                let dateMatch = (!startDate || rowDate >= startDate) && (!endDate || rowDate <= endDate);
                return searchMatch && dateMatch;
            });
        }
        
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
            
            if (noDataRowPHP) {
                noDataRowPHP.style.display = 'none';
            }
            if (noDataRowJS) {
                noDataRowJS.style.display = visibleRows.length === 0 ? '' : 'none';
            }
            
            paginationList.style.display = visibleRows.length > 0 ? 'flex' : 'none';
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
        
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function () {
                let id = this.getAttribute('data-id');
                let nama = this.getAttribute('data-nama');
                document.getElementById('edit_nama_kategori').value = nama;
                document.getElementById('editKategoriForm').action = "{{ route('kategori.update', ':id') }}".replace(':id', id);
            });
        });

        // SweetAlert konfirmasi delete
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function(e) {
                let form = this.closest('form');
                let kategoriNama = this.dataset.kategoriNama;

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `Kategori "${kategoriNama}" akan dihapus permanen.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        // Event listener untuk filter tanggal dan pencarian
        searchInput.addEventListener('keyup', filterAndRender);
        tanggalMulaiInput.addEventListener('change', filterAndRender);
        tanggalAkhirInput.addEventListener('change', filterAndRender);
        
        filterAndRender();
    });
</script>

@endsection