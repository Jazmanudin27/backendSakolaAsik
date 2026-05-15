<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=0.90, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="AdminKit">
    <meta name="keywords"
        content="adminkit, bootstrap, bootstrap 5, admin, dashboard, template, responsive, css, sass, html, theme, front-end, ui kit, web">

    <link rel="shortcut icon" href="{{ asset('adminkit/img/icons/icon-48x48.png') }}" />

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('titlepage', 'Admin Dashboard')</title>

    <link href="{{ asset('adminkit/css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('adminkit/css/style.css') }}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link href="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.css" rel="stylesheet">
    <script src="https://cdn.datatables.net/v/dt/dt-1.13.6/datatables.min.js"></script>

    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-maskmoney/3.0.2/jquery.maskMoney.min.js"></script>

    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }
    </style>
</head>

<body>
    <div class="wrapper">
        {{-- Dynamic Sidebar based on user role --}}
        {{-- @if (Auth::guard('admin')->check())
            @include('layouts.admin-sidebar')
        @elseif(Auth::guard('guru')->check())
            @include('layouts.guru-sidebar')
        @elseif(Auth::guard('siswa')->check())
            @include('layouts.siswa-sidebar')
        @else
            @include('layouts.admin-sidebar')
        @endif --}}

        <div class="main">
            {{-- @if (Auth::guard('admin')->check())
                @include('layouts.admin-navbar')
            @elseif(Auth::guard('guru')->check())
                @include('layouts.guru-navbar')
            @elseif(Auth::guard('siswa')->check())
                @include('layouts.siswa-navbar')
            @else
                @include('layouts.admin-navbar')
            @endif --}}

            @if (session('success'))
                <script>
                    Swal.fire(
                        'Success',
                        '{{ session('success') }}',
                        'success'
                    )
                </script>
            @endif
            @if (session('warning'))
                <script>
                    Swal.fire(
                        'Opps,',
                        '{{ session('warning') }}',
                        'warning'
                    )
                </script>
            @endif
            @if (session('error'))
                <script>
                    Swal.fire(
                        'Error',
                        '{{ session('error') }}',
                        'error'
                    )
                </script>
            @endif

            <!-- Flash Messages -->
            {{-- @if (session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif --}}


            @if ($errors->any())
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Perhatian!</strong> Harap perbaiki error berikut:
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- NAVBAR -->
            <div class="container-fluid-0 position-absolute w-100 px-3 pt-3" id="nav-bar" style="z-index:10;">
                <div class="row">
                    <div class="col-12 d-flex gap-2 justify-content-start">
                        <a href="{{ route($userRole . '.dashboard') }}"
                            class="btn bg-white shadow-sm rounded-pill px-3 border {{ request()->routeIs($userRole . '.dashboard') ? 'd-none' : '' }}">
                            <i class="fas fa-home me-2"></i>Home
                        </a>
                        <a href="#"
                            onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                            class="btn bg-danger text-white shadow-sm rounded-pill px-3">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            Logout
                        </a>
                    </div>
                </div>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            </div>
            <div class="menu-container pt-6">
                @yield('content')
            </div>
        </div>
    </div>

    <script>
        // Comprehensive error handling for app.js issues
        window.addEventListener('error', function(e) {
            if (e.message && e.message.includes('toSvg')) {
                console.warn('toSvg error prevented:', e.message);
                e.preventDefault();
                return false;
            }
            if (e.message && e.message.includes('Cannot read properties')) {
                console.warn('Property access error prevented:', e.message);
                e.preventDefault();
                return false;
            }
        });

        // Fix for toSvg error and other string manipulation issues
        if (typeof window !== 'undefined') {
            const originalReplace = String.prototype.replace;
            String.prototype.replace = function(...args) {
                try {
                    return originalReplace.apply(this, args);
                } catch (error) {
                    console.warn('String.replace error caught:', error);
                    return this.toString();
                }
            };

            // Prevent undefined property access
            const originalForEach = Array.prototype.forEach;
            Array.prototype.forEach = function(...args) {
                try {
                    return originalForEach.apply(this, args);
                } catch (error) {
                    console.warn('Array.forEach error caught:', error);
                    return;
                }
            };
        }
    </script>
    <script src="{{ asset('adminkit/js/app.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Disable feather icons to prevent conflicts with app.js
        // app.js already handles feather icons initialization
        console.log('Feather icons disabled to prevent app.js conflicts');

        $(document).ready(function() {
            $('.uang').maskMoney({
                thousands: ',',
                precision: 0
            });

            $('.delete').on("click", function(e) {
                e.preventDefault();
                const deleteButton = $(this);
                const deleteForm = deleteButton.closest('form');

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        deleteForm.submit();
                    }
                })
            });

            $('.datatables').DataTable({
                responsive: true,
                lengthChange: false,
                ordering: false,
                info: false
            });

            $('.select2').select2({});

            $('.datepicker').datepicker({
                dateFormat: 'yy-mm-dd',
            });

            function enableHorizontalScroll() {
                $('.table-responsive').each(function() {
                    var containerWidth = $(this).width();
                    var tableWidth = $('table', this).outerWidth();
                    if (tableWidth > containerWidth) {
                        $(this).addClass('scrollable');
                    } else {
                        $(this).removeClass('scrollable');
                    }
                });
            }

            $(window).on('resize', enableHorizontalScroll);
            enableHorizontalScroll();

            function updateClock() {
                var now = new Date();
                var date = now.getDate();
                var month = now.getMonth() + 1;
                var year = now.getFullYear();
                var hours = now.getHours();
                var minutes = now.getMinutes();
                var seconds = now.getSeconds();

                hours = (hours < 10) ? "0" + hours : hours;
                minutes = (minutes < 10) ? "0" + minutes : minutes;
                seconds = (seconds < 10) ? "0" + seconds : seconds;

                var bulan = [
                    "Januari", "Februari", "Maret", "April", "Mei", "Juni",
                    "Juli", "Agustus", "September", "Oktober", "November", "Desember"
                ];
                var time = date + " " + bulan[month - 1] + " " + year + " " + hours + ":" + minutes + ":" +
                    seconds;

                $('#clock').html(time);
            }
            setInterval(updateClock, 1000);
            updateClock();
        });
    </script>

    @yield('scripts')
</body>

</html>
