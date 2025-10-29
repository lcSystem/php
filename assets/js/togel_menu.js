function toggleMenu() {
  document.getElementById("dropdown").classList.toggle("hidden");
}

let tabla;


$(document).ready(function() {
     tabla = $('table').DataTable({
        responsive: true,
        paging: true,
        searching: true, 
        lengthChange: false,
        pageLength: 5,
        language: {
            info: "Mostrando _START_ a _END_ de _TOTAL_ registros",
            infoEmpty: "No hay registros disponibles",
            zeroRecords: "No se encontraron resultados",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior"
            }
        },
        dom: "t<'d-flex justify-content-between mt-2'<'info'i><'pagination'p>>" // reorganizamos la info y paginación
    });

    //  
    $('#mi-buscador').on('input', function() {
        tabla.search(this.value).draw();
    });
});

