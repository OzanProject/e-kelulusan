<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Panel') | {{ $school_setting->school_name ?? 'E-Kelulusan' }}</title>
    @if($school_setting && $school_setting->school_logo)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $school_setting->school_logo) }}">
    @endif

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- AdminLTE v4 CSS -->
    <link rel="stylesheet" href="{{ asset('adminlte/dist/css/adminlte.min.css') }}">
    <!-- OverlayScrollbars -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/styles/overlayscrollbars.min.css" integrity="sha256-dSokZseQNT08wYEWiz5iLI8QPlKxG+TswNRD8k35cpg=" crossorigin="anonymous">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.min.css" integrity="sha256-Qsx5lrStHZyR9REqhUF8iQt73X06c8LGIUPzpOhwRrI=" crossorigin="anonymous">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    
    <style>
        /* Loading Spinner Overlay */
        #loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(255, 255, 255, 0.7);
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
<body class="layout-fixed sidebar-expand-lg bg-body-tertiary">
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>

    <div class="app-wrapper">
        <!-- Header -->
        @include('backend.layouts.header')

        <!-- Sidebar -->
        @include('backend.layouts.sidebar')

        <!-- Main content -->
        <main class="app-main">
            <!-- App Content Header -->
            <div class="app-content-header">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="mb-0">@yield('page_title')</h3>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-end">
                                <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">@yield('page_title')</li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- App Content -->
            <div class="app-content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </main>

        <!-- Footer -->
        @include('backend.layouts.footer')
    </div>

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <!-- AdminLTE App -->
    <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.3.0/browser/overlayscrollbars.browser.es6.min.js" integrity="sha256-H2VM7BKda+v2Z4+DRy69uknwxjyDRhszjXFhsL4gD3w=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha256-whL0tQWoY1Ku1iskqPFvmZ+CHsvmRWx/PIoEvIeWh4I=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha256-YMa+wAM6QkVyz999odX7lPRxkoYAan8suedu4k2Zur8=" crossorigin="anonymous"></script>
    <script src="{{ asset('adminlte/dist/js/adminlte.min.js') }}"></script>
    
    <script>
        const SELECTOR_SIDEBAR_WRAPPER = ".sidebar-wrapper";
        const Default = {
            scrollbarTheme: "os-theme-light",
            scrollbarAutoHide: "leave",
            scrollbarClickScroll: true,
        };
        document.addEventListener("DOMContentLoaded", function() {
            const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);
            if (
                sidebarWrapper &&
                typeof OverlayScrollbarsGlobal?.OverlayScrollbars !== "undefined"
            ) {
                OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                    scrollbars: {
                        theme: Default.scrollbarTheme,
                        autoHide: Default.scrollbarAutoHide,
                        clickScroll: Default.scrollbarClickScroll,
                    },
                });
            }

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
            window.hideLoading = function() {
                document.getElementById('loading-overlay').classList.remove('show');
            }

            // Show loading on form submit
            document.querySelectorAll('form').forEach(form => {
                form.addEventListener('submit', function() {
                    if (!this.classList.contains('no-loader')) {
                        showLoading();
                    }
                });
            });

            // Show loading on navigation (menu change)
            document.querySelectorAll('a').forEach(link => {
                link.addEventListener('click', function(e) {
                    const href = this.getAttribute('href');
                    const target = this.getAttribute('target');
                    
                    // Trigger loader if:
                    // 1. href exists and isn't just '#' or 'javascript:void(0)'
                    // 2. target isn't '_blank' (new tab)
                    // 3. Not a file download or same-page anchor
                    // 4. Doesn't have 'no-loader' class
                    if (href && href !== '#' && !href.startsWith('#') && !href.startsWith('javascript') && target !== '_blank' && !this.hasAttribute('download') && !this.hasAttribute('data-bs-toggle') && !this.hasAttribute('data-bs-theme-value') && !this.classList.contains('no-loader')) {
                        showLoading();
                    }
                });
            });
        });

        // Color Mode Toggler
        (() => {
            'use strict';

            const storedTheme = localStorage.getItem('theme');

            const getPreferredTheme = () => {
                if (storedTheme) {
                    return storedTheme;
                }
                return globalThis.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
            };

            const setTheme = function (theme) {
                if (theme === 'auto' && globalThis.matchMedia('(prefers-color-scheme: dark)').matches) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', theme);
                }
            };

            setTheme(getPreferredTheme());

            const showActiveTheme = (theme, focus = false) => {
                const themeSwitcher = document.querySelector('#bd-theme');

                if (!themeSwitcher) {
                    return;
                }

                const themeSwitcherText = document.querySelector('#bd-theme-text');
                const activeThemeIcon = document.querySelector('.theme-icon-active i');
                const btnToActive = document.querySelector(`[data-bs-theme-value="${theme}"]`);
                if (!btnToActive) return;
                const svgOfActiveBtn = btnToActive.querySelector('i').getAttribute('class');

                for (const element of document.querySelectorAll('[data-bs-theme-value]')) {
                    element.classList.remove('active');
                    element.setAttribute('aria-pressed', 'false');
                }

                btnToActive.classList.add('active');
                btnToActive.setAttribute('aria-pressed', 'true');
                activeThemeIcon.setAttribute('class', svgOfActiveBtn);
                const themeSwitcherLabel = `${themeSwitcherText.textContent} (${btnToActive.dataset.bsThemeValue})`;
                themeSwitcher.setAttribute('aria-label', themeSwitcherLabel);

                if (focus) {
                    themeSwitcher.focus();
                }
            };

            globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
                if (storedTheme !== 'light' || storedTheme !== 'dark') {
                    setTheme(getPreferredTheme());
                }
            });

            globalThis.addEventListener('DOMContentLoaded', () => {
                showActiveTheme(getPreferredTheme());

                for (const toggle of document.querySelectorAll('[data-bs-theme-value]')) {
                    toggle.addEventListener('click', () => {
                        const theme = toggle.getAttribute('data-bs-theme-value');
                        localStorage.setItem('theme', theme);
                        setTheme(theme);
                        showActiveTheme(theme, true);
                    });
                }
            });
        })();
    </script>
    @stack('scripts')
</body>
</html>
