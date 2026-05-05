<aside class="app-sidebar bg-body-secondary shadow" data-bs-theme="dark">
    <!-- Sidebar Brand -->
    <div class="sidebar-brand">
        <a href="{{ route('admin.dashboard') }}" class="brand-link">
            @if($school_setting && $school_setting->school_logo)
                <img src="{{ asset('storage/' . $school_setting->school_logo) }}" alt="Logo" class="brand-image opacity-75 shadow rounded-circle">
            @else
                <img src="{{ asset('adminlte/dist/assets/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image opacity-75 shadow">
            @endif
            <span class="brand-text fw-light text-truncate" style="max-width: 150px; display: inline-block;">
                {{ $school_setting->school_name ?? 'E-Kelulusan' }}
            </span>
        </a>
    </div>

    <!-- Sidebar -->
    <div class="sidebar-wrapper">
        <nav class="mt-2">
            <!-- Sidebar Menu -->
            <ul class="nav sidebar-menu flex-column" data-lte-toggle="treeview" role="menu" data-accordion="false">
                
                <li class="nav-item">
                    <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-speedometer2"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">DATA AKADEMIK</li>

                <li class="nav-item">
                    <a href="{{ route('admin.subjects.index') }}" class="nav-link {{ request()->routeIs('admin.subjects.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-bookmark-fill"></i>
                        <p>Mata Pelajaran</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.students.index') }}" class="nav-link {{ request()->routeIs('admin.students.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-people-fill"></i>
                        <p>Data Siswa & Nilai</p>
                    </a>
                </li>

                <li class="nav-header">KONTEN & PORTAL</li>

                <li class="nav-item">
                    <a href="{{ route('admin.landingpage.index') }}" class="nav-link {{ request()->routeIs('admin.landingpage.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-window-desktop"></i>
                        <p>Landing Page</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.announcements.index') }}" class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-clock-history"></i>
                        <p>Waktu Pengumuman</p>
                    </a>
                </li>

                <li class="nav-header">PENGATURAN SISTEM</li>

                @if(auth()->user()->role === 'admin')
                <li class="nav-item">
                    <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-person-lock"></i>
                        <p>Manajemen Pengguna</p>
                    </a>
                </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-gear-fill"></i>
                        <p>Identitas & SKL</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('admin.reports.logs') }}" class="nav-link {{ request()->routeIs('admin.reports.logs') ? 'active' : '' }}">
                        <i class="nav-icon bi bi-journal-text"></i>
                        <p>Log Akses Siswa</p>
                    </a>
                </li>

                <li class="nav-item mt-4 border-top pt-2">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <a href="javascript:void(0)" onclick="document.getElementById('logout-form').submit()" class="nav-link text-danger">
                            <i class="nav-icon bi bi-box-arrow-right"></i>
                            <p>Keluar Aplikasi</p>
                        </a>
                    </form>
                </li>

            </ul>
        </nav>
    </div>
</aside>
