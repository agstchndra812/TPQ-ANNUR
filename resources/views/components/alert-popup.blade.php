<!-- SweetAlert2 CDN -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<!-- Toast Notification Script -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Toast configuration
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer);
                toast.addEventListener('mouseleave', Swal.resumeTimer);
            }
        });

        @if(session('success'))
            Toast.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                background: '#10b981',
                color: '#ffffff'
            });
        @endif

        @if(session('error'))
            Toast.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                background: '#ef4444',
                color: '#ffffff',
                timer: 4000
            });
        @endif

        @if(session('warning'))
            Toast.fire({
                icon: 'warning',
                title: 'Perhatian!',
                text: '{{ session('warning') }}',
                background: '#f59e0b',
                color: '#ffffff',
                timer: 4000
            });
        @endif

        @if(session('info'))
            Toast.fire({
                icon: 'info',
                title: 'Informasi',
                text: '{{ session('info') }}',
                background: '#3b82f6',
                color: '#ffffff'
            });
        @endif

        @if($errors->any())
            // For validation errors, show as regular popup (not toast) for better visibility
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                html: '<div class="text-left"><p class="mb-2">Mohon periksa kembali input Anda:</p><ul class="list-disc list-inside text-sm">@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul></div>',
                confirmButtonText: 'OK',
                confirmButtonColor: '#dc2626',
                position: 'center',
                showClass: {
                    popup: 'animate__animated animate__fadeInDown animate__faster'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOutUp animate__faster'
                }
            });
        @endif
    });
</script>

<!-- Custom Toast Styles -->
<style>
    .swal2-toast {
        padding: 0.75rem 1rem !important;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
        border-radius: 0.5rem !important;
        font-size: 0.875rem !important;
    }
    
    .swal2-toast .swal2-title {
        font-size: 1rem !important;
        font-weight: 600 !important;
        margin: 0 0 0.25rem 0 !important;
    }
    
    .swal2-toast .swal2-html-container {
        font-size: 0.875rem !important;
        margin: 0 !important;
    }
    
    .swal2-toast .swal2-icon {
        width: 2rem !important;
        height: 2rem !important;
        margin: 0 0.75rem 0 0 !important;
    }
    
    .swal2-toast .swal2-timer-progress-bar {
        background: rgba(255, 255, 255, 0.5) !important;
    }
</style>
