
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
            <button class="btn-gold" onclick="abrirCita()">+ Agendar Cita</button>
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
const T_ANTICIPADO_H = "<?= T_ANTICIPADO_H ?>"; 
const F_HORARIO = "<?= F_HORARIO ?>";
 const CITAS_CONTROLLER_URL = "<?= CITAS_CONTROLLER_URL ?>";
</script>
<script src="<?php echo JQUERY_JS; ?>"></script>
 <script src="<?php echo CITA_JS ?>"></script>