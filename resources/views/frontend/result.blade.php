@extends('frontend.layouts.app')

@section('title', 'Hasil Kelulusan - ' . $student->nama_lengkap)

@section('content')

<!-- Result Banner Header -->
<header class="w-full bg-surface-container-low border-b border-outline-variant py-8 px-gutter">
    <div class="max-w-container-max mx-auto text-center">
        <h2 class="font-headline-lg text-headline-lg text-on-surface mb-1">Informasi Kelulusan Siswa</h2>
        <p class="font-body-md text-body-md text-on-surface-variant">Tahun Ajaran {{ date('Y') - 1 }}/{{ date('Y') }}</p>
    </div>
</header>

<!-- Main Result Content -->
<main class="w-full max-w-[900px] mx-auto px-gutter py-section-padding space-y-8">

    <!-- Status Card -->
    <div class="bg-surface-container-lowest rounded border border-outline-variant shadow-[0_8px_30px_rgb(0,0,0,0.05)] overflow-hidden text-center">
        
        <div class="p-8 {{ $student->status_kelulusan == 'lulus' ? 'bg-[#f0fdf4] border-b border-[#bbf7d0]' : ($student->status_kelulusan == 'tidak_lulus' ? 'bg-[#fef2f2] border-b border-[#fecaca]' : 'bg-[#fefce8] border-b border-[#fef08a]') }}">
            
            @if($student->status_kelulusan == 'lulus')
                <span class="material-symbols-outlined text-[80px] text-[#16a34a] drop-shadow-sm mb-4">verified</span>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-4">Selamat, Anda Dinyatakan:</h3>
                <div class="inline-flex items-center gap-2 bg-[#dcfce7] text-[#166534] border-2 border-[#bbf7d0] px-8 py-3 rounded-full font-headline-md text-headline-md shadow-sm mb-4">
                    <span class="material-symbols-outlined">workspace_premium</span>
                    LULUS
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-[600px] mx-auto">
                    {{ $setting->result_greeting ?? 'Perjuangan dan kerja keras Anda telah membuahkan hasil. Teruslah berkarya dan gapai cita-cita setinggi mungkin!' }}
                </p>
            @elseif($student->status_kelulusan == 'tidak_lulus')
                <span class="material-symbols-outlined text-[80px] text-[#dc2626] drop-shadow-sm mb-4">cancel</span>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-4">Mohon Maaf, Anda Dinyatakan:</h3>
                <div class="inline-flex items-center gap-2 bg-[#fee2e2] text-[#991b1b] border-2 border-[#fecaca] px-8 py-3 rounded-full font-headline-md text-headline-md shadow-sm mb-4">
                    <span class="material-symbols-outlined">block</span>
                    TIDAK LULUS
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-[600px] mx-auto">
                    Jangan patah semangat. Kegagalan hari ini adalah pelajaran berharga untuk kesuksesan di masa depan.
                </p>
            @else
                <span class="material-symbols-outlined text-[80px] text-[#ca8a04] drop-shadow-sm mb-4">pending</span>
                <h3 class="font-headline-lg text-headline-lg text-on-surface mb-4">Status Anda Saat Ini:</h3>
                <div class="inline-flex items-center gap-2 bg-[#fef9c3] text-[#854d0e] border-2 border-[#fde047] px-8 py-3 rounded-full font-headline-md text-headline-md shadow-sm mb-4">
                    <span class="material-symbols-outlined">hourglass_empty</span>
                    DITUNDA
                </div>
                <p class="font-body-md text-body-md text-on-surface-variant max-w-[600px] mx-auto">
                    Silakan hubungi pihak sekolah atau wali kelas untuk informasi lebih lanjut mengenai status Anda.
                </p>
            @endif

        </div>

        <div class="p-card-padding text-left">
            
            <h4 class="font-headline-md text-[20px] font-semibold text-on-surface border-b border-outline-variant pb-2 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">person</span> Biodata Siswa
            </h4>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="bg-surface-container-low p-4 rounded border border-outline-variant">
                    <div class="font-label-sm text-label-sm text-outline mb-1">Nama Lengkap</div>
                    <div class="font-body-lg text-body-lg text-on-surface font-semibold">{{ $student->nama_lengkap }}</div>
                </div>
                <div class="bg-surface-container-low p-4 rounded border border-outline-variant">
                    <div class="font-label-sm text-label-sm text-outline mb-1">NISN / NIS</div>
                    <div class="font-body-lg text-body-lg text-on-surface font-semibold">{{ $student->nisn }} <span class="text-outline font-normal">/</span> {{ $student->nomor_peserta }}</div>
                </div>
            </div>

            <h4 class="font-headline-md text-[20px] font-semibold text-on-surface border-b border-outline-variant pb-2 mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-primary">school</span> Detail Transkrip Nilai
            </h4>

            <div class="overflow-x-auto rounded border border-outline-variant mb-8">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface-container-low border-b border-outline-variant">
                            <th class="py-3 px-4 font-label-bold text-label-bold text-on-surface-variant w-[10%] text-center border-r border-outline-variant">NO</th>
                            <th class="py-3 px-4 font-label-bold text-label-bold text-on-surface-variant w-[70%] border-r border-outline-variant">MATA PELAJARAN</th>
                            <th class="py-3 px-4 font-label-bold text-label-bold text-on-surface-variant w-[20%] text-center">NILAI</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-outline-variant">
                        @php $i = 1; @endphp
                        @foreach($subjects as $s)
                            <tr class="hover:bg-surface-container-low transition-colors">
                                <td class="py-3 px-4 font-body-md text-body-md text-outline text-center border-r border-outline-variant">{{ $i++ }}</td>
                                <td class="py-3 px-4 font-body-md text-body-md text-on-surface border-r border-outline-variant">{{ $s->nama }}</td>
                                <td class="py-3 px-4 font-label-bold text-label-bold text-primary text-center">
                                    {{ is_numeric($student->nilai_ujian[$s->kode] ?? null) ? $student->nilai_ujian[$s->kode] : '-' }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-surface-container-low border-t-2 border-outline-variant">
                        <tr>
                            <td colspan="2" class="py-4 px-4 font-label-bold text-label-bold text-on-surface text-right border-r border-outline-variant">TOTAL NILAI (TTL):</td>
                            <td class="py-4 px-4 font-headline-md text-[20px] font-bold text-on-surface text-center">
                                {{ $student->nilai_ujian['TTL'] ?? '-' }}
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="flex flex-col sm:flex-row justify-between gap-4 mt-8 pt-6 border-t border-outline-variant">
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center gap-2 bg-surface-container-high text-on-surface rounded px-6 py-2.5 font-label-bold text-label-bold hover:bg-surface-variant border border-outline-variant transition-colors shadow-sm">
                    <span class="material-symbols-outlined">arrow_back</span> Kembali
                </a>
                
                @if($student->status_kelulusan == 'lulus')
                    {{-- Button Cetak SKL --}}
                    <a href="{{ route('download.skl', $student->id) }}" class="inline-flex items-center justify-center gap-2 bg-primary text-on-primary rounded px-6 py-2.5 font-label-bold text-label-bold hover:bg-surface-tint transition-colors shadow-sm">
                        <span class="material-symbols-outlined">print</span> Cetak SKL (PDF)
                    </a>
                @endif
            </div>

        </div>
    </div>
</main>
@endsection
