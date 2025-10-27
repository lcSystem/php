   function toggleMenu() {
  document.getElementById("dropdown").classList.toggle("hidden");
}

$(document).ready(function() {
    $('table').each(function() {
        if (!$.fn.DataTable.isDataTable(this)) {
            $(this).DataTable({
                responsive: true,
                paging: true,
                searching: true,
                lengthChange: true,
                pageLength: 5, // Número de registros por página
                language: {
                    search: "Buscar:",
                    lengthMenu: "Mostrar _MENU_ registros por página",
                    info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior"
                    }
                }
            });
        }
    });
});

