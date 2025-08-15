@extends('main')
@section('title', 'Edit Profil')
@section('content')

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<div class="row">
    <div class="col-12">
        <h3 class="mb-0 h4 font-weight-bolder">Edit Profil</h3>
        <p class="mb-4">Perbarui informasi profil dan kata sandi Anda.</p>
    </div>
</div>

<div class="row mt-4">
    <div class="col-12">
        <div class="card p-3">
            <h5 class="mb-3">Informasi Profil</h5>
            <form id="edit-profil-form" action="{{ route('profile.update') }}" method="POST" novalidate>
                @csrf
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <input type="text" placeholder="Nama" class="form-control" id="edit_nama" name="nama" 
                                   value="{{ old('nama', Auth::user()->name) }}" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <input type="email" placeholder="Email" class="form-control" id="edit_email" name="email" 
                                   value="{{ old('email', Auth::user()->email) }}" required>
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12">
                        <h5 class="mb-3">Ubah Kata Sandi (Opsional)</h5>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="edit_password" name="password">
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3">
                            <label class="form-label">Konfirmasi Kata Sandi Baru</label>
                            <input type="password" class="form-control" id="edit_retype_password" name="retype_password">
                        </div>
                    </div>
                </div>
                <div class="row mt-4">
                    <div class="col-12 text-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('edit-profil-form');

    form.addEventListener('submit', function(e) {
        e.preventDefault();

        let formData = new FormData(form);

        // Validasi password match
        if (formData.get('password') !== '' || formData.get('retype_password') !== '') {
            if (formData.get('password') !== formData.get('retype_password')) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Kata Sandi Baru dan Konfirmasi Kata Sandi tidak cocok!',
                });
                return;
            }
        }

        fetch(form.action, {
            method: 'POST',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: data.message,
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: data.message || 'Terjadi kesalahan',
                });
            }
        })
        .catch(() => {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Terjadi kesalahan pada server',
            });
        });
    });
});
</script>

@endsection
