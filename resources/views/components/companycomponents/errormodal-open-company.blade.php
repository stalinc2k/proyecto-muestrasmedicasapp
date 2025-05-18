@if ($errors->any() && session('editing_company_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'companyModalEdit-' + {{ session('editing_company_id') }};
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
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
                modal.classList.add('flex');
            }
        });
    </script>
@endif

<script>
    function abrirModalPDF() {
        document.getElementById('iframePDF').src = '{{ route('listado.empresas') }}';
        document.getElementById('modalPDF').classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>
