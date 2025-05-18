@if ($errors->any() && session('editing_visitor_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'visitorModalEdit-' + {{ session('editing_visitor_id') }};
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
            const modalId = 'visitorModal';
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
        document.getElementById('iframePDF').src = '{{ route('listado.visitadores') }}';
        document.getElementById('modalPDF').classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>
