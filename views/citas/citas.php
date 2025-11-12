
<div class="calendar-section">
    <div class="container">
        <h2 class="text-center mb-4">📅 Calendario de Citas</h2>

        <div class="calendar-header">
            <select id="selectSalon">
                <option value="1">Salón Estefany Beauty </option>
            </select>
            <select id="selectStaff">
                <option value="all">Todos los Staff</option>
                <option value="1">Brenda</option>
                <option value="2">Zachary</option>
                <option value="3">Jenny</option>
            </select>
            <div>
                <button id="prevDay"><i class="fas fa-chevron-left"></i></button>
                <span id="currentDate">Hoy</span>
                <button id="nextDay"><i class="fas fa-chevron-right"></i></button>
            </div>
            <button class="btn-gold" onclick="abrirModalAgregarCita()">+ Agendar Cita</button>
        </div>

        <div class="calendar-grid">
        <div class="hour-column">
        <?php foreach($slots as $slotStr):
            $dt = new DateTime($slotStr);
        ?>
            <div class="hour"><?= $dt->format('H:i') ?></div>
        <?php endforeach; ?>
        </div>

        <div class="day-column" id="day-column">
        <?php foreach($slots as $slotStr):
            $dt = new DateTime($slotStr);
            $slotId = 'slot-' . $dt->format('Y-m-d-H-i');
        ?>
            <div class="time-slot" id="<?= $slotId ?>" data-slot="<?= $slotStr ?>"></div>
        <?php endforeach; ?>
        </div>

        </div>
                
            </div>
        </div>

<!-- Modal Nueva Cita -->

<template id="templateComponent-modal">
  <div class="modal"  style="display:none;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 class="modal-title">Editar</h2>
      <form class="form-container"></form>
    </div>
  </div>
  
</template>

<script type="text/javascript">
const citas = <?= json_encode($citas, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const slots = <?= json_encode($slots, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const clientes = <?= json_encode($clientes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const servicios = <?= json_encode($servicio, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const usuarioActual = clientes[0];

  const fh = fechaHora();


  const camposCita = [
      { nombre: "cliente", etiqueta: "cliente", tipo: "select", 
        opciones: clientes.map(c => ({ value: c.id, text: c.username }))},
      { nombre: "fecha", etiqueta: "Fecha", tipo: "date" },
      { nombre: "hora", etiqueta: "Hora ", tipo: "time" },
      { nombre: "servicio", etiqueta: "Servicio", tipo: "select", 
        opciones: servicios.map(c => ({ value: c.id, text: c.nombre }))},
      { nombre: "observaciones", etiqueta: "Observaciones", tipo: "textarea" }

    ];


  const valores = {
    id: 1,
    cliente:  usuarioActual ? usuarioActual.id : "",
    fecha: fh.fecha,
    hora: fh.hora,
    servicio: 1,
    observaciones: ""
  };




function abrirModalAgregarCita(id, datosCita) {
    abrir({
        campos: camposCita, valores, titulo: "Cita",onGuardar: (data) => {
             guardarCita(data);
        } 
    });
}

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
    };;

    guardarRegistro(`${CITAS_CONTROLLER_URL}?action=crearCita`, datos, 'cita', (response) => {
        cita.push(response.cita);
    });
}

//slot............  

 console.log("citas: ",citas[0]);
  console.log("slot: ",slots);


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

    const slotInterval = 30; // minutos por slot
    const slotHeight = 60;   // px por slot

    citas.forEach(c => {
        const fecha = c.fecha_cita; // yyyy-mm-dd
        const hora = c.hora_cita.substring(0, 5); // HH:MM
        const dur = parseInt(c.duracion_minutos) || 30; // duración real en minutos

        // Construir ID del slot más cercano
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

        // Crear bloque visual
        const block = document.createElement('div');
        block.className = 'cita-block';
        block.innerHTML = `<strong>${c.nombre_completo}</strong>
                           <div>${c.servicio || ''}</div>`;
        block.style.position = 'absolute';

        // Calcular diferencia de minutos desde inicio del slot
        const [slotFecha, slotHora] = slot.dataset.slot.split(' ');
        const [slotHH, slotMM] = slotHora.split(':').map(Number);
        const [horaHH, horaMM] = hora.split(':').map(Number);
        const diffMin = (horaHH * 60 + horaMM) - (slotHH * 60 + slotMM);

        // Ajustar top y altura del bloque
        block.style.top = `${(diffMin / slotInterval) * slotHeight}px`;
        block.style.height = `${(dur / slotInterval) * slotHeight}px`;

        slot.appendChild(block);
    });
}

document.addEventListener('DOMContentLoaded', pintarCitas);

</script>
