@if ($errors->any() && session('editing_zone_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'zonaModalEdit-' + {{ session('editing_zone_id') }};
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    </script>
@endif

@if ($errors->any())
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'zonaModal';
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    </script>
@endif
