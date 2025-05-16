@if ($errors->any() && session('editing_visitor_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'visitorModalEdit-' + {{ session('editing_visitor_id') }};
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
            const modalId = 'visitorModal';
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    </script>
@endif
