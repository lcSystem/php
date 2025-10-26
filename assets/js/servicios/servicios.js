
// componete modal servicios

  const camposCita = [
      { nombre: "id", etiqueta: "ID", tipo: "text"},
      { nombre: "nombre", etiqueta: "nombre", tipo: "text" },
      { nombre: "duracion_minutos", etiqueta: "duracion_minutos", tipo: "time" },
      { nombre: "descripcion", etiqueta: "descripcion", tipo: "textarea" }

    ];

  const valores = {
    id: 1,
    cliente: usuarioActual ? usuarioActual.id : "",
    fecha: fechaActual,
    hora: horaActual,
    servicio: 1,
    observaciones: ""
  };


function abrirModalAgregarServicio() {
  abrir(camposCita, "", "Servicio", (data) => {
    guardarServicio(data)

  });
}

function abrirModalEditarServicio() {
  abrir(camposCita, valores, "Cita", (data) => {
    console.log("Cita:", data);
    guardarCita(data)
  });
}

// fin crracion componente

function guardarServicio(data) {
    const datos = {
        cliente_id: data.cliente,
        servicio_id: data.servicio,
        empleado_id: 1,
        fecha_cita: data.fecha,
        hora_cita: data.hora + ':00',
        duracion_minutos: parseInt(data.duracion) || 60,
        estado: 'pendiente',
        comentarios: data.observaciones,
        creada_por: usuarioActual.id
    };

    console.log("📤 Enviando datos:", datos);

    $.post(`${CITAS_CONTROLLER_URL}?action=crearCita`, datos, function(response) {
        console.log("📥 Respuesta del servidor:", response);

        if (response && response.success) {
            console.log('✅ Cita guardada correctamente:', response.cita);
            showToast("Cita guardada correctamente", "success");

            citas.push(response.cita);
            pintarCitas();
            $('#modalCita').modal('hide');
        } else {
            console.error('❌ Error al guardar cita:', response?.message);
            showToast("Error al guardar la cita: " + (response?.message || "Desconocido"), "error");
        }
    }, 'json').fail(function(xhr, status, error) {
        console.error("🚨 Error AJAX:", error, xhr.responseText);
        showToast("Error en el servidor: " + error, "error");
    });
}

//slot............

 console.log("citas: ",citas[0]);
   console.log("clientes: ",clientes[0]);
    console.log("servicios: ",servicios[0]);

   