<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // FUNCION PARA CARGAR LOS DATOS DE LOS PRODUCTOS SEGUN LA SELECCION DEL PROVEEDOR
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

        //OBTENER DATOS DEL FORMULARIO
        const companySelect = $('#company_id');
        const productSelect = $('#producto');
        const cantidadInput = $('#cantinventory');
        const loteInput = $('#codelot');
        const fabricacionInput = $('#initlot');
        const vencimientoInput = $('#finishlot');
        const companyId = companySelect.val();
        const companyText = companySelect.find('option:selected').text();
        const productId = productSelect.val();
        const productText = productSelect.find('option:selected').text();
        const loteId = loteInput.val();
        const fabId = fabricacionInput.val();
        const vtoId = vencimientoInput.val();
        const cantidad = parseInt(cantidadInput.val());
        const key = companyId + '-' + productId;
        productosAgregados.push(key);
        //FIN OBTENER DATOS

        //ASIGNAR DATOS A LA TABLA
        const tbody = $('#tablaProductos tbody');
        const newRow = $(
            '<tr class="bg-gray-500 border-b border-gray-400 text-center"></tr>'
        );

        // VISUALIZAR LOS DATOS EN LAS CELDAS
        newRow.append('<td class="p-3 text-white">' + productText + '</td>');
        newRow.append('<td class="p-3 text-white">' + cantidad + '</td>');
        newRow.append('<td class="p-3 text-white">' + loteId + '</td>');
        newRow.append('<td class="p-3 text-white">' + fabId + '</td>');
        newRow.append('<td class="p-3 text-white">' + vtoId + '</td>');

        // CREAR BOTON DE ELIMINAR PRODUCTO DEL LISTADO
        const btnEliminar = $(
            '<button type="button" class="text-white p-1 rounded">Eliminar</button>');
        const actionCell = $('<td></td>').append(btnEliminar);
        newRow.append(actionCell);

        // AGREGAR LOS DATOS A LOS INPUTS OCULTOS SE CREA UN ARREGLO DE INPUTS CON FORMATO productos[0][campo]
        newRow.append('<input type="hidden" name="productos[' + contador + '][company_id]" value="' +
            companyId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador + '][product_id]" value="' +
            productId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador +
            '][codelot]" class="input-cantidad" value="' + loteId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador +
            '][initlot]" class="input-cantidad" value="' + fabId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador +
            '][finishlot]" class="input-cantidad" value="' + vtoId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador +
            '][cantinventory]" class="input-cantidad" value="' + cantidad + '">');
        tbody.append(newRow);
        contador++;

        // LLAMADO DE LAS FUNCIONES ADICIONALES
        actualizarContador();
        actualizarTotalUnidades();
        reiniciar();

        // FUNCION PARA ELIMINAR EL PRODUCTO DEL LISTADO
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

    function actualizarContador() {
        $('#contadorProductos').text(productosAgregados.length);
    }

    function reiniciar() {
        $('#codelot').val("");
        $('#initlot').val("");
        $('#finishlot').val("");
    }

    function actualizarTotalUnidades() {
        let total = 0;
        $('.input-cantidad').each(function() {
            total += parseInt($(this).val());
        });
        $('#totalunits').val(total);
    }

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

    function abrirModalPDF(entry) {
        const iframe = document.getElementById('iframePDF');
        const modal = document.getElementById('modalPDF');
        const url = '{{ route('income.entry', ['entry' => ':entry']) }}'.replace(':entry', entry);
        iframe.src = url;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }
    setTimeout(() => {
        const alert = document.getElementById('alert');
        if (alert) {
            alert.style.transition = "opacity 0.5s ease-out";
            alert.style.opacity = 0;

            // Opcional: quitar el elemento del DOM después de la animación
            setTimeout(() => alert.remove(), 500);
        }
    }, 3000);
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

@if ($errors->any() && session('create_income_id'))
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
