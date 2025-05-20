<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Cargar productos al seleccionar proveedor
    $('#company_id').on('change', function () {
        const companyID = $(this).val();

        if (companyID) {
            $.ajax({
                url: '/productos/' + companyID,
                type: 'GET',
                success: function (data) {
                    $('#producto').empty();
                    $('#producto').append('<option value="">Seleccione un producto</option>');
                    $.each(data, function (key, value) {
                        $('#producto').append('<option value="' + value.id + '">' + value.description + '</option>');
                    });
                }
            });
        } else {
            $('#producto').empty().append('<option value="">Seleccione un producto</option>');
        }
    });

    let productosAgregados = [];
    let contador = 0;

    $('#agregarProducto').on('click', function () {
        const companySelect = $('#company_id');
        const productSelect = $('#producto');
        const cantidadInput = $('#cantinventory');

        const companyId = companySelect.val();
        const companyText = companySelect.find('option:selected').text();

        const productId = productSelect.val();
        const productText = productSelect.find('option:selected').text();

        const cantidad = parseInt(cantidadInput.val());

        if (!companyId || !productId) {
            alert('Debe seleccionar proveedor y producto.');
            return;
        }

        if (cantidad < 1 || isNaN(cantidad)) {
            alert('La cantidad debe ser mayor a 0.');
            return;
        }

        const key = companyId + '-' + productId;
        if (productosAgregados.includes(key)) {
            alert('Este producto ya fue agregado.');
            return;
        }

        productosAgregados.push(key);

        const tbody = $('#tablaProductos tbody');
        const newRow = $('<tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600"></tr>');

        // Celdas visibles
        newRow.append('<td class="px-6 py-4">' + companyText + '</td>');
        newRow.append('<td class="px-6 py-4">' + productText + '</td>');
        newRow.append('<td class="px-6 py-4">' + cantidad + '</td>');

        // Botón de eliminar
        const btnEliminar = $('<button type="button" class="bg-red-500 text-white px-6 py-2 rounded">Eliminar</button>');
        const actionCell = $('<td></td>').append(btnEliminar);
        newRow.append(actionCell);

        // Inputs ocultos con formato productos[0][campo]
        newRow.append('<input type="hidden" name="productos[' + contador + '][company_id]" value="' + companyId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador + '][product_id]" value="' + productId + '">');
        newRow.append('<input type="hidden" name="productos[' + contador + '][cantinventory]" class="input-cantidad" value="' + cantidad + '">');

        tbody.append(newRow);
        contador++;

        actualizarContador();
        actualizarTotalUnidades();

        // Eliminar producto de la tabla
        btnEliminar.on('click', function () {
            const index = productosAgregados.indexOf(key);
            if (index > -1) productosAgregados.splice(index, 1);

            newRow.remove();
            actualizarContador();
            actualizarTotalUnidades();
        });
    });

    function actualizarContador() {
        $('#contadorProductos').text(productosAgregados.length);
    }

    function actualizarTotalUnidades() {
        let total = 0;
        $('.input-cantidad').each(function () {
            total += parseInt($(this).val());
        });
        $('#totalunits').val(total);
    }

    function cerrarModal() {
        location.reload();
    }

    document.addEventListener("DOMContentLoaded", function () {
    const searchInput = document.getElementById("table-search");
    const searchInput2 = document.getElementById("table-search2");
    const tableRows = document.querySelectorAll("tbody tr");

    searchInput.addEventListener("keyup", function () {
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

    searchInput2.addEventListener("keyup", function () {
        const filter = searchInput2.value.toLowerCase().trim();

        tableRows.forEach(row => {
            const prov = row.querySelector("td");

            if (prov && prov.textContent.toLowerCase().includes(filter)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    });

});
</script>