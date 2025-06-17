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

@if ($errors->any() && session('create_visitor_id'))
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
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = 0;

            // Opcional: quitar el elemento del DOM después de la animación
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
    function cerrarModalPDF() {
        const modal = document.getElementById('modalPDF'); // <-- esta línea faltaba
        const iframe = document.getElementById('iframePDF');
        iframe.src = '';
        modal.classList.add('hidden');
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

    function abrirModalPDF() {
        const iframe = document.getElementById('iframePDF');
        const modal = document.getElementById('modalPDF');
        iframe.src = '{{ route('listado.visitadores') }}';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>