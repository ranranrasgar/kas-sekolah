@props([
    'show' => filter_var(session('show_notification', true), FILTER_VALIDATE_BOOLEAN),
    'title' => session('notification_title', 'Selamat Datang di Aplikasi SIMDIK Al-Hawari'),
    'message' => session('notification_message', 'Hi! Selamat bekerja..'),
])

<script>
    var showNotification = @json((bool) $show);
    var notificationTitle = @json($title);
    var notificationMessage = @json($message);
</script>
