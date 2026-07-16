@php
    $successMessage = session('success');
    $errorMessage = session('error');
    $validationErrors = $errors->any() ? collect($errors->all()) : collect();
@endphp

@if ($successMessage)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @js($successMessage),
                showConfirmButton: false,
                timer: 2200,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#0f172a',
                iconColor: '#4f46e5'
            });
        });
    </script>
@endif

@if ($errorMessage)
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'error',
                title: @js($errorMessage),
                showConfirmButton: false,
                timer: 2600,
                timerProgressBar: true,
                background: '#ffffff',
                color: '#0f172a',
                iconColor: '#e11d48'
            });
        });
    </script>
@endif

@if ($validationErrors->isNotEmpty())
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            window.Swal.fire({
                icon: 'error',
                title: 'Periksa kembali isian',
                html: @js('<ul class="swal2-list">' . $validationErrors->map(fn ($error) => '<li>' . e($error) . '</li>')->implode('') . '</ul>'),
                confirmButtonText: 'Tutup',
                confirmButtonColor: '#4f46e5',
                background: '#ffffff',
                color: '#0f172a'
            });
        });
    </script>
@endif