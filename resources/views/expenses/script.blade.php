<script>
    let tablaLotes = $('#tablaLotes').DataTable({
        language: {
            url: "//cdn.datatables.net/plug-ins/1.13.6/i18n/es-ES.json"
        },
        columns: [{
                data: 'producto'
            },
            {
                data: 'lote'
            },
            {
                data: 'stock'
            },
            {
                data: 'cantidad'
            },
            {
                data: 'accion'
            }
        ]
    });

    // Cargar lotes por producto
    $('#buscarStock').on('click', function() {
        tablaLotes.clear().draw();


        $.get('/lotes', function(data) {
            data.forEach(function(item) {
                tablaLotes.row.add({
                    producto: item.product.code,
                    lote: item.batch.code,
                    stock: item.stock,
                    cantidad: `<input type="number" class="form-control cantidad" min="1" max="${item.stock}">`,
                    accion: `<button class="btn btn-primary btn-sm btn-asignar"
                                 data-lote="${item.batch?.code || item.batch_id}"
                                 data-batch="${item.batch_id}"
                                 data-stock="${item.stock}">
                            Asignar
                         </button>`
                });
            });
            tablaLotes.draw();
        });
    });

    // Asignar lote a tabla secundaria
    $('#tablaLotes tbody').on('click', '.btn-asignar', function() {
        const btn = $(this);
        const row = btn.closest('tr');
        const lote = btn.data('lote');
        const batch_id = btn.data('batch');
        const stock = btn.data('stock');
        const cantidad = row.find('.cantidad').val();

        if (!cantidad || cantidad <= 0 || cantidad > stock) {
            alert('Cantidad inválida');
            return;
        }

        // Verifica si ya se agregó el mismo lote
        let repetido = false;
        $('#tablaAsignaciones tbody tr').each(function() {
            if ($(this).data('batch') == batch_id) {
                repetido = true;
            }
        });
        if (repetido) {
            alert('Este lote ya ha sido asignado.');
            return;
        }

        $('#tablaAsignaciones tbody').append(`
        <tr data-batch="${batch_id}">
            <td>${lote}</td>
            <td>${cantidad}</td>
            <td><button class="btn btn-danger btn-sm btn-eliminar">Eliminar</button></td>
        </tr>
    `);
    });

    // Eliminar lote asignado
    $('#tablaAsignaciones').on('click', '.btn-eliminar', function() {
        $(this).closest('tr').remove();
    });

    // Guardar asignaciones
    $('#btnGuardarAsignaciones').on('click', function() {
        const productId = $('#productSelect').val();
        if (!productId) {
            alert('Debe seleccionar un producto');
            return;
        }

        const asignaciones = [];

        $('#tablaAsignaciones tbody tr').each(function() {
            asignaciones.push({
                batch_id: $(this).data('batch'),
                cantidad: $(this).find('td').eq(1).text()
            });
        });

        if (asignaciones.length === 0) {
            alert('Debe asignar al menos un lote');
            return;
        }

        $.ajax({
            url: '/guardar-asignaciones',
            method: 'POST',
            data: {
                product_id: productId,
                asignaciones: asignaciones,
                _token: '{{ csrf_token() }}'
            },
            success: function(res) {
                alert('Asignaciones guardadas correctamente');
                $('#tablaAsignaciones tbody').empty();
            },
            error: function() {
                alert('Error al guardar asignaciones');
            }
        });
    });



    
</script>
