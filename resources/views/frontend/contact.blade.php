@extends('frontend.layouts.app')

@section('title', 'Kontak Panitia')

@section('content')
<main class="w-full max-w-[800px] mx-auto px-gutter py-section-padding space-y-8 flex-grow">
    
    <div class="text-center mb-8">
        <h1 class="font-headline-xl text-headline-xl text-on-surface mb-2">Pusat Bantuan</h1>
        <p class="font-body-md text-body-md text-on-surface-variant">Hubungi kami jika Anda memiliki kendala teknis atau pertanyaan akademik.</p>
    </div>

    <!-- Info Card -->
    <div class="bg-surface-container-lowest rounded border border-outline-variant p-card-padding shadow-[0_2px_10px_rgb(0,0,0,0.02)]">
        <h4 class="font-headline-md text-headline-md text-on-surface border-b border-outline-variant pb-3 mb-6">Kontak Panitia Kelulusan</h4>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex items-start gap-3 p-4 bg-surface-container-low rounded border border-outline-variant">
                <span class="material-symbols-outlined text-primary text-[32px]" data-icon="support_agent">support_agent</span>
                <div>
                    <p class="font-label-bold text-label-bold text-on-surface mb-1">Helpdesk Akademik</p>
                    <p class="font-body-md text-body-md text-on-surface-variant">Senin - Jumat<br>08:00 - 15:00 WIB</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 bg-surface-container-low rounded border border-outline-variant">
                <span class="material-symbols-outlined text-primary text-[32px]" data-icon="mail">mail</span>
                <div>
                    <p class="font-label-bold text-label-bold text-on-surface mb-1">Email Resmi</p>
                    <p class="font-body-md text-body-md text-on-surface-variant text-primary font-semibold">{{ $school_setting->contact_email ?? 'info@' . strtolower(str_replace(' ', '', $school_setting->school_name ?? 'sekolah')) . '.sch.id' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 bg-surface-container-low rounded border border-outline-variant">
                <span class="material-symbols-outlined text-primary text-[32px]" data-icon="call">call</span>
                <div>
                    <p class="font-label-bold text-label-bold text-on-surface mb-1">Telepon / HP Panitia</p>
                    <p class="font-body-md text-body-md text-on-surface-variant">{{ $school_setting->contact_phone ?? '(021) 12345678' }}</p>
                </div>
            </div>

            <div class="flex items-start gap-3 p-4 bg-surface-container-low rounded border border-outline-variant">
                <span class="material-symbols-outlined text-primary text-[32px]" data-icon="location_on">location_on</span>
                <div>
                    <p class="font-label-bold text-label-bold text-on-surface mb-1">Alamat Sekolah</p>
                    <p class="font-body-md text-body-md text-on-surface-variant">{!! nl2br(e($school_setting->contact_address ?? ($school_setting->school_name ?? 'Gedung Sekolah Utama') . "\nJl. Pendidikan No. 1, Kota")) !!}</p>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
