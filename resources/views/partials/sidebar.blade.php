<aside class="sidenav navbar navbar-vertical navbar-expand-xs border-radius-lg fixed-start ms-2 bg-white my-2" id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-dark opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand px-4 py-3 m-0" href="{{ url('/menu/dashboard') }}" target="_blank">
            <img src="{{ asset('dashboard/assets/img/logo-ct-dark.png') }}" class="navbar-brand-img" width="26" height="26" alt="main_logo">
            <span class="ms-1 text-sm text-dark">Inventory App</span>
        </a>
    </div>

    <hr class="horizontal dark mt-0 mb-2">

    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/dashboard') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ url('/menu/dashboard') }}">
                    <i class="material-symbols-rounded opacity-5">dashboard</i>
                    <span class="nav-link-text ms-1">Laman Dashboard</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                    Manajemen Produk
                </h6>
            </li>

            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/data-barang') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ url('/menu/data-barang') }}">
                    <i class="material-symbols-rounded opacity-5">inventory_2</i>
                    <span class="nav-link-text ms-1">Manage Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/tambah-barang') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ url('/menu/tambah-barang') }}">
                    <i class="material-symbols-rounded opacity-5">add_shopping_cart</i>
                    <span class="nav-link-text ms-1">Tambah Barang</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/manage-kategori') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ url('/menu/manage-kategori') }}">
                    <i class="material-symbols-rounded opacity-5">category</i>
                    <span class="nav-link-text ms-1">Tambah Kategori</span>
                </a>
            </li>

            <li class="nav-item mt-3">
                <h6 class="ps-4 ms-2 text-uppercase text-xs text-dark font-weight-bolder opacity-5">
                    Halaman Akun
                </h6>
            </li>
            
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/data-user') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ url('/menu/data-user') }}">
                    <i class="material-symbols-rounded opacity-5">group</i>
                    <span class="nav-link-text ms-1">Manage User</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ Request::is('menu/edit-profil') ? 'active bg-gradient-dark text-white' : 'text-dark' }}" href="{{ url('/menu/edit-profil') }}">
                    <i class="material-symbols-rounded opacity-5">person</i>
                    <span class="nav-link-text ms-1">Edit Profil</span>
                </a>
            </li>
        </ul>
    </div>
</aside>