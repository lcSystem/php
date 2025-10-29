function toggleMenu() {
  document.getElementById("dropdown").classList.toggle("hidden");
}

$(document).ready(function() {
    const tabla = $('table').DataTable({
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

    // 🔹 Buscador externo
    // Asegúrate que #mi-buscador esté en el DOM al momento de ejecutar esto
    $('#mi-buscador').on('input', function() {
        tabla.search(this.value).draw();
    });
});
