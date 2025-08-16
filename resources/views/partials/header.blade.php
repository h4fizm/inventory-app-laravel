<nav class="navbar navbar-main navbar-expand-lg px-0 mx-3 shadow-none border-radius-xl" 
     id="navbarBlur" data-scroll="true">
  <div class="container-fluid py-1 px-3 d-flex justify-content-between align-items-center">

    <nav aria-label="breadcrumb">
      <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
        <li class="breadcrumb-item text-sm">
          <a class="opacity-5 text-dark" href="javascript:;">Pages</a>
        </li>
        <li class="breadcrumb-item text-sm text-dark active" aria-current="page">
          Dashboard
        </li>
      </ol>
    </nav>

    <div class="d-flex align-items-center">

      <a href="javascript:;" class="nav-link text-body p-0 d-xl-none pe-3" id="iconNavbarSidenav">
        <div class="sidenav-toggler-inner">
          <i class="sidenav-toggler-line"></i>
          <i class="sidenav-toggler-line"></i>
          <i class="sidenav-toggler-line"></i>
        </div>
      </a>

      <div class="dropdown">
        <a class="nav-link text-body font-weight-bold px-0 d-flex align-items-center" 
           href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <i class="material-symbols-rounded me-1">account_circle</i>
          <span>{{ Auth::user()->name ?? 'Guest' }}</span>
        </a>
        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
          <li>
            <a class="dropdown-item d-flex align-items-center" href="{{ route('profile.edit') }}">
              <i class="material-symbols-rounded me-1 text-dark opacity-5">edit</i>
              Edit Profile
            </a>
          </li>
          <li>
            <form action="{{ route('logout') }}" method="POST" class="w-100">
              @csrf
              <button type="submit" class="dropdown-item d-flex align-items-center text-danger">
                <i class="material-symbols-rounded me-1 opacity-5">logout</i>
                Logout
              </button>
            </form>
          </li>
        </ul>
      </div>

    </div>
  </div>
</nav>