@if ($errors->any() && session('editing_company_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'companyModalEdit-' + {{ session('editing_company_id') }};
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
            const modalId = 'companyModal';
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
            }
        });
    </script>
@endif
