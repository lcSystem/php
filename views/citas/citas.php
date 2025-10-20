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
            <button class="btn-gold" onclick="abrirCita()">+ Agendar Cita</button>
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
const clientes = <?= json_encode($clientes, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const F_HORARIO = "<?= F_HORARIO ?>"; 
const T_ANTICIPADO_H = "<?= T_ANTICIPADO_H ?>"; 

</script>
<script src="<?php echo JQUERY_JS; ?>"></script>
 <script src="<?php echo CITA_JS ?>"></script>