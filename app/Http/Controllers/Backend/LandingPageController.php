<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LandingPageController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('backend.settings.landingpage', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();

        $request->validate([
            'hero_title' => 'nullable|string|max:255',
            'hero_description' => 'nullable|string',
            'hero_background' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
            'principal_message' => 'nullable|string',
            'principal_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'helpdesk_time' => 'nullable|string|max:255',
            'email_panitia' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'phone' => 'nullable|string|max:50',
            'facebook' => 'nullable|url|max:255',
            'instagram' => 'nullable|url|max:255',
            'youtube' => 'nullable|url|max:255',
            'agendas' => 'nullable|array',
        ]);

        $data = $request->only([
            'hero_title',
            'hero_description',
            'principal_message',
            'helpdesk_time',
            'email_panitia',
            'phone',
            'phone',
            'facebook',
            'instagram',
            'youtube',
            'agendas'
        ]);

        if ($request->hasFile('hero_background')) {
            if ($setting->hero_background) {
                Storage::disk('public')->delete($setting->hero_background);
            }
            $data['hero_background'] = $request->file('hero_background')->store('assets/hero', 'public');
        }

        if ($request->hasFile('principal_photo')) {
            if ($setting->principal_photo) {
                Storage::disk('public')->delete($setting->principal_photo);
            }
            $data['principal_photo'] = $request->file('principal_photo')->store('assets/principal', 'public');
        }

        if ($setting->exists) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return redirect()->route('admin.landingpage.index')->with('success', 'Konten Landing Page berhasil diperbarui!');
    }
}
