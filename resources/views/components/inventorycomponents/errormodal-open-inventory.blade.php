@if ($errors->any() && session('editing_inventory_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'inventoryModalEdit-' + {{ session('editing_inventory_id') }};
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
            const modalId = 'inventoryModal';
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
        document.getElementById('iframePDF').src = '{{ route('kardex.general') }}';
        document.getElementById('modalPDF').classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>
