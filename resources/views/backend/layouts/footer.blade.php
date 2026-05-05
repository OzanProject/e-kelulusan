<footer class="app-footer">
    <!-- To the right -->
    <div class="float-end d-none d-sm-inline">
        <a href="https://ozanproject.site" target="_blank" class="text-decoration-none">Ozan Project</a>
    </div>
    <!-- Default to the left -->
    <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}">{{ $school_setting->school_name ?? 'E-Kelulusan' }}</a>.</strong> Hak Cipta Dilindungi.
</footer>
