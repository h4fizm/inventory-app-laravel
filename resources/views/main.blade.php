<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Favicons -->
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('dashboard/assets/img/apple-icon.png') }}">
    <link rel="icon" type="image/png" href="{{ asset('dashboard/assets/img/favicon.png') }}">

    <title>@yield('title')</title>

    <!-- Fonts and icons -->
    <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Inter:300,400,500,600,700,900" />
    <link href="{{ asset('dashboard/assets/css/nucleo-icons.css') }}" rel="stylesheet" />
    <link href="{{ asset('dashboard/assets/css/nucleo-svg.css') }}" rel="stylesheet" />

    <!-- Material Symbols -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@24,400,0,0" />

    <!-- Bootstrap JS sudah include -->
    <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>

    <!-- Main CSS -->
    <link id="pagestyle" href="{{ asset('dashboard/assets/css/material-dashboard.css?v=3.2.0') }}" rel="stylesheet" />

    {{-- Leaflet JS --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
     integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
     crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
     integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
     crossorigin=""></script>

</head>
<body class="g-sidenav-show bg-gray-100">

    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">

        {{-- HEADER --}}
        @include('partials.header')

        <div class="container-fluid py-2">

            {{-- PAGE CONTENT --}}
            @yield('content')

            {{-- FOOTER --}}
            @include('partials.footer')

        </div>
    </main>

    <!-- Core JS -->
    <script src="{{ asset('dashboard/assets/js/core/popper.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/core/bootstrap.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/smooth-scrollbar.min.js') }}"></script>
    <script src="{{ asset('dashboard/assets/js/plugins/chartjs.min.js') }}"></script>

    {{-- Chart Initializations --}}
    <script>
        // Chart Bars
        var ctx = document.getElementById("chart-bars").getContext("2d");
        new Chart(ctx, {
            type: "bar",
            data: {
                labels: ["M", "T", "W", "T", "F", "S", "S"],
                datasets: [{
                    label: "Views",
                    backgroundColor: "#43A047",
                    data: [50, 45, 22, 28, 50, 60, 76],
                    borderRadius: 4,
                    borderSkipped: false,
                    barThickness: 'flex'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                interaction: { intersect: false, mode: 'index' },
                scales: {
                    y: {
                        grid: { drawBorder: false, color: '#e5e5e5', borderDash: [5, 5] },
                        ticks: { color: "#737373", beginAtZero: true, padding: 10 }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { color: '#737373', padding: 10 }
                    }
                }
            }
        });

        // Chart Line - Sales
        var ctx2 = document.getElementById("chart-line").getContext("2d");
        new Chart(ctx2, {
            type: "line",
            data: {
                labels: ["J", "F", "M", "A", "M", "J", "J", "A", "S", "O", "N", "D"],
                datasets: [{
                    label: "Sales",
                    borderColor: "#43A047",
                    pointBackgroundColor: "#43A047",
                    data: [120, 230, 130, 440, 250, 360, 270, 180, 90, 300, 310, 220],
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false },
                    tooltip: {
                        callbacks: {
                            title: function(context) {
                                const fullMonths = [
                                    "January", "February", "March", "April", "May", "June",
                                    "July", "August", "September", "October", "November", "December"
                                ];
                                return fullMonths[context[0].dataIndex];
                            }
                        }
                    }
                },
                interaction: { intersect: false, mode: 'index' }
            }
        });

        // Chart Line - Tasks
        var ctx3 = document.getElementById("chart-line-tasks").getContext("2d");
        new Chart(ctx3, {
            type: "line",
            data: {
                labels: ["Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [{
                    label: "Tasks",
                    borderColor: "#43A047",
                    pointBackgroundColor: "#43A047",
                    data: [50, 40, 300, 220, 500, 250, 400, 230, 500],
                    borderWidth: 2,
                    pointRadius: 3,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                interaction: { intersect: false, mode: 'index' }
            }
        });

        // Scrollbar Init (Windows only)
        if (navigator.platform.indexOf('Win') > -1 && document.querySelector('#sidenav-scrollbar')) {
            Scrollbar.init(document.querySelector('#sidenav-scrollbar'), { damping: '0.5' });
        }
    </script>

    <!-- GitHub Buttons -->
    <script async defer src="https://buttons.github.io/buttons.js"></script>

    <!-- Material Dashboard Control Center -->
    <script src="{{ asset('dashboard/assets/js/material-dashboard.min.js?v=3.2.0') }}"></script>
</body>
</html>
