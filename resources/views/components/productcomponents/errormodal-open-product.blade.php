@if ($errors->any() && session('editing_product_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'productModalEdit-' + {{ session('editing_product_id') }};
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
            const modalId = 'productModal';
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
        document.getElementById('iframePDF').src = '{{ route('listado.productos') }}';
        document.getElementById('modalPDF').classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>
