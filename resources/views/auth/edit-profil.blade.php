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
            <form id="edit-profil-form" novalidate>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" id="edit_nama" name="nama" value="John Doe" required>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="input-group input-group-outline my-3 is-filled">
                            <label class="form-label">Email</label>
                            <input type="email" class="form-control" id="edit_email" name="email" value="john.doe@example.com" required>
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
        const namaInput = document.getElementById('edit_nama');
        const emailInput = document.getElementById('edit_email');
        const passwordInput = document.getElementById('edit_password');
        const retypePasswordInput = document.getElementById('edit_retype_password');
        
        form.addEventListener('submit', function(e) {
            e.preventDefault();

            let hasError = false;

            // Validasi field yang wajib diisi
            if (namaInput.value.trim() === '' || emailInput.value.trim() === '') {
                hasError = true;
            }

            // Validasi password jika diisi
            if (passwordInput.value !== '' || retypePasswordInput.value !== '') {
                if (passwordInput.value !== retypePasswordInput.value) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal',
                        text: 'Kata Sandi Baru dan Konfirmasi Kata Sandi tidak cocok!',
                    });
                    return;
                }
            }

            if (hasError) {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: 'Nama dan Email tidak boleh kosong!',
                });
                return;
            }

            // Tampilkan notifikasi sukses jika semua validasi berhasil
            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Profil berhasil diperbarui!',
                showConfirmButton: false,
                timer: 1500
            }).then(() => {
                // Opsional: reset form setelah berhasil
                // form.reset();
            });
        });
    });
</script>

@endsection