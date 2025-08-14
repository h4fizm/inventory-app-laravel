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
        background-color: #5a6268; /* Warna secondary yang lebih gelap untuk hover/active */
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
                        <h4 class="mb-0">15</h4>
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
                        <h4 class="mb-0">8</h4>
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
                        <h4 class="mb-0">120</h4>
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
                        <h4 class="mb-0">20</h4>
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
                <div class="input-group w-25">
                    <span class="input-group-text"><i class="material-symbols-rounded opacity-10">search</i></span>
                    <input type="text" class="form-control" placeholder="Cari...">
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
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $data_kritis = [
                            ['nama_barang' => 'Keyboard Mekanik RGB', 'kode_barang' => 'KB-001', 'jumlah_barang' => 3],
                            ['nama_barang' => 'Mouse Gaming Wireless', 'kode_barang' => 'MS-005', 'jumlah_barang' => 1],
                            ['nama_barang' => 'SSD M.2 512GB', 'kode_barang' => 'SS-010', 'jumlah_barang' => 4],
                            ['nama_barang' => 'Monitor 24 Inch 144Hz', 'kode_barang' => 'MN-007', 'jumlah_barang' => 2],
                            ['nama_barang' => 'Headset Gaming', 'kode_barang' => 'HS-003', 'jumlah_barang' => 5],
                            ['nama_barang' => 'Webcam HD 1080p', 'kode_barang' => 'WC-001', 'jumlah_barang' => 1],
                            ['nama_barang' => 'Speaker Bluetooth', 'kode_barang' => 'SP-002', 'jumlah_barang' => 3],
                            ['nama_barang' => 'CPU Intel i9-12900K', 'kode_barang' => 'CPU-020', 'jumlah_barang' => 4],
                            ['nama_barang' => 'VGA NVIDIA RTX 3080', 'kode_barang' => 'VGA-015', 'jumlah_barang' => 2],
                            ['nama_barang' => 'RAM Corsair Vengeance', 'kode_barang' => 'RAM-008', 'jumlah_barang' => 3],
                            ['nama_barang' => 'Motherboard ASUS ROG', 'kode_barang' => 'MB-012', 'jumlah_barang' => 1],
                            ['nama_barang' => 'Power Supply 750W', 'kode_barang' => 'PS-004', 'jumlah_barang' => 5],
                            ['nama_barang' => 'Casing PC Corsair', 'kode_barang' => 'CS-009', 'jumlah_barang' => 2],
                            ['nama_barang' => 'Printer Epson L3110', 'kode_barang' => 'PR-006', 'jumlah_barang' => 4],
                            ['nama_barang' => 'Harddisk Eksternal 1TB', 'kode_barang' => 'HD-003', 'jumlah_barang' => 2],
                            ['nama_barang' => 'Webcam 4K', 'kode_barang' => 'WC-002', 'jumlah_barang' => 1],
                            ['nama_barang' => 'Mousepad Gaming XL', 'kode_barang' => 'MP-001', 'jumlah_barang' => 5],
                            ['nama_barang' => 'Kabel HDMI 2 Meter', 'kode_barang' => 'CB-004', 'jumlah_barang' => 1],
                            ['nama_barang' => 'Webcam 1080p', 'kode_barang' => 'WC-001', 'jumlah_barang' => 1],
                            ['nama_barang' => 'Harddisk Eksternal 2TB', 'kode_barang' => 'HD-004', 'jumlah_barang' => 3],
                        ];
                        $rowsPerPage = 5;
                        @endphp
                        @foreach($data_kritis as $index => $item)
                        <tr class="data-row" data-page="{{ floor($index / $rowsPerPage) + 1 }}" style="display: {{ (floor($index / $rowsPerPage) + 1) == 1 ? '' : 'none' }}">
                            <td><p class="text-xs font-weight-bold mb-0">{{ $index + 1 }}</p></td>
                            <td><p class="text-xs font-weight-bold mb-0">{{ $item['nama_barang'] }}</p></td>
                            <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item['kode_barang'] }}</p></td>
                            <td class="text-center"><p class="text-xs font-weight-bold mb-0">{{ $item['jumlah_barang'] }}</p></td>
                            <td class="text-center"><a href="/menu/preview-barang" class="btn btn-sm btn-info mb-0">Preview</a></td>
                        </tr>
                        @endforeach
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
                        {{-- Elemen li untuk nomor halaman akan diisi oleh JavaScript --}}
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

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('.table tbody');
        const paginationList = document.querySelector('.pagination');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const firstPageBtn = document.getElementById('first-page');
        const prevPageBtn = document.getElementById('prev-page');
        const nextPageBtn = document.getElementById('next-page');
        const lastPageBtn = document.getElementById('last-page');

        const rows = tableBody.querySelectorAll('tr.data-row');
        const rowsPerPage = 5;
        let currentPage = 1;
        const totalPages = Math.ceil(rows.length / rowsPerPage);

        function showPage(page) {
            rows.forEach(row => {
                const rowPage = parseInt(row.getAttribute('data-page'));
                row.style.display = (rowPage === page) ? '' : 'none';
            });
        }
        
        function renderPageButtons() {
            pageNumbersContainer.innerHTML = '';
            // Tampilkan semua tombol halaman jika total halaman tidak terlalu banyak
            // atau tambahkan logika '...' jika total halaman lebih dari 5, misalnya
            if (totalPages <= 5) {
                for (let i = 1; i <= totalPages; i++) {
                    const li = document.createElement('li');
                    li.className = 'page-item';
                    li.setAttribute('data-page', i);
                    li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
                    pageNumbersContainer.appendChild(li);
                }
            } else {
                // Logika dengan '...' untuk banyak halaman
                // Ini adalah implementasi dasar, bisa disesuaikan
                let startPage = Math.max(1, currentPage - 1);
                let endPage = Math.min(totalPages, currentPage + 1);

                if (currentPage > 2) {
                    pageNumbersContainer.innerHTML += `<li class="page-item" data-page="1"><a class="page-link" href="#">1</a></li>`;
                    if (currentPage > 3) {
                        pageNumbersContainer.innerHTML += `<li class="page-item disabled"><a class="page-link" href="#">...</a></li>`;
                    }
                }

                for (let i = startPage; i <= endPage; i++) {
                    pageNumbersContainer.innerHTML += `<li class="page-item" data-page="${i}"><a class="page-link" href="#">${i}</a></li>`;
                }

                if (currentPage < totalPages - 1) {
                    if (currentPage < totalPages - 2) {
                        pageNumbersContainer.innerHTML += `<li class="page-item disabled"><a class="page-link" href="#">...</a></li>`;
                    }
                    pageNumbersContainer.innerHTML += `<li class="page-item" data-page="${totalPages}"><a class="page-link" href="#">${totalPages}</a></li>`;
                }
            }
        }

        function updatePaginationButtons() {
            const paginationListItems = document.querySelectorAll('.pagination .page-item');
            paginationListItems.forEach(item => {
                item.classList.remove('active', 'disabled');
            });
            const activePageLink = document.querySelector(`.pagination .page-item[data-page="${currentPage}"]`);
            if (activePageLink) {
                activePageLink.classList.add('active');
            }

            if (currentPage === 1) {
                firstPageBtn.classList.add('disabled');
                prevPageBtn.classList.add('disabled');
            }
            if (currentPage === totalPages) {
                lastPageBtn.classList.add('disabled');
                nextPageBtn.classList.add('disabled');
            }
        }

        paginationList.addEventListener('click', function(e) {
            e.preventDefault();
            const clickedItem = e.target.closest('.page-item');
            if (!clickedItem || clickedItem.classList.contains('disabled')) return;
            
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
            renderPageButtons(); // Render ulang tombol halaman setelah berpindah
            updatePaginationButtons();
        });

        // Tampilkan halaman pertama saat halaman dimuat
        renderPageButtons();
        showPage(currentPage);
        updatePaginationButtons();
    });
</script>
@endsection