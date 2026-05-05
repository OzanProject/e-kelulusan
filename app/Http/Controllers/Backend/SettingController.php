<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('backend.settings.index', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();

        $request->validate([
            'school_name'    => 'required|string|max:255',
            'school_address_city' => 'required|string|max:100',
            'school_logo'    => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'principal_name' => 'required|string|max:255',
            'principal_nip'  => 'nullable|string|max:50',
            'kop_surat'      => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'signature'      => 'nullable|image|mimes:png|max:1024',
            'stamp'          => 'nullable|image|mimes:png|max:1024',
            'skl_template'   => 'required|string',
            'skl_closing'    => 'required|string',
            'skl_footer'     => 'required|string',
            'skl_number_format' => 'required|string',
            'signature_type' => 'required|in:qr,manual',
            'contact_email'  => 'nullable|email|max:255',
            'contact_phone'  => 'nullable|string|max:50',
            'contact_address'=> 'nullable|string',
        ]);

        $data = [
            'school_name'    => $request->school_name,
            'school_address_city' => $request->school_address_city,
            'principal_name' => $request->principal_name,
            'principal_nip'  => $request->principal_nip,
            'skl_template'   => $request->skl_template,
            'skl_closing'    => $request->skl_closing,
            'skl_footer'     => $request->skl_footer,
            'skl_number_format' => $request->skl_number_format,
            'signature_type' => $request->signature_type,
            'contact_email'  => $request->contact_email,
            'contact_phone'  => $request->contact_phone,
            'contact_address'=> $request->contact_address,
        ];

        // Handle Uploads
        if ($request->hasFile('school_logo')) {
            if ($setting->school_logo) Storage::disk('public')->delete($setting->school_logo);
            $data['school_logo'] = $request->file('school_logo')->store('assets/skl', 'public');
        }

        if ($request->hasFile('kop_surat')) {
            if ($setting->kop_surat) Storage::disk('public')->delete($setting->kop_surat);
            $data['kop_surat'] = $request->file('kop_surat')->store('assets/skl', 'public');
        }

        if ($request->hasFile('signature')) {
            if ($setting->signature) Storage::disk('public')->delete($setting->signature);
            $data['signature'] = $request->file('signature')->store('assets/skl', 'public');
        }

        if ($request->hasFile('stamp')) {
            if ($setting->stamp) Storage::disk('public')->delete($setting->stamp);
            $data['stamp'] = $request->file('stamp')->store('assets/skl', 'public');
        }

        if ($setting->exists) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return redirect()->route('admin.settings.index')->with('success', 'Pengaturan Identitas & SKL berhasil diperbarui!');
    }
}
