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
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h5 class="mb-0">Daftar User</h5>
                <button type="button" class="btn btn-primary mb-0" data-bs-toggle="modal" data-bs-target="#tambahUserModal">+ Tambah User</button>
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
                        <tr class="data-row">
                            <td><p class="text-xs font-weight-bold mb-0 text-start">{{ $index + 1 }}</p></td>
                            <td class="nama_user_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $user->name }}</p></td>
                            <td class="email_td"><p class="text-xs font-weight-bold mb-0 text-start">{{ $user->email }}</p></td>
                            <td class="role_td text-center"><p class="text-xs font-weight-bold mb-0">{{ $user->getRoleNames()->first() }}</p></td>
                            <td class="text-center">
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
                        <tr>
                            <td colspan="6" class="text-center text-secondary">Tidak ada user yang ditemukan.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Modal Tambah User -->
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

<!-- Modal Edit User -->
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

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
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
});
</script>

@endsection
