<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once __DIR__ . '/../../config/paths.php';
include_once CP_TABLE; 

$columns = [
    'id' => 'ID',
    'username' => 'Username',
    'email' => 'Email',
    'nombre_completo' => 'Nombre Completo',
    'telefono' => 'Teléfono',
    'direccion' => 'Dirección',
    'edad' => 'Edad',
    'rol' => 'Rol',
    'estado' => 'Estado'
];

$actions = [
    'editar' => 'abrirModalEditarUsuario',
    'eliminar' => 'eliminarUsuario',
    'toggle' => 'toggleUsuario'
];

$addButton = [
    'label' => 'Agregar Usuario',
    'onClick' => 'abrirModalAgregarUsuario()',
    'class' => 'btn-gold'
];

renderTable('usuarios', 'Usuarios Registrados', $columns, $usuarios, $actions, $addButton);
?>

<template id="templateComponent-modal">
  <div class="modal"  style="display:none;">
    <div class="modal-content">
      <span class="close">&times;</span>
      <h2 class="modal-title">Editar</h2>
      <form class="form-container"></form>
    </div>
  </div>
  </template>

<!-- modal para editar usuarios -->
<script type="text/javascript">
const usuarios = <?= json_encode($usuarios, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP) ?>;
const estados = ["activo", "inactivo"];
const roles = ["usuario", "admin", "cliente"];
const USUARIO_CONTROLLER_URL = "<?= USER_CONTROLLER_URL ?>";

const camposUsuario = [
    { nombre: "username", etiqueta: "Username", tipo: "text" },
    { nombre: "email", etiqueta: "Email", tipo: "email" },
    { nombre: "nombre_completo", etiqueta: "Nombre Completo", tipo: "text" },
    { nombre: "telefono", etiqueta: "Teléfono", tipo: "text" },
    { nombre: "direccion", etiqueta: "Dirección", tipo: "text" },
    { nombre: "edad", etiqueta: "Edad", tipo: "number" },
    { nombre: "rol", etiqueta: "Rol", tipo: "select", opciones: roles.map(r => ({ value: r, text: r })) },
    { nombre: "estado", etiqueta: "Estado", tipo: "select", opciones: estados.map(e => ({ value: e, text: e })) }
];

function abrirModalAgregarUsuario() {
    abrir(camposUsuario, {}, "Usuario", (data) => {
        guardarUsuario(data);
    });
}

function abrirModalEditarUsuario(id, datosUsuario) {
    abrir(camposUsuario, datosUsuario, "Usuario", (dataActualizada) => {
        actualizarUsuario(id, dataActualizada);
    });
}

function guardarUsuario(data) {
    guardarRegistro(`${USUARIO_CONTROLLER_URL}?action=crearUsuario`, data, 'usuario', (response) => {
        usuarios.push(response.usuario);
       refrescarTabla('servicio');
    });
}

function actualizarUsuario(id, data) {
    actualizarRegistro(`${USUARIO_CONTROLLER_URL}?action=actualizarUsuario`, { id, ...data }, 'usuario', (response) => {
        // reemplazar datos locales
        const index = usuarios.findIndex(u => u.id === id);
        if(index >= 0) usuarios[index] = response.usuario;
        refrescarTabla('servicio');
    });
}

function eliminarUsuario(id) {
    eliminarRegistro(`${USUARIO_CONTROLLER_URL}?action=eliminarUsuario`, id, 'usuario', () => {
        const index = usuarios.findIndex(u => u.id === id);
        if(index >= 0) usuarios.splice(index, 1);
        refrescarTabla('servicio');
    });
}

function toggleUsuario(id, estadoActual) {
    cambiarEstado(`${USUARIO_CONTROLLER_URL}?action=cambiarEstado`, id, estadoActual, 'usuario', (response, nuevoEstado) => {
        const index = usuarios.findIndex(u => u.id === id);
        if(index >= 0) usuarios[index].estado = nuevoEstado;
       refrescarTabla('servicio');
    });
}

</script>