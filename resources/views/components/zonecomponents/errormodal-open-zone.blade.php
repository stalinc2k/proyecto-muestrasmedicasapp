@if ($errors->any() && session('editing_zone_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'zonaModalEdit-' + {{ session('editing_zone_id') }};
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
            const modalId = 'zonaModal';
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
        document.getElementById('iframePDF').src = '{{ route('listado.zonas') }}';
        document.getElementById('modalPDF').classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModalPDF() {
        document.getElementById('iframePDF').src = '';
        document.getElementById('modalPDF').classList.add('hidden');
        modal.classList.remove('flex');
    }

    function mostrarModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function cerrarModal(id) {
        const modal = document.getElementById(id);
        modal.classList.remove('flex');
        modal.classList.add('hidden');
        location.reload();
    }

</script>
