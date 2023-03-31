function SpanishDataTable()
{
    return  {
        "decimal": "",
        "emptyTable": "No hay información",
        "info": "Mostrando _START_ a _END_ de _TOTAL_ Entradas",
        "infoEmpty": "Mostrando 0 to 0 of 0 Entradas",
        "infoFiltered": "(Filtrado de _MAX_ total entradas)",
        "infoPostFix": "",
        "thousands": ",",
        "lengthMenu": "Mostrar _MENU_ Entradas",
        "loadingRecords": "Cargando...",
        "processing": "Procesando...",
        "search": "Buscar:",
        "zeroRecords": "Sin resultados encontrados",
        "paginate": {
            "first": "Primero",
            "last": "Ultimo",
            "next": "Siguiente",
            "previous": "Anterior"
        }
    };
}

/// Abrir modal

function openModal(IdModal)
{
    $("#"+IdModal).modal("show")
}

/// cerrar el modal
function closeModal(IdModal)
{
    $("#"+IdModal).modal("hide")
}

/// mostrar los datos

function showData(url_)
{
    let Data = null;

    $.ajax({
        url:url_,
        method:"GET",
        async:false,
        success:function (response) 
        {
         response = JSON.parse(response)

         Data = response;
        }
    })

    return Data;
}