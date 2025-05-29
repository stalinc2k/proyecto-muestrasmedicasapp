<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Cargar productos al seleccionar proveedor
    $('#company_id').on('change', function() {
        const companyID = $(this).val();
        if (companyID) {
            $.ajax({
                url: '/productos/' + companyID,
                type: 'GET',
                success: function(data) {
                    $('#producto').empty();
                    $('#producto').append('<option value="">Seleccione un producto</option>');
                    $.each(data, function(key, value) {
                        $('#producto').append('<option value="' + value.id + '">' + value
                            .description + '</option>');
                    });
                }
            });
            $(this).prop('disabled', true);
        } else {
            $('#producto').empty().append('<option value="">Seleccione un producto</option>');
        }
    });

    let productosAgregados = [];
    let contador = 0;

    $('#agregarProducto').on('click', function() {
        const companySelect = $('#company_id');
        const productSelect = $('#producto');
        const cantidadInput = $('#cantinventory');
        const loteInput = $('#codelot');
        const vencimientoInput = $('#finishlot');

        const companyId = companySelect.val();
        const companyText = companySelect.find('option:selected').text();

        const productId = productSelect.val();
        const productText = productSelect.find('option:selected').text();

        const loteId = loteInput.val();

        const vtoId = vencimientoInput.val();

        const cantidad = parseInt(cantidadInput.val());

        if (!companyId || !productId) {
            alert('Debe seleccionar proveedor y producto.');
            return;
        }

        if (cantidad < 1 || isNaN(cantidad)) {
            alert('La cantidad debe ser mayor a 0.');
            return;
        }
        
        if (loteId.length == 0 || !loteId.trim() === "") {
            alert('Ingrese Lote');
            return;
        }

        const key = companyId + '-' + productId;

        productosAgregados.push(key);
        const tbody = $('#tablaProductos tbody');
        const newRow = $(
            '<tr class="bg-blue-500 border-b border-blue-400 text-center"></tr>'
        );

        // Celdas visibles
        newRow.append('<td class="p-2">' + productText + '</td>');
        newRow.append('<td class="p-2">' + cantidad + '</td>');
        newRow.append('<td class="p-2">' + loteId + '</td>');
        newRow.append('<td class="p-2">' + vtoId + '</td>');

        // Botón de eliminar
        const btnEliminar = $(
            '<button type="button" class="bg-red-500 text-white p-2 rounded">Eliminar</button>');
        const actionCell = $('<td></td>').append(btnEliminar);
        newRow.append(actionCell);

        // Inputs ocultos con formato productos[0][campo]
        newRow.append('<input type="hidden" name="productos[' + contador + '][company_id]" value="' +
            companyId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador + '][product_id]" value="' +
            productId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador +
        '][codelot]" class="input-cantidad" value="' + loteId + '">');

        newRow.append('<input type="hidden" name="productos[' + contador +
        '][finishlot]" class="input-cantidad" value="' + vtoId + '">');

        newRow.append('<input type="hidden" name="productos[' + contador +
            '][cantinventory]" class="input-cantidad" value="' + cantidad + '">');

        tbody.append(newRow);
        contador++;

        actualizarContador();
        actualizarTotalUnidades();
        reiniciar();
        // Eliminar producto de la tabla
        btnEliminar.on('click', function() {
            const index = productosAgregados.indexOf(key);
            if (index > -1) productosAgregados.splice(index, 1);

            newRow.remove();
            actualizarContador();
            actualizarTotalUnidades();
            if (productosAgregados.length < 1) {
                $('#company_id').prop('disabled', false);
            }
        });
    });

    function actualizarContador() {
        $('#contadorProductos').text(productosAgregados.length);
    }

    function reiniciar() {
        $('#codelot').val("");
        $('#finishlot').val("");
    }


    function actualizarTotalUnidades() {
        let total = 0;
        $('.input-cantidad').each(function() {
            total += parseInt($(this).val());
        });
        $('#totalunits').val(total);
    }

    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById("table-search");
        const tableRows = document.querySelectorAll("tbody tr");

        searchInput.addEventListener("keyup", function() {
            const filter = searchInput.value.toLowerCase().trim();

            tableRows.forEach(row => {
                const entryIdCell = row.querySelector("th");

                if (entryIdCell && entryIdCell.textContent.toLowerCase().includes(filter)) {
                    row.style.display = "";
                } else {
                    row.style.display = "none";
                }
            });
        });
    });

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
        iframe.src = '{{ route('listado.empresas') }}';
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
</script>

@if ($errors->any() && session('editing_income_id'))
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const modalId = 'incomeModalEdit-' + {{ session('editing_income_id') }};
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
            const modalId = 'static-modal';
            const modal = document.getElementById(modalId);
            if (modal) {
                modal.classList.remove('hidden');
                modal.classList.add('flex');
            }
        });
    </script>
@endif
