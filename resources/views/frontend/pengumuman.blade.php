@extends('frontend.layouts.app')

@section('title', 'Informasi Pengumuman')

@section('content')
<main class="w-full max-w-[800px] mx-auto px-gutter py-section-padding space-y-8 flex-grow">
    
    <div class="text-center mb-8">
        <h1 class="font-headline-xl text-headline-xl text-on-surface mb-2">Informasi Pengumuman</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Kumpulan informasi resmi dari pihak sekolah.</p>
    </div>

    <!-- Announcements Timeline -->
    <div class="bg-surface-container-lowest rounded border border-outline-variant border-t-[3px] border-t-primary shadow-[0_2px_10px_rgb(0,0,0,0.02)] p-card-padding">
        <div class="flex items-center gap-2 mb-6">
            <span class="material-symbols-outlined text-primary" data-icon="event_note">event_note</span>
            <h3 class="font-headline-md text-headline-md text-on-surface">Jadwal &amp; Agenda Lanjutan</h3>
        </div>
        <div class="prose prose-blue max-w-none mb-8">
            {!! nl2br(e($school_setting->announcement_content ?? 'Selamat kepada seluruh siswa kelas XII yang telah menempuh ujian akhir. Hasil kelulusan dapat dicek secara mandiri melalui portal ini.')) !!}
        </div>
        
        @php
            $agendas = is_array($school_setting->agendas) ? $school_setting->agendas : [];
        @endphp
        
        <div class="relative border-l-2 border-surface-variant ml-4 space-y-8 pb-4">
            <!-- Timeline Item 1 (Fixed) -->
            <div class="relative pl-6">
                <span class="absolute -left-[11px] top-1 w-5 h-5 rounded-full bg-primary border-4 border-surface-container-lowest shadow-sm"></span>
                <h4 class="font-headline-lg text-[20px] font-semibold text-on-surface mb-1">Pengumuman Online</h4>
                <span class="inline-block bg-surface-container-high px-2 py-1 rounded font-label-sm text-label-sm text-on-surface-variant mb-2">{{ $school_setting->announcement_date ? $school_setting->announcement_date->format('d M Y') : 'TBA' }}</span>
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
</main>
@endsection
