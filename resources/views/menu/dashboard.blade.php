@extends('main')
@section('title', 'Laman Dashboard')
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
    <div class="ms-3">
        <h3 class="mb-0 h4 font-weight-bolder">Dashboard</h3>
        <p class="mb-4">Informasi ringkas mengenai sistem Anda.</p>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Total User</p>
                        <h4 class="mb-0">{{ $totalUsers }}</h4>
                    </div>
                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                        <i class="material-symbols-rounded opacity-10">person</i>
                    </div>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                    Total pengguna yang terdaftar
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Jumlah Kategori</p>
                        <h4 class="mb-0">{{ $totalKategori }}</h4>
                    </div>
                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                        <i class="material-symbols-rounded opacity-10">category</i>
                    </div>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                    Total kategori produk
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        <div class="card">
            <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Jumlah Barang</p>
                        <h4 class="mb-0">{{ $totalBarang }}</h4>
                    </div>
                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                        <i class="material-symbols-rounded opacity-10">inventory_2</i>
                    </div>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                    Total semua produk
                </p>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-sm-6">
        <div class="card">
            <div class="card-header p-2 ps-3">
                <div class="d-flex justify-content-between">
                    <div>
                        <p class="text-sm mb-0 text-capitalize">Barang Kritis</p>
                        <h4 class="mb-0">{{ $jumlahBarangKritis }}</h4>
                    </div>
                    <div class="icon icon-md icon-shape bg-gradient-dark shadow-dark shadow text-center border-radius-lg">
                        <i class="material-symbols-rounded opacity-10">error</i>
                    </div>
                </div>
            </div>
            <hr class="dark horizontal my-0">
            <div class="card-footer p-2 ps-3">
                <p class="mb-0 text-sm">
                    Stok kurang dari 5
                </p>
            </div>
        </div>
    </div>
</div>


<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Produk dengan Stok Kritis</h5>
                <div class="d-flex align-items-center flex-wrap">
                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                        <label for="tanggal_mulai_kritis" class="form-label mb-0 me-2">Dari</label>
                        <input type="date" class="form-control" id="tanggal_mulai_kritis">
                    </div>
                    <div class="d-flex align-items-center me-3 mb-2 mb-md-0">
                        <label for="tanggal_akhir_kritis" class="form-label mb-0 me-2">Hingga</label>
                        <input type="date" class="form-control" id="tanggal_akhir_kritis">
                    </div>
                    <div class="input-group w-auto">
                        <span class="input-group-text"><i class="material-symbols-rounded opacity-10">search</i></span>
                        <input type="text" class="form-control" id="search-input-kritis" placeholder="Cari...">
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
                        @forelse($barangKritis as $index => $item)
                        <tr class="data-row" data-tanggal-update="{{ \Carbon\Carbon::parse($item->updated_at)->format('Y-m-d') }}">
                            <td><p class="text-xs font-weight-bold mb-0 text-start"></p></td>
                            <td><p class="text-xs font-weight-bold mb-0 text-start">{{ $item->nama_barang }}</p></td>
                            <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->kode_barang }}</p></td>
                            <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->kategori->nama_kategori ?? 'N/A' }}</p></td>
                            <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->jumlah_barang }}</p></td>
                            <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item->lokasi_barang }}</p></td>
                            <td class="text-center">
                                <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($item->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                            </td>
                            <td class="text-center">
                                <a href="{{ route('preview-barang', ['barang' => $item->id]) }}" class="btn btn-sm btn-info mb-0">Preview</a>
                            </td>
                        </tr>
                        @empty
                        <tr id="no-data-row-php">
                            <td colspan="8" class="text-center text-secondary">Tidak ada produk dengan stok kritis.</td>
                        </tr>
                        @endforelse
                        <tr id="no-data-row-js" style="display: none;">
                            <td colspan="8" class="text-center text-secondary">Data Tidak Ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination" id="barang-kritis-pagination">
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('.table tbody');
        const paginationList = document.getElementById('barang-kritis-pagination');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const searchInput = document.getElementById('search-input-kritis');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai_kritis'); // Perbarui ID
        const tanggalAkhirInput = document.getElementById('tanggal_akhir_kritis'); // Perbarui ID
        
        const allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));
        const noDataRowPHP = document.getElementById('no-data-row-php');
        const noDataRowJS = document.getElementById('no-data-row-js');
        const rowsPerPage = 5;
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
                let dateMatch = true;
        
                if (startDate && rowDate < startDate) {
                    dateMatch = false;
                }
                if (endDate && rowDate > endDate) {
                    dateMatch = false;
                }
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
            
            if (visibleRows.length > 0) {
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = `page-item${i === currentPage ? ' active' : ''}`;
                    li.setAttribute('data-page', i);
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    pageNumbersContainer.appendChild(li);
                }
            }
            
            const firstPageBtn = document.getElementById('first-page');
            const prevPageBtn = document.getElementById('prev-page');
            const nextPageBtn = document.getElementById('next-page');
            const lastPageBtn = document.getElementById('last-page');
            
            const hasMultiplePages = totalPages > 1;

            firstPageBtn.classList.toggle('disabled', !hasMultiplePages || currentPage === 1);
            prevPageBtn.classList.toggle('disabled', !hasMultiplePages || currentPage === 1);
            nextPageBtn.classList.toggle('disabled', !hasMultiplePages || currentPage === totalPages);
            lastPageBtn.classList.toggle('disabled', !hasMultiplePages || currentPage === totalPages);
            
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
        
        searchInput.addEventListener('keyup', filterAndRender);
        tanggalMulaiInput.addEventListener('change', filterAndRender);
        tanggalAkhirInput.addEventListener('change', filterAndRender);

        filterAndRender();
    });
</script>
@endsection