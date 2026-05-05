<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    
    <!-- SEO Meta Tags -->
    <meta name="description" content="{{ $school_setting->hero_description ?? 'Portal Resmi Pengumuman Kelulusan Siswa. Cek status kelulusan Anda secara online dengan mudah dan cepat.' }}">
    <meta name="keywords" content="pengumuman kelulusan, cek kelulusan online, SKL online, {{ $school_setting->school_name ?? 'sekolah' }}">
    <meta name="author" content="{{ $school_setting->school_name ?? 'E-Kelulusan' }}">
    <meta name="robots" content="index, follow">

    <!-- Open Graph / Facebook -->
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Beranda') | {{ $school_setting->school_name ?? 'E-Kelulusan' }}">
    <meta property="og:description" content="{{ $school_setting->hero_description ?? 'Portal Resmi Pengumuman Kelulusan Siswa.' }}">
    <meta property="og:image" content="{{ $school_setting && $school_setting->school_logo ? asset('storage/' . $school_setting->school_logo) : asset('favicon.ico') }}">

    <!-- Twitter -->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Beranda') | {{ $school_setting->school_name ?? 'E-Kelulusan' }}">
    <meta property="twitter:description" content="{{ $school_setting->hero_description ?? 'Portal Resmi Pengumuman Kelulusan Siswa.' }}">
    <meta property="twitter:image" content="{{ $school_setting && $school_setting->school_logo ? asset('storage/' . $school_setting->school_logo) : asset('favicon.ico') }}">

    <link rel="canonical" href="{{ url()->current() }}">

    <!-- Structured Data (JSON-LD) for Google -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "EducationalOrganization",
      "name": "{{ $school_setting->school_name ?? 'E-Kelulusan' }}",
      "url": "{{ url('/') }}",
      "logo": "{{ $school_setting && $school_setting->school_logo ? asset('storage/' . $school_setting->school_logo) : asset('favicon.ico') }}",
      "description": "{{ $school_setting->hero_description ?? 'Portal Resmi Pengumuman Kelulusan Siswa.' }}",
      "address": {
        "@type": "PostalAddress",
        "streetAddress": "{{ $school_setting->address ?? '' }}",
        "addressLocality": "{{ $school_setting->school_address_city ?? '' }}",
        "addressCountry": "ID"
      },
      "contactPoint": {
        "@type": "ContactPoint",
        "telephone": "{{ $school_setting->phone ?? '' }}",
        "contactType": "customer service"
      }
    }
    </script>

    <title>@yield('title', 'Beranda') | {{ $school_setting->school_name ?? 'E-Kelulusan' }}</title>
    @if($school_setting && $school_setting->school_logo)
        <link rel="icon" type="image/x-icon" href="{{ asset('storage/' . $school_setting->school_logo) }}">
    @endif
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:wght@400;500;600;700&amp;display=swap" rel="stylesheet"/>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    colors: {
                        "on-tertiary": "var(--color-on-tertiary)",
                        "inverse-surface": "var(--color-inverse-surface)",
                        "primary-fixed": "var(--color-primary-fixed)",
                        "on-primary-fixed-variant": "var(--color-on-primary-fixed-variant)",
                        "error-container": "var(--color-error-container)",
                        "surface-variant": "var(--color-surface-variant)",
                        "surface-bright": "var(--color-surface-bright)",
                        "tertiary-container": "var(--color-tertiary-container)",
                        "on-tertiary-container": "var(--color-on-tertiary-container)",
                        "primary-container": "var(--color-primary-container)",
                        "surface-container-low": "var(--color-surface-container-low)",
                        "primary": "var(--color-primary)",
                        "surface-container-lowest": "var(--color-surface-container-lowest)",
                        "on-primary-fixed": "var(--color-on-primary-fixed)",
                        "primary-fixed-dim": "var(--color-primary-fixed-dim)",
                        "surface-dim": "var(--color-surface-dim)",
                        "on-surface": "var(--color-on-surface)",
                        "on-background": "var(--color-on-background)",
                        "on-error-container": "var(--color-on-error-container)",
                        "on-tertiary-fixed": "var(--color-on-tertiary-fixed)",
                        "surface-container-high": "var(--color-surface-container-high)",
                        "tertiary": "var(--color-tertiary)",
                        "surface-container": "var(--color-surface-container)",
                        "secondary": "var(--color-secondary)",
                        "on-error": "var(--color-on-error)",
                        "on-secondary": "var(--color-on-secondary)",
                        "on-tertiary-fixed-variant": "var(--color-on-tertiary-fixed-variant)",
                        "surface-container-highest": "var(--color-surface-container-highest)",
                        "tertiary-fixed-dim": "var(--color-tertiary-fixed-dim)",
                        "surface": "var(--color-surface)",
                        "secondary-fixed-dim": "var(--color-secondary-fixed-dim)",
                        "on-secondary-fixed-variant": "var(--color-on-secondary-fixed-variant)",
                        "outline": "var(--color-outline)",
                        "secondary-fixed": "var(--color-secondary-fixed)",
                        "background": "var(--color-background)",
                        "outline-variant": "var(--color-outline-variant)",
                        "inverse-on-surface": "var(--color-inverse-on-surface)",
                        "secondary-container": "var(--color-secondary-container)",
                        "on-secondary-fixed": "var(--color-on-secondary-fixed)",
                        "surface-tint": "var(--color-surface-tint)",
                        "error": "var(--color-error)",
                        "on-primary": "var(--color-on-primary)",
                        "inverse-primary": "var(--color-inverse-primary)",
                        "on-primary-container": "var(--color-on-primary-container)",
                        "on-surface-variant": "var(--color-on-surface-variant)",
                        "tertiary-fixed": "var(--color-tertiary-fixed)",
                        "on-secondary-container": "var(--color-on-secondary-container)"
                    },
                    borderRadius: {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    spacing: {
                        "card-padding": "1.25rem",
                        "base": "8px",
                        "section-padding": "3rem",
                        "gutter": "1.5rem",
                        "container-max": "1200px"
                    },
                    fontFamily: {
                        "headline-md": ["Public Sans"],
                        "label-sm": ["Public Sans"],
                        "body-md": ["Public Sans"],
                        "headline-xl": ["Public Sans"],
                        "body-lg": ["Public Sans"],
                        "headline-lg": ["Public Sans"],
                        "label-bold": ["Public Sans"]
                    },
                    fontSize: {
                        "headline-md": ["24px", { lineHeight: "1.4", fontWeight: "600" }],
                        "label-sm": ["12px", { lineHeight: "1.2", fontWeight: "500" }],
                        "body-md": ["16px", { lineHeight: "1.6", fontWeight: "400" }],
                        "headline-xl": ["40px", { lineHeight: "1.2", fontWeight: "700" }],
                        "body-lg": ["18px", { lineHeight: "1.6", fontWeight: "400" }],
                        "headline-lg": ["32px", { lineHeight: "1.3", fontWeight: "600" }],
                        "label-bold": ["14px", { lineHeight: "1.2", letterSpacing: "0.02em", fontWeight: "700" }]
                    }
                }
            }
        }
    </script>
    <style>
        :root {
            --color-on-tertiary: #ffffff;
            --color-inverse-surface: #2d3133;
            --color-primary-fixed: #c8e6ff;
            --color-on-primary-fixed-variant: #004c6d;
            --color-error-container: #ffdad6;
            --color-surface-variant: #e0e3e6;
            --color-surface-bright: #f7f9fc;
            --color-tertiary-container: #6d767e;
            --color-on-tertiary-container: #fcfcff;
            --color-primary-container: #247caa;
            --color-surface-container-low: #f2f4f7;
            --color-primary: #00628c;
            --color-surface-container-lowest: #ffffff;
            --color-on-primary-fixed: #001e2e;
            --color-primary-fixed-dim: #87ceff;
            --color-surface-dim: #d8dadd;
            --color-on-surface: #191c1e;
            --color-on-background: #191c1e;
            --color-on-error-container: #93000a;
            --color-on-tertiary-fixed: #141d23;
            --color-surface-container-high: #e6e8eb;
            --color-tertiary: #545d65;
            --color-surface-container: #eceef1;
            --color-secondary: #595f65;
            --color-on-error: #ffffff;
            --color-on-secondary: #ffffff;
            --color-on-tertiary-fixed-variant: #3f484f;
            --color-surface-container-highest: #e0e3e6;
            --color-tertiary-fixed-dim: #bfc8d0;
            --color-surface: #f7f9fc;
            --color-secondary-fixed-dim: #c1c7ce;
            --color-on-secondary-fixed-variant: #41474e;
            --color-outline: #70787f;
            --color-secondary-fixed: #dde3eb;
            --color-background: #f7f9fc;
            --color-outline-variant: #bfc7d0;
            --color-inverse-on-surface: #eff1f4;
            --color-secondary-container: #dde3eb;
            --color-on-secondary-fixed: #161c22;
            --color-surface-tint: #00658f;
            --color-error: #ba1a1a;
            --color-on-primary: #ffffff;
            --color-inverse-primary: #87ceff;
            --color-on-primary-container: #fcfcff;
            --color-on-surface-variant: #40484e;
            --color-tertiary-fixed: #dbe4ed;
            --color-on-secondary-container: #5f656c;
        }

        .dark {
            --color-on-tertiary: #263137;
            --color-inverse-surface: #e0e3e6;
            --color-primary-fixed: #c8e6ff;
            --color-on-primary-fixed-variant: #004c6d;
            --color-error-container: #93000a;
            --color-surface-variant: #40484e;
            --color-surface-bright: #36393b;
            --color-tertiary-container: #3d464d;
            --color-on-tertiary-container: #dbe4ed;
            --color-primary-container: #004c6d;
            --color-surface-container-low: #191c1e;
            --color-primary: #87ceff;
            --color-surface-container-lowest: #0b0f11;
            --color-on-primary-fixed: #001e2e;
            --color-primary-fixed-dim: #87ceff;
            --color-surface-dim: #0f1416;
            --color-on-surface: #e0e3e6;
            --color-on-background: #e0e3e6;
            --color-on-error-container: #ffdad6;
            --color-on-tertiary-fixed: #141d23;
            --color-surface-container-high: #262a2c;
            --color-tertiary: #bfc8d0;
            --color-surface-container: #1d2022;
            --color-secondary: #c1c7ce;
            --color-on-error: #690005;
            --color-on-secondary: #2b3136;
            --color-on-tertiary-fixed-variant: #3f484f;
            --color-surface-container-highest: #303537;
            --color-tertiary-fixed-dim: #bfc8d0;
            --color-surface: #0f1416;
            --color-secondary-fixed-dim: #c1c7ce;
            --color-on-secondary-fixed-variant: #41474e;
            --color-outline: #8a9298;
            --color-secondary-fixed: #dde3eb;
            --color-background: #0f1416;
            --color-outline-variant: #40484e;
            --color-inverse-on-surface: #2d3133;
            --color-secondary-container: #41474e;
            --color-on-secondary-fixed: #161c22;
            --color-surface-tint: #87ceff;
            --color-error: #ffb4ab;
            --color-on-primary: #00344d;
            --color-inverse-primary: #00658f;
            --color-on-primary-container: #c8e6ff;
            --color-on-surface-variant: #bfc7d0;
            --color-tertiary-fixed: #dbe4ed;
            --color-on-secondary-container: #dde3eb;
        }

        .material-symbols-outlined {
            font-variation-settings: 'FILL' 0, 'wght' 400, 'GRAD' 0, 'opsz' 24;
        }
    </style>
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
        .spinner {
            width: 50px;
            height: 50px;
            border: 5px solid #e0e3e6;
            border-top: 5px solid #00628c;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>
    
    <!-- Theme Initialization Script -->
    <script>
        // On page load or when changing themes, best to add inline in `head` to avoid FOUC
        if (localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
    
    @stack('css')
</head>
<body class="bg-background text-on-background font-body-md antialiased pt-16 min-h-screen flex flex-col">
    <!-- Loading Overlay -->
    <div id="loading-overlay">
        <div class="flex flex-col items-center">
            <div class="spinner mb-3"></div>
            <p class="font-label-bold text-primary animate-pulse">Mohon Tunggu...</p>
        </div>
    </div>

    @include('frontend.layouts.navbar')

    @yield('content')

    @include('frontend.layouts.footer')

    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // --- SweetAlert2 Handler ---
            @if(session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: "{{ session('success') }}",
                    timer: 3000,
                    showConfirmButton: false,
                    confirmButtonColor: '#00628c'
                });
            @endif

            @if(session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: "{{ session('error') }}",
                    confirmButtonColor: '#00628c'
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
                    
                    if (href && href !== '#' && !href.startsWith('#') && !href.startsWith('javascript') && target !== '_blank' && !this.hasAttribute('download')) {
                        showLoading();
                    }
                });
            });

            // --- Theme Toggler Logic ---
            const themeToggleDesktop = document.getElementById('theme-toggle-desktop');
            const themeToggleMobile = document.getElementById('theme-toggle-mobile');

            function updateThemeIcons() {
                const isDark = document.documentElement.classList.contains('dark');
                const darkIcons = document.querySelectorAll('.theme-icon-dark');
                const lightIcons = document.querySelectorAll('.theme-icon-light');

                if (isDark) {
                    darkIcons.forEach(icon => icon.style.display = 'none');
                    lightIcons.forEach(icon => icon.style.display = 'block');
                } else {
                    darkIcons.forEach(icon => icon.style.display = 'block');
                    lightIcons.forEach(icon => icon.style.display = 'none');
                }
            }

            function toggleTheme() {
                if (document.documentElement.classList.contains('dark')) {
                    document.documentElement.classList.remove('dark');
                    localStorage.setItem('color-theme', 'light');
                } else {
                    document.documentElement.classList.add('dark');
                    localStorage.setItem('color-theme', 'dark');
                }
                updateThemeIcons();
            }

            if (themeToggleDesktop) themeToggleDesktop.addEventListener('click', toggleTheme);
            if (themeToggleMobile) themeToggleMobile.addEventListener('click', toggleTheme);

            // Set initial icons state
            updateThemeIcons();
        });
    </script>
    @stack('scripts')
</body>
</html>
