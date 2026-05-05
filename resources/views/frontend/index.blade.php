@extends('frontend.layouts.app')

@section('title', 'Cek Kelulusan')

@section('content')

<!-- Hero Section -->
<header class="relative w-full h-[450px] flex items-center justify-center bg-inverse-surface overflow-hidden">
    @php
        $heroBg = $setting->hero_background 
            ? asset('storage/' . $setting->hero_background)
            : 'https://lh3.googleusercontent.com/aida-public/AB6AXuBGhj64vfQnLVsPjWtgyrLghRhV5h9gzyFXzvbYq4P1SWmLG3fegKnKhzFyf3Dbfze48W0tsoTYYrpfd8mTEJb6QJ9xv8JiLl_iKq3PO4nFk2ClF8so5U2AYJ3SyGEJ5Oy-o6dXAi3FBpo8Ze4KjqcyZ9WUjRqMNXHxhLWLeIgCp7Rqmiry3kp7lr3fhDnZ_rXg4Afb0C8q4KNDStYwo8R8t_hQlmkWiu6H9T4zTQQj68D6FocWW_Imo8OAM54oxJ4OUlb0SMvCngxX';
    @endphp
    <div class="absolute inset-0 bg-cover bg-center opacity-40 mix-blend-overlay" style="background-image: url('{{ $heroBg }}');"></div>
    <div class="relative z-10 text-center px-gutter w-full max-w-container-max mx-auto flex flex-col items-center">
        
        @if($setting->announcement_status && $isOpened)
            <div class="bg-primary/20 backdrop-blur-md border border-primary/30 px-4 py-1.5 rounded-full mb-6 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-[#c8e6ff] animate-pulse"></span>
                <span class="font-label-bold text-label-bold text-on-primary">Pengumuman Resmi Aktif</span>
            </div>
        @else
            <div class="bg-red-500/20 backdrop-blur-md border border-red-500/30 px-4 py-1.5 rounded-full mb-6 flex items-center gap-2">
                <span class="w-2 h-2 rounded-full bg-red-200"></span>
                <span class="font-label-bold text-label-bold text-white">Portal Masih Ditutup</span>
            </div>
        @endif
        
        <h1 class="font-headline-xl text-headline-xl text-on-primary mb-4 drop-shadow-md">{{ $setting->hero_title ?? 'Selamat & Sukses! Pengumuman Kelulusan Angkatan ' . date('Y') }}</h1>
        <p class="font-body-lg text-body-lg text-surface-container-low max-w-2xl drop-shadow">{{ $setting->hero_description ?? 'Akses hasil kelulusan, jadwal pengambilan dokumen, dan informasi purna studi melalui portal ini.' }}</p>
    </div>
</header>

<!-- Check Status Form -->
<section class="relative z-20 -mt-12 px-gutter w-full max-w-[800px] mx-auto mb-section-padding">
    <div class="bg-surface-container-lowest rounded border border-outline-variant border-t-[3px] border-t-primary shadow-[0_8px_30px_rgb(0,0,0,0.08)] p-card-padding">
        
        @if(session('error'))
            <div class="bg-error-container text-on-error-container p-3 rounded mb-4 flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                <span class="font-body-md">{{ session('error') }}</span>
            </div>
        @endif

        @if(!$setting->announcement_status || !$isOpened)
            
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2 text-center">Portal Belum Dibuka</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6 text-center">Akses pengecekan kelulusan saat ini ditutup oleh Administrator.</p>
            
            @if($setting->announcement_date && $setting->announcement_status)
                <div class="border-t border-outline-variant pt-4 text-center">
                    <p class="font-label-bold text-primary mb-3">Pengumuman akan dibuka dalam:</p>
                    <div class="flex justify-center gap-4" id="countdown">
                        <div class="bg-surface-container-low p-3 rounded text-center min-w-[70px]">
                            <div class="font-headline-lg text-on-surface" id="days">00</div>
                            <div class="font-label-sm text-outline">HARI</div>
                        </div>
                        <div class="bg-surface-container-low p-3 rounded text-center min-w-[70px]">
                            <div class="font-headline-lg text-on-surface" id="hours">00</div>
                            <div class="font-label-sm text-outline">JAM</div>
                        </div>
                        <div class="bg-surface-container-low p-3 rounded text-center min-w-[70px]">
                            <div class="font-headline-lg text-on-surface" id="mins">00</div>
                            <div class="font-label-sm text-outline">MENIT</div>
                        </div>
                        <div class="bg-surface-container-low p-3 rounded text-center min-w-[70px]">
                            <div class="font-headline-lg text-primary" id="secs">00</div>
                            <div class="font-label-sm text-outline">DETIK</div>
                        </div>
                    </div>
                </div>
            @endif

        @else
            
            <h2 class="font-headline-md text-headline-md text-on-surface mb-2">{{ $setting->search_title ?? 'Masukkan NISN / Nomor Peserta Anda' }}</h2>
            <p class="font-body-md text-body-md text-on-surface-variant mb-6">{{ $setting->search_description ?? 'Silakan gunakan Nomor Induk Siswa Nasional atau Nomor Peserta yang terdaftar pada sistem.' }}</p>
            
            <form action="{{ route('cek.kelulusan') }}" method="POST">
                @csrf
                <div class="flex flex-col sm:flex-row gap-4">
                    <div class="relative flex-1">
                        <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline" data-icon="badge">badge</span>
                        <input name="nomor_peserta" class="w-full rounded border border-outline-variant py-3 pl-12 pr-4 font-body-md text-body-md text-on-surface bg-surface-container-lowest focus:outline-none focus:ring-2 focus:ring-primary/25 focus:border-primary transition-all @error('nomor_peserta') border-error @enderror" placeholder="Contoh: 0115990404 atau 232407025" type="text" value="{{ old('nomor_peserta') }}" required autocomplete="off"/>
                        @error('nomor_peserta')
                            <p class="text-error font-label-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <button type="submit" class="bg-primary text-on-primary rounded px-8 py-3 font-label-bold text-label-bold hover:bg-surface-tint transition-colors flex items-center justify-center gap-2 whitespace-nowrap shadow-sm h-[48px]">
                        <span class="material-symbols-outlined" data-icon="search" data-weight="fill" style="font-variation-settings: 'FILL' 1;">search</span>
                        Cek Status
                    </button>
                </div>
            </form>

        @endif
    </div>
</section>

<!-- Main Content Area -->
<main class="w-full max-w-container-max mx-auto px-gutter pb-section-padding grid grid-cols-1 lg:grid-cols-12 gap-8">
    <!-- Left Column (Message & Timeline) -->
    <div class="lg:col-span-8 space-y-8">
        <!-- Principal Message -->
        <div class="bg-surface-container-lowest rounded border border-outline-variant p-card-padding shadow-[0_2px_10px_rgb(0,0,0,0.02)] flex flex-col md:flex-row gap-6">
            <div class="w-32 h-32 rounded bg-surface-variant flex-shrink-0 overflow-hidden border border-outline-variant flex items-center justify-center">
                @if($setting->principal_photo)
                    <img src="{{ asset('storage/' . $setting->principal_photo) }}" class="w-full h-full object-cover" alt="Foto Kepala Sekolah">
                @else
                    <span class="material-symbols-outlined text-[64px] text-outline">account_circle</span>
                @endif
            </div>
            <div>
                <h3 class="font-headline-md text-headline-md text-on-surface mb-2">Pesan Kepala Sekolah</h3>
                <p class="font-body-md text-body-md text-on-surface-variant mb-4">{{ $setting->principal_message ?? '"Selamat kepada seluruh siswa kelas akhir yang telah menyelesaikan masa studi. Pengumuman ini merupakan awal dari perjalanan panjang kalian menuju kesuksesan. Jadilah lulusan yang berintegritas, inovatif, dan membawa nama baik almamater di manapun berada."' }}</p>
                <p class="font-label-bold text-label-bold text-primary">{{ $setting->principal_name ?? 'Kepala Sekolah' }}</p>
                <p class="font-label-sm text-label-sm text-outline">Kepala Sekolah</p>
            </div>
        </div>

        <!-- Announcements Timeline (Milestones) -->
        <div class="bg-surface-container-lowest rounded border border-outline-variant border-t-[3px] border-t-primary shadow-[0_2px_10px_rgb(0,0,0,0.02)] p-card-padding">
            <div class="flex items-center gap-2 mb-6">
                <span class="material-symbols-outlined text-primary" data-icon="event_note">event_note</span>
                <h3 class="font-headline-md text-headline-md text-on-surface">Jadwal &amp; Agenda Lanjutan</h3>
            </div>
            
            @php
                $agendas = is_array($setting->agendas) ? $setting->agendas : [];
            @endphp
            
            <div class="relative border-l-2 border-surface-variant ml-4 space-y-8 pb-4">
                <!-- Timeline Item 1 (Fixed) -->
                <div class="relative pl-6">
                    <span class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-primary border-4 border-surface-container-lowest shadow-sm"></span>
                    <h4 class="font-headline-lg text-[20px] font-semibold text-on-surface mb-1">Pengumuman Online</h4>
                    <span class="inline-block bg-surface-container-high px-2 py-1 rounded font-label-sm text-label-sm text-on-surface-variant mb-2">{{ $setting->announcement_date ? $setting->announcement_date->format('d M Y') : 'TBA' }}</span>
                    <p class="font-body-md text-body-md text-on-surface-variant">Akses hasil kelulusan dibuka serentak melalui portal ini. Siswa diwajibkan mencetak Surat Keterangan Lulus (SKL) sementara.</p>
                </div>

                @foreach($agendas as $agenda)
                <div class="relative pl-6">
                    <span class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-surface-variant border-4 border-surface-container-lowest shadow-sm"></span>
                    <h4 class="font-headline-lg text-[20px] font-semibold text-on-surface mb-1">{{ $agenda['title'] ?? '-' }}</h4>
                    <span class="inline-block bg-surface-container-high px-2 py-1 rounded font-label-sm text-label-sm text-on-surface-variant mb-2">{{ $agenda['date'] ?? '-' }}</span>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ $agenda['desc'] ?? '' }}</p>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Right Column (Stats & Info Cards) -->
    <div class="lg:col-span-4 space-y-4">
        <!-- Stat Card 1 -->
        @php
            $totalSiswa = \App\Models\Student::count();
            $lulus = \App\Models\Student::where('status_kelulusan', 'lulus')->count();
            $persentase = $totalSiswa > 0 ? round(($lulus / $totalSiswa) * 100, 1) : 0;
        @endphp
        <div class="bg-primary text-on-primary rounded p-card-padding flex items-center gap-4 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -bottom-4 opacity-20">
                <span class="material-symbols-outlined text-[100px]" data-icon="groups">groups</span>
            </div>
            <div class="bg-on-primary-fixed-variant/20 p-3 rounded">
                <span class="material-symbols-outlined text-[32px]" data-icon="school">school</span>
            </div>
            <div class="relative z-10">
                <p class="font-label-sm text-label-sm text-primary-fixed">Total Lulusan</p>
                <p class="font-headline-xl text-headline-xl">{{ $totalSiswa }}</p>
                <p class="font-label-sm text-label-sm mt-1">Siswa Angkatan {{ date('Y') }}</p>
            </div>
        </div>
        
        <!-- Stat Card 2 -->
        <div class="bg-surface-container-lowest rounded border border-outline-variant p-card-padding flex items-center gap-4 shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
            <div class="bg-surface-variant p-3 rounded text-on-surface-variant">
                <span class="material-symbols-outlined text-[32px]" data-icon="verified">verified</span>
            </div>
            <div class="w-full">
                <p class="font-label-sm text-label-sm text-outline">Persentase Kelulusan</p>
                <p class="font-headline-lg text-headline-lg text-on-surface">{{ $persentase }}%</p>
                <div class="w-full bg-surface-variant h-1.5 rounded-full mt-2">
                    <div class="bg-primary h-1.5 rounded-full" style="width: {{ $persentase }}%"></div>
                </div>
            </div>
        </div>

        <!-- Info Card -->
        <div class="bg-surface-container-lowest rounded border border-outline-variant p-card-padding shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
            <h4 class="font-label-bold text-label-bold text-on-surface mb-3 uppercase tracking-wider">Pusat Bantuan</h4>
            <ul class="space-y-3">
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-outline text-[20px] mt-0.5" data-icon="support_agent">support_agent</span>
                    <div>
                        <p class="font-label-bold text-label-bold text-on-surface">Helpdesk Akademik</p>
                        <p class="font-label-sm text-label-sm text-on-surface-variant">{{ $setting->helpdesk_time ?? 'Senin - Jumat, 08:00 - 15:00 WIB' }}</p>
                    </div>
                </li>
                <li class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-outline text-[20px] mt-0.5" data-icon="mail">mail</span>
                    <div>
                        <p class="font-label-bold text-label-bold text-on-surface">Email Panitia</p>
                        <p class="font-label-sm text-label-sm text-primary">{{ $setting->email_panitia ?? 'info@sekolah.sch.id' }}</p>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</main>

@push('scripts')
@if(!$isOpened && $setting->announcement_date && $setting->announcement_status)
<script>
    const targetDate = new Date("{{ $setting->announcement_date->format('Y-m-d H:i:s') }}").getTime();

    const countdownInterval = setInterval(function() {
        const now = new Date().getTime();
        const distance = targetDate - now;

        if (distance < 0) {
            clearInterval(countdownInterval);
            window.location.reload();
            return;
        }

        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        document.getElementById("days").innerHTML = days < 10 ? '0' + days : days;
        document.getElementById("hours").innerHTML = hours < 10 ? '0' + hours : hours;
        document.getElementById("mins").innerHTML = minutes < 10 ? '0' + minutes : minutes;
        document.getElementById("secs").innerHTML = seconds < 10 ? '0' + seconds : seconds;
    }, 1000);
</script>
@endif
@endpush

@endsection