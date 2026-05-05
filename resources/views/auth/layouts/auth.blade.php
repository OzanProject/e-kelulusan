<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>@yield('title') | {{ $school_setting->school_name ?? 'E-Kelulusan' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes" />
    <meta name="color-scheme" content="light dark" />
    @if($school_setting && $school_setting->school_logo)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $school_setting->school_logo) }}">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@fontsource/source-sans-3@5.0.12/index.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" />
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.css') }}" />
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .login-box {
            width: 400px;
        }

        .card {
            border: none;
            border-top: 4px solid #00628c;
            border-radius: 12px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .login-logo img {
            filter: drop-shadow(0 4px 6px rgba(0, 0, 0, 0.1));
        }

        /* Loading Spinner Overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.8);
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            visibility: hidden;
            opacity: 0;
            transition: all 0.3s ease;
        }

        #loading-overlay.show {
            visibility: visible;
            opacity: 1;
        }
    </style>
    @stack('css')
</head>

<body class="@yield('body_class')">
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="@yield('box_class')">
        <div class="login-logo mb-4 text-center">
            <a href="{{ url('/') }}" class="text-decoration-none">
                @if($school_setting && $school_setting->school_logo)
                    <img src="{{ asset('storage/' . $school_setting->school_logo) }}" alt="Logo" class="img-fluid mb-2"
                        style="max-height: 90px;">
                    <div class="h4 fw-bold text-dark mb-0">{{ $school_setting->school_name }}</div>
                    <div class="small text-muted">Portal Kelulusan</div>
                @else
                    <b class="text-primary">E-</b><span class="text-dark">Kelulusan</span>
                @endif
            </a>
        </div>

        <div class="card">
            <div class="card-body @yield('card_class') p-4">
                @yield('content')
            </div>
        </div>

        <div class="text-center mt-4 text-muted small">
            &copy; {{ date('Y') }} <a href="https://ozanproject.site" target="_blank" class="text-decoration-none">Ozan
                Project</a>
        </div>
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.js') }}"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // --- SweetAlert2 Handler ---
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                });
            @endif

            // --- Loading Spinner Handler ---
            window.showLoading = function() {
                document.getElementById('loading-overlay').classList.add('show');
            }

            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function () {
                    showLoading();
                });
            });

            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function (e) {
                    const href = this.getAttribute('href');
                    const target = this.getAttribute('target');
                    if (href && href !== '#' && !href.startsWith('#') && !href.startsWith('javascript') && target !== '_blank' && !this.hasAttribute('download')) {
                        showLoading();
                    }
                });
            });
        });
    </script>
</body>

</html>