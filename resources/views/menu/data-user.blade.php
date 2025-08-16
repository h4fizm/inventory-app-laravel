@extends('main')
@section('title', 'Manage User')
@section('content')

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

{{-- Alert sukses & error --}}
@if (session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if (session('error'))
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        {{ session('error') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap">
                <h5 class="mb-0">Daftar User</h5>
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
                    <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#tambahUserModal">+ Tambah User</button>
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
                        @forelse($users as $index => $user)
                        <tr class="data-row" data-row-id="{{ $user->id }}" data-tanggal-update="{{ \Carbon\Carbon::parse($user->updated_at)->format('Y-m-d') }}">
                            <td><p class="text-xs font-weight-bold mb-0 text-start">{{ $index + 1 }}</p></td>
                            <td class="nama_user_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $user->name }}</p></td>
                            <td class="email_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $user->email }}</p></td>
                            <td class="role_td text-center"><p class="text-xs font-weight-bold mb-0">{{ $user->getRoleNames()->first() }}</p></td>
                            <td class="tanggal_update_td text-center">
                                <p class="text-xs font-weight-bold mb-0">{{ \Carbon\Carbon::parse($user->updated_at)->locale('id')->isoFormat('dddd, D MMMM YYYY') }}</p>
                            </td>
                            <td class="text-center">
                                <button type="button" class="btn btn-sm btn-warning mb-0" data-bs-toggle="modal" data-bs-target="#editUserModal{{ $user->id }}">Edit</button>
                                
                                <form action="{{ route('data-user.destroy', ['data_user' => $user->id]) }}" method="POST" class="d-inline delete-form">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-danger mb-0 btn-delete" data-username="{{ $user->name }}">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        {{-- Baris ini akan ditampilkan jika data tidak ada --}}
                        <tr id="no-data-row">
                            <td colspan="6" class="text-center text-secondary">Tidak ada user yang ditemukan.</td>
                        </tr>
                        @endforelse
                        {{-- Baris ini akan digunakan oleh JS saat filter/search tidak ada hasil --}}
                        <tr id="no-data-row-js" style="display: none;">
                            <td colspan="6" class="text-center text-secondary">Data Tidak Ditemukan.</td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div class="d-flex justify-content-end mt-3">
                <nav aria-label="Page navigation example">
                    <ul class="pagination" id="user-pagination">
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

<div class="modal fade" id="tambahUserModal" tabindex="-1" aria-labelledby="tambahUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahUserModalLabel">Tambah User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Alert validasi --}}
                @if ($errors->any() && old('form_type') == 'tambah')
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('data-user.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="form_type" value="tambah">
                    <div class="input-group input-group-outline my-3">
                        <input type="text" placeholder="Nama User" class="form-control" name="name" value="{{ old('name') }}" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <input type="email" placeholder="Email" class="form-control" name="email" value="{{ old('email') }}" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <input type="password" placeholder="Password" class="form-control" name="password" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <input type="password" placeholder="Konfirmasi Password" class="form-control" name="password_confirmation" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <select class="form-select" name="role" required>
                            <option selected disabled value="">Pilih Role...</option>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role') == $role->name)>{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@foreach($users as $user)
<div class="modal fade" id="editUserModal{{ $user->id }}" tabindex="-1" aria-labelledby="editUserModalLabel{{ $user->id }}" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel{{ $user->id }}">Edit User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{-- Alert validasi --}}
                @if ($errors->any() && old('form_type') == 'edit' && old('user_id') == $user->id)
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>Terjadi kesalahan!</strong>
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <form action="{{ route('data-user.update', ['data_user' => $user->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="form_type" value="edit">
                    <input type="hidden" name="user_id" value="{{ $user->id }}">
                    <div class="input-group input-group-outline my-3 is-filled">
                        <label class="form-label">Nama User</label>
                        <input type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required>
                    </div>
                    <div class="input-group input-group-outline my-3 is-filled">
                        <label class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                    </div>
                    <div class="input-group input-group-outline my-3">
                        <select class="form-select" name="role" required>
                            @foreach ($roles as $role)
                                <option value="{{ $role->name }}" @if(old('role', $user->getRoleNames()->first()) == $role->name) selected @endif>
                                    {{ ucfirst($role->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tableBody = document.querySelector('.table tbody');
        const paginationList = document.getElementById('user-pagination');
        const pageNumbersContainer = document.getElementById('page-numbers');
        const searchInput = document.getElementById('search-input');
        const tanggalMulaiInput = document.getElementById('tanggal_mulai');
        const tanggalAkhirInput = document.getElementById('tanggal_akhir');
        
        const allRows = Array.from(tableBody.querySelectorAll('tr.data-row'));
        const noDataRowPHP = document.getElementById('no-data-row');
        const noDataRowJS = document.getElementById('no-data-row-js');
        const rowsPerPage = 10;
        let currentPage = 1;
        let visibleRows = [];

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
                const rowDate = row.getAttribute('data-tanggal-update');
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
            
            // Logika menampilkan atau menyembunyikan pesan "Data Tidak Ditemukan"
            if (noDataRowPHP) {
                noDataRowPHP.style.display = 'none'; // Selalu sembunyikan yang dari PHP
            }
            if (noDataRowJS) {
                noDataRowJS.style.display = visibleRows.length === 0 ? '' : 'none';
            }

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
        
        const tambahModal = document.getElementById('tambahUserModal');
        if (tambahModal) {
            tambahModal.addEventListener('input', function(e) {
                const parent = e.target.closest('.input-group');
                if (parent) {
                    if (e.target.value.trim() !== '') {
                        parent.classList.add('is-filled');
                    } else {
                        parent.classList.remove('is-filled');
                    }
                }
            });
        }

        // Auto open modal jika validasi gagal
        @if ($errors->any())
            @if (old('form_type') == 'tambah')
                var tambahModalInstance = new bootstrap.Modal(document.getElementById('tambahUserModal'));
                tambahModalInstance.show();
            @elseif (old('form_type') == 'edit')
                var editModalInstance = new bootstrap.Modal(document.getElementById('editUserModal' + {{ old('user_id') }}));
                editModalInstance.show();
            @endif
        @endif

        // SweetAlert konfirmasi delete
        document.querySelectorAll('.btn-delete').forEach(function(button) {
            button.addEventListener('click', function(e) {
                let form = this.closest('form');
                let username = this.dataset.username;

                Swal.fire({
                    title: 'Yakin hapus?',
                    text: `User "${username}" akan dihapus permanen.`,
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

        searchInput.addEventListener('keyup', filterAndRender);
        tanggalMulaiInput.addEventListener('change', filterAndRender);
        tanggalAkhirInput.addEventListener('change', filterAndRender);
        
        filterAndRender();
    });
</script>

@endsection