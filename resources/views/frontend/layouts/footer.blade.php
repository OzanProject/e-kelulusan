<!-- Footer Component -->
<footer class="bg-white dark:bg-gray-900 w-full py-8 px-10 flex flex-col md:flex-row justify-between items-center gap-4 border-t border-gray-200 dark:border-gray-800 mt-auto">
    <div class="font-bold text-gray-700 dark:text-gray-300">
        {{ $setting->school_name ?? 'Graduation Portal' }}
    </div>
    <div class="font-['Public_Sans'] text-xs text-gray-500 dark:text-gray-400 text-center md:text-left">
        &copy; {{ date('Y') }} {{ $setting->school_name ?? 'Educational Institution' }}. All Rights Reserved.
    </div>
    <div class="flex gap-4">
        @if(!empty($setting->facebook))
            <a class="font-['Public_Sans'] text-xs text-gray-500 dark:text-gray-400 hover:text-[#3c8dbc] dark:hover:text-blue-400 underline transition-all transition-opacity duration-150" href="{{ $setting->facebook }}" target="_blank">Facebook</a>
        @endif
        @if(!empty($setting->instagram))
            <a class="font-['Public_Sans'] text-xs text-gray-500 dark:text-gray-400 hover:text-[#3c8dbc] dark:hover:text-blue-400 underline transition-all transition-opacity duration-150" href="{{ $setting->instagram }}" target="_blank">Instagram</a>
        @endif
        @if(!empty($setting->youtube))
            <a class="font-['Public_Sans'] text-xs text-gray-500 dark:text-gray-400 hover:text-[#3c8dbc] dark:hover:text-blue-400 underline transition-all transition-opacity duration-150" href="{{ $setting->youtube }}" target="_blank">YouTube</a>
        @endif
    </div>
</footer>
