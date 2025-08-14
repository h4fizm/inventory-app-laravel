@extends('main')
@section('title', 'Manage User')
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
        <h3 class="mb-0 h4 font-weight-bolder">Manage User</h3>
        <p class="mb-4">Daftar semua pengguna yang terdaftar dalam sistem.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            {{-- Bagian judul, filter, search, dan tombol tambah --}}
            <div class="d-flex justify-content-between align-items-center mb-1">
                <h5 class="mb-0">Daftar User</h5>
                <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#tambahUserModal">+ Tambah User</button>
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
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">No</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">Nama User</th>
                            <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 text-start">Email</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Role</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tgl Terakhir Update</th>
                            <th class="text-center text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                        $data_user = [
                            ['nama_user' => 'John Doe', 'email' => 'john.doe@example.com', 'role' => 'Admin', 'tanggal_update' => '2025-08-10'],
                            ['nama_user' => 'Jane Smith', 'email' => 'jane.smith@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-11'],
                            ['nama_user' => 'Peter Jones', 'email' => 'peter.j@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-12'],
                            ['nama_user' => 'Mary Brown', 'email' => 'mary.b@example.com', 'role' => 'Admin', 'tanggal_update' => '2025-08-13'],
                            ['nama_user' => 'Robert White', 'email' => 'robert.w@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-10'],
                            ['nama_user' => 'Linda Green', 'email' => 'linda.g@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-11'],
                            ['nama_user' => 'Michael Black', 'email' => 'michael.b@example.com', 'role' => 'Admin', 'tanggal_update' => '2025-08-12'],
                            ['nama_user' => 'Sarah Blue', 'email' => 'sarah.b@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-13'],
                            ['nama_user' => 'David Grey', 'email' => 'david.g@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-10'],
                            ['nama_user' => 'Emily Red', 'email' => 'emily.r@example.com', 'role' => 'Admin', 'tanggal_update' => '2025-08-11'],
                            ['nama_user' => 'James Yellow', 'email' => 'james.y@example.com', 'role' => 'User', 'tanggal_update' => '2025-08-12'],
                        ];
                        $rowsPerPage = 5; 
                        
                        $hari_indonesia = ['Sunday' => 'Minggu', 'Monday' => 'Senin', 'Tuesday' => 'Selasa', 'Wednesday' => 'Rabu', 'Thursday' => 'Kamis', 'Friday' => 'Jumat', 'Saturday' => 'Sabtu'];
                        $bulan_indonesia = ['January' => 'Januari', 'February' => 'Februari', 'March' => 'Maret', 'April' => 'April', 'May' => 'Mei', 'June' => 'Juni', 'July' => 'Juli', 'August' => 'Agustus', 'September' => 'September', 'October' => 'Oktober', 'November' => 'November', 'December' => 'Desember'];
                        @endphp
                        @foreach($data_user as $index => $item)
                        @php
                            $tanggal_obj = date_create($item['tanggal_update']);
                            $tanggal_terformat = str_replace(array_keys($hari_indonesia), array_values($hari_indonesia), $tanggal_obj->format('l'));
                            $tanggal_terformat .= ', ' . $tanggal_obj->format('d');
                            $tanggal_terformat .= ' ' . str_replace(array_keys($bulan_indonesia), array_values($bulan_indonesia), $tanggal_obj->format('F'));
                            $tanggal_terformat .= ' ' . $tanggal_obj->format('Y');
                        @endphp
                        <tr class="data-row" data-page="{{ floor($index / $rowsPerPage) + 1 }}" data-row-id="{{ $index }}" style="display: {{ (floor($index / $rowsPerPage) + 1) == 1 ? '' : 'none' }}">
                            <td><p class="text-xs font-weight-bold mb-0 text-start">{{ $index + 1 }}</p></td>
                            <td class="nama_user_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $item['nama_user'] }}</p></td>
                            <td class="email_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $item['email'] }}</p></td>
                            <td class="role_td text-center"><p class="text-xs font-weight-bold mb-0">{{ $item['role'] }}</p></td>
                            <td class="text-center tanggal-update" data-original-date="{{ $item['tanggal_update'] }}">
                                <p class="text-xs font-weight-bold mb-0">{{ $tanggal_terformat }}</p>
                            </td>
                            <td class="text-center">
                                <a href="#" class="btn btn-sm btn-warning mb-0 edit-btn" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</a>
                                <a href="#" class="btn btn-sm btn-danger mb-0 delete-btn">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr id="no-data-row" style="display: none;">
                            <td colspan="6" class="text-center text-secondary">User tidak ditemukan.</td>
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

{{-- Modal Tambah User --}}
<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="tambahUserForm" novalidate>
                    <div class="input-group input-group-outline my-3">
                        <label for="tambah_nama_user" class="form-label">Nama User</label>
                        <input type="text" class="form-control" id="tambah_nama_user" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="tambah_email_user" class="form-label">Email</label>
                        <input type="email" class="form-control" id="tambah_email_user" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="tambah_password_user" class="form-label">Password</label>
                        <input type="password" class="form-control" id="tambah_password_user" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="tambah_retype_password_user" class="form-label">Retype Password</label>
                        <input type="password" class="form-control" id="tambah_retype_password_user" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <select class="form-select" id="tambah_role_user" required>
                            <option selected disabled value="">Pilih Role...</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                <button type="button" class="btn btn-primary" id="saveTambahUserBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

{{-- Modal Edit User --}}
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editUserForm">
                    <input type="hidden" id="edit_row_id">
                    <div class="input-group input-group-outline my-3">
                        <label for="edit_nama_user" class="form-label">Nama User</label>
                        <input type="text" class="form-control" id="edit_nama_user" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="edit_email_user" class="form-label">Email</label>
                        <input type="email" class="form-control" id="edit_email_user" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <label for="edit_role_user" class="form-label">Role</label>
                        <select class="form-select" id="edit_role_user" required>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
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
                const namaUser = row.querySelector('.nama_user_td p').textContent;
                const emailUser = row.querySelector('.email_td p').textContent;
                const roleUser = row.querySelector('.role_td p').textContent;
                
                document.getElementById('edit_row_id').value = rowId;
                document.getElementById('edit_nama_user').value = namaUser;
                document.getElementById('edit_email_user').value = emailUser;
                document.getElementById('edit_role_user').value = roleUser;

                document.getElementById('edit_nama_user').parentElement.classList.add('is-filled');
                document.getElementById('edit_email_user').parentElement.classList.add('is-filled');
                document.getElementById('edit_role_user').parentElement.classList.add('is-filled');
            }
        });

        // Event listener untuk tombol Simpan Perubahan di modal Edit
        document.getElementById('saveChangesBtn').addEventListener('click', function() {
            const rowId = document.getElementById('edit_row_id').value;
            const namaUserBaru = document.getElementById('edit_nama_user').value.trim();
            const emailUserBaru = document.getElementById('edit_email_user').value.trim();
            const roleUserBaru = document.getElementById('edit_role_user').value;

            if (namaUserBaru === '' || emailUserBaru === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nama dan email tidak boleh kosong!',
                });
                return;
            }

            const rowToUpdate = document.querySelector(`tr[data-row-id="${rowId}"]`);
            if (rowToUpdate) {
                rowToUpdate.querySelector('.nama_user_td p').textContent = namaUserBaru;
                rowToUpdate.querySelector('.email_td p').textContent = emailUserBaru;
                rowToUpdate.querySelector('.role_td p').textContent = roleUserBaru;
            }
            
            const modal = bootstrap.Modal.getInstance(document.getElementById('editUserModal'));
            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data user berhasil diperbarui!',
                showConfirmButton: false,
                timer: 1500
            });
        });

        // Event listener untuk tombol Tambah User di modal
        document.getElementById('saveTambahUserBtn').addEventListener('click', function() {
            const form = document.getElementById('tambahUserForm');
            const namaUserBaru = document.getElementById('tambah_nama_user').value.trim();
            const emailUserBaru = document.getElementById('tambah_email_user').value.trim();
            const password = document.getElementById('tambah_password_user').value;
            const retypePassword = document.getElementById('tambah_retype_password_user').value;
            const roleUserBaru = document.getElementById('tambah_role_user').value;

            if (namaUserBaru === '' || emailUserBaru === '' || password === '' || retypePassword === '' || roleUserBaru === '') {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Semua kolom wajib diisi!',
                });
                return;
            }

            if (password !== retypePassword) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Password dan Retype Password tidak cocok!',
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
                <td><p class="text-xs font-weight-bold mb-0 text-start">${newIndex + 1}</p></td>
                <td class="nama_user_td"><p class="text-xs font-weight-bold mb-0 text-start">${namaUserBaru}</p></td>
                <td class="email_td"><p class="text-xs font-weight-bold mb-0 text-start">${emailUserBaru}</p></td>
                <td class="role_td text-center"><p class="text-xs font-weight-bold mb-0">${roleUserBaru}</p></td>
                <td class="text-center tanggal-update" data-original-date="${tanggalSekarang}">
                    <p class="text-xs font-weight-bold mb-0">${formattedDate}</p>
                </td>
                <td class="text-center">
                    <a href="#" class="btn btn-sm btn-warning mb-0 edit-btn" data-bs-toggle="modal" data-bs-target="#editUserModal">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger mb-0 delete-btn">Delete</a>
                </td>
            `;

            tableBody.appendChild(newRow);
            rows = tableBody.querySelectorAll('tr.data-row');
            filterAndRender();

            const modal = bootstrap.Modal.getInstance(document.getElementById('tambahUserModal'));
            modal.hide();

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'User baru berhasil ditambahkan!',
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
        const editModalElement = document.getElementById('editUserModal');
        editModalElement.addEventListener('hidden.bs.modal', function (event) {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
        });

        const tambahModalElement = document.getElementById('tambahUserModal');
        tambahModalElement.addEventListener('hidden.bs.modal', function (event) {
            const backdrop = document.querySelector('.modal-backdrop');
            if (backdrop) {
                backdrop.remove();
            }
            document.getElementById('tambahUserForm').reset();
        });
        
        filterAndRender();
    });
</script>
@endsection