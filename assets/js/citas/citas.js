 // Campos que tendra el formulario
  const ahora = new Date();
  const fechaActual = ahora.toISOString().split('T')[0]; // yyyy-mm-dd
  let horaActual;
  let ampm;

const usuarioActual = clientes[0]; 

ahora.setHours(ahora.getHours() + T_ANTICIPADO_H);

 horaActual, ampm = '';

if(F_HORARIO == '12'){
    // horario 12h
    let horas = ahora.getHours();
    const minutos = ahora.getMinutes().toString().padStart(2,'0');
    ampm = horas >= 12 ? 'PM' : 'AM';
    horas = horas % 12;
    horas = horas ? horas : 12;
    horaActual = `${horas.toString().padStart(2,'0')}:${minutos}`;
}else{
    // horario 24h
    horaActual = ahora.toTimeString().split(':').slice(0,2).join(':');
}

// componete modal cita

  const camposCita = [
      { nombre: "cliente", etiqueta: "cliente", tipo: "select", 
        opciones: clientes.map(c => ({ value: c.id, text: c.username }))},
      { nombre: "fecha", etiqueta: "Fecha", tipo: "date" },
      { nombre: "hora", etiqueta: "Hora", tipo: "time" },
      { nombre: "servicio", etiqueta: "Servicio", tipo: "select", 
        opciones: servicios.map(c => ({ value: c.id, text: c.nombre }))},
      { nombre: "observaciones", etiqueta: "Observaciones", tipo: "textarea" }

    ];

  const valores = {
    id: 1,
    cliente: usuarioActual ? usuarioActual.id : "",
    fecha: fechaActual,
    hora: horaActual,
    servicio: 1,
    observaciones: ""
  };


function abrirCita() {

  abrir(camposCita, valores, "Cita", (data) => {
    console.log("Cita:", data);
    guardarCita(data)

  });
}

// fin crracion componente

function guardarCita(data) {
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

   

function buildSlotId(fecha, hora) {
    const [hh, mm] = hora.split(':');
    return `slot-${fecha}-${hh}-${mm}`;
}

function getNearestSlot(fecha, hora) {
    const [hh, mm] = hora.split(':').map(Number);
    const targetMinutes = hh * 60 + mm;
    let nearest = null;
    let nearestDiff = Infinity;

    document.querySelectorAll('.time-slot').forEach(s => {
        const [sFecha, sHora] = s.dataset.slot.split(' ');
        if (sFecha !== fecha) return;
        const [shh, smm] = sHora.split(':').map(Number);
        const slotMinutes = shh * 60 + smm;
        if (slotMinutes <= targetMinutes && (targetMinutes - slotMinutes) < nearestDiff) {
            nearestDiff = targetMinutes - slotMinutes;
            nearest = s.dataset.slot;
        }
    });

    if (!nearest) return null;
    const [f, h] = nearest.split(' ');
    return buildSlotId(f, h);
}
function pintarCitas() {
    // Limpia citas previas
    document.querySelectorAll('.time-slot .cita-block').forEach(e => e.remove());

    const slotInterval = 30; // minutos entre cada slot en el calendario

    citas.forEach(c => {
        const fecha = c.fecha_cita; // yyyy-mm-dd
        const hora = c.hora_cita.substring(0, 5); // HH:MM
        const dur = parseInt(c.duracion_minutos) || 30; // duración en minutos
        const slotsNeeded = Math.ceil(dur / slotInterval); // cuántos slots ocupa

        // Busca el slot inicial exacto o el más cercano anterior
        let slotId = buildSlotId(fecha, hora);
        let slot = document.getElementById(slotId);

        if (!slot) {
            slotId = getNearestSlot(fecha, hora);
            if (!slotId) {
                console.warn('❌ No se encontró slot para:', fecha, hora);
                return;
            }
            slot = document.getElementById(slotId);
        }

        // Crear bloque visual de la cita
        const block = document.createElement('div');
        block.className = 'cita-block';
        block.innerHTML = `
            <strong>${c.nombre_completo}</strong>
            <div>${c.servicio || ''}</div>
        `;
        
        // Definir altura (cada slot = 60px de alto)
        block.style.height = `${slotsNeeded * 60 - 10}px`;
        block.style.top = '0px';
        block.style.position = 'absolute';

        // Añadir bloque al slot inicial
        slot.appendChild(block);
    });
}

document.addEventListener('DOMContentLoaded', pintarCitas);
//document.querySelectorAll('.time-slot').forEach(s => console.log(s.dataset.slot));