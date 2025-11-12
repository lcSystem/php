<script type="text/javascript">
const USUARIO_CONTROLLER_URL = <?= json_encode(USER_CONTROLLER_URL) ?>;
const CITAS_CONTROLLER_URL = "<?= CITAS_CONTROLLER_URL?>";
 const SERVICIO_CONTROLLER_URL =  "<?= SERVICIO_CONTROLLER_URL ?>";
//const estados = <?= json_encode(["activo", "inactivo"]) ?>;
const MONEDA_SIMBOLO = <?= json_encode(MONEDA_SIMBOLO) ?>;
const F_FECHA = <?= json_encode(F_FECHA) ?>;
const F_HORARIO = <?= json_encode(F_HORARIO) ?>;
const T_ANTICIPADO_H = Number(<?= json_encode(T_ANTICIPADO_H) ?>);
const F_VALOR = {
    moneda: 'COP',
    locale: 'es-CO',
    estilo: { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }
};

function constante(){
console.log("constantes.................");
console.log(SERVICIO_CONTROLLER_URL);
console.log(CITAS_CONTROLLER_URL);
console.log(USUARIO_CONTROLLER_URL);
//console.log(estados);
console.log(MONEDA_SIMBOLO);
console.log(F_FECHA);
console.log(F_HORARIO);
console.log(F_VALOR);
console.log(T_ANTICIPADO_H);
console.log("fin.................");

}

</script>