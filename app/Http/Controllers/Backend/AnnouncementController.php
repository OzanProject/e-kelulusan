<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class AnnouncementController extends Controller
{
    public function index()
    {
        $setting = Setting::first() ?? new Setting();
        return view('backend.settings.announcement', compact('setting'));
    }

    public function update(Request $request)
    {
        $setting = Setting::first() ?? new Setting();

        $request->validate([
            'announcement_date' => 'required|date',
            'announcement_time' => 'required|date_format:H:i',
            'announcement_status' => 'required|boolean',
            'search_title' => 'nullable|string|max:255',
            'search_description' => 'nullable|string',
            'result_greeting' => 'nullable|string',
            'announcement_content' => 'nullable|string',
        ]);

        $dateTime = $request->announcement_date . ' ' . $request->announcement_time . ':00';

        $data = [
            'announcement_date'    => $dateTime,
            'announcement_status'  => $request->announcement_status,
            'search_title'         => $request->search_title,
            'search_description'   => $request->search_description,
            'result_greeting'      => $request->result_greeting,
            'announcement_content' => $request->announcement_content,
        ];

        if ($setting->exists) {
            $setting->update($data);
        } else {
            Setting::create($data);
        }

        return redirect()->route('admin.announcements.index')->with('success', 'Waktu & Konten Pengumuman berhasil diperbarui!');
    }
}
