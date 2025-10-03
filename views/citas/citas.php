 <?php require_once '../config/paths.php'; ?>
 <link rel="stylesheet" href="<?= ASSETS_URL ?>/css/citas.css">
<div class="calendar-section">
    <div class="container">
        <h2 class="text-center mb-4">📅 Calendario de Citas</h2>

        <div class="calendar-header">
            <select id="selectSalon">
                <option value="1">Beauty Shop & SPA</option>
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
            <button class="btn-gold" onclick="abrirModalCita()">+ Agendar Cita</button>
        </div>

        <div class="calendar-grid">
            <div class="hour-column">
                <div class="hour">09:00</div>
                <div class="hour">10:00</div>
                <div class="hour">11:00</div>
                <div class="hour">12:00</div>
                <div class="hour">13:00</div>
                <div class="hour">14:00</div>
                <div class="hour">15:00</div>
                <div class="hour">16:00</div>
                <div class="hour">17:00</div>
                <div class="hour">18:00</div>
            </div>

            <!-- Columna de ejemplo -->
            <div class="day-column">
                <div class="time-slot" id="slot-0-9"></div>
                <div class="time-slot" id="slot-0-10"></div>
                <div class="time-slot" id="slot-0-11"></div>
                <div class="time-slot" id="slot-0-12"></div>
                <div class="time-slot" id="slot-0-13"></div>
                <div class="time-slot" id="slot-0-14"></div>
                <div class="time-slot" id="slot-0-15"></div>
                <div class="time-slot" id="slot-0-16"></div>
                <div class="time-slot" id="slot-0-17"></div>
                <div class="time-slot" id="slot-0-18"></div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Cita -->

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

<script>
function abrirModalCita(){
    $('#formCita')[0].reset();
    $('#modalCita').modal('show');
}

$('#monto_total').on('input', function(){
    const total = parseFloat($(this).val());
    if(!isNaN(total)){
        $('#deposito').val((total*0.10).toFixed(0));
    } else {
        $('#deposito').val('');
    }
});

function guardarCita(){
    const cliente = $('#cliente').val();
    const hora = parseInt($('#hora').val().split(':')[0]);
    const servicio = $('#servicio').val();
    const slotId = 'slot-0-'+hora;
    const colorClass = 'servicio-'+servicio;
    const logo = 'https://via.placeholder.com/28';
    $('#'+slotId).append(`
        <div class="cita-block ${colorClass}">
            <img src="${logo}" alt="${cliente}">
            <span>${cliente} - ${servicio}</span>
        </div>
    `);
    $('#modalCita').modal('hide');
}

// Citas simuladas
const citasSimuladas = [
    {hora:9,servicio:'blow',cliente:'Brenda Massey',logo:'https://via.placeholder.com/28'},
    {hora:10,servicio:'beard',cliente:'Zachary Kelley',logo:'https://via.placeholder.com/28'},
    {hora:11,servicio:'massage',cliente:'Diana Campos',logo:'https://via.placeholder.com/28'},
];

citasSimuladas.forEach(cita=>{
    const slotId = 'slot-0-'+cita.hora;
    const colorClass = 'servicio-' + cita.servicio;
    $('#'+slotId).append(`
        <div class="cita-block ${colorClass}">
            <img src="${cita.logo}" alt="${cita.cliente}">
            <span>${cita.cliente} - ${cita.servicio}</span>
        </div>
    `);
});
</script>