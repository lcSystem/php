<style type="text/css">/* Contenedor principal de Configuración */
.settings-container {
    max-width: 900px;
    margin: 20px auto;
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    overflow: hidden;
}

/* Pestañas */
.tabs {
    display: flex;
    background: #CC8500;
    cursor: pointer;
}

.tab {
    flex: 1;
    text-align: center;
    padding: 15px 0;
    color: white;
    font-weight: bold;
    transition: background 0.3s;
}

.tab.active {
    background: #8F5F01;
}

/* Secciones */
.settings-section {
    display: none;
    padding: 20px;
}

.settings-section.active {
    display: block;
}

/* Formularios dentro de cada sección */
.settings-section form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.settings-section label {
    font-weight: bold;
    display: flex;
    align-items: center;
    gap: 8px; /* separa icono del texto */
}

/* Inputs y selects */
.settings-section input[type="text"],
.settings-section input[type="email"],
.settings-section input[type="password"],
.settings-section input[type="number"],
.settings-section select,
.settings-section input[type="file"] {
    padding: 8px 10px;
    border: 1px solid #ccc;
    border-radius: 6px;
    width: 100%;
}

/* Checkbox dentro de labels */
.settings-section input[type="checkbox"] {
    margin-right: 10px;
}

/* Botones */
.settings-section button {
    padding: 10px;
    background: #CC8500;
    color: white;
    border: none;
    border-radius: 8px;
    cursor: pointer;
    font-weight: bold;
    transition: background 0.3s;
}

.settings-section button:hover {
    background: #0056b3;
}

/* Iconos dentro de labels */
.settings-section label i {
    color: #CC8500;
}

/* Responsivo: pestañas apiladas en móviles */
@media(max-width: 600px){
    .tabs {
        flex-direction: column;
    }
}
</style>
<div class="settings-container">

    <!-- Pestañas -->
    <div class="tabs">
        <div class="tab active" data-tab="reportes"><i class="fas fa-chart-line"></i> Reportes</div>
        <div class="tab" data-tab="preferencias"><i class="fas fa-cogs"></i> Preferencias</div>
        <div class="tab" data-tab="notificaciones"><i class="fas fa-bell"></i> Notificaciones</div>
    </div>

    <!-- Sección Reportes -->
    <div class="settings-section active" id="reportes">
        <h2><i class="fas fa-chart-line"></i> Configuración de Reportes</h2>
        <form method="post" action="">
            <label><i class="fas fa-file-alt"></i> Tipo de reporte:</label>
            <select name="tipo_reporte">
                <option>Ventas</option>
                <option>Productos más vendidos</option>
                <option>Historial de compras</option>
                <option>Carrito abandonado</option>
            </select>

            <label><i class="fas fa-calendar-alt"></i> Periodo:</label>
            <select name="periodo">
                <option>Última semana</option>
                <option>Último mes</option>
                <option>Último año</option>
            </select>

            <label><i class="fas fa-chart-pie"></i> Formato:</label>
            <select name="formato">
                <option>Tabla</option>
                <option>Gráfico de barras</option>
                <option>Gráfico circular</option>
            </select>

            <label><i class="fas fa-file-export"></i> Exportar como:</label>
            <select name="exportar">
                <option>PDF</option>
                <option>CSV</option>
                <option>Excel</option>
            </select>

            <button type="submit" name="guardar_reportes">Guardar configuración</button>
        </form>
    </div>

    <!-- Sección Preferencias -->
    <div class="settings-section" id="preferencias">
        <h2><i class="fas fa-cogs"></i> Preferencias de Usuario</h2>
        <form method="post" action="">
            <label><i class="fas fa-sort-amount-down"></i> Orden de productos:</label>
            <select name="orden_productos">
                <option>Precio ascendente</option>
                <option>Precio descendente</option>
                <option>Más populares</option>
                <option>Novedades</option>
            </select>

            <label><i class="fas fa-th-large"></i> Productos por página:</label>
            <input type="number" name="productos_pagina" min="5" max="50" value="10">

            <label><i class="fas fa-box-open"></i>
                <input type="checkbox" name="mostrar_agotados" checked> Mostrar productos agotados
            </label>

            <label><i class="fas fa-adjust"></i> Tema:</label>
            <select name="tema">
                <option>Claro</option>
                <option>Oscuro</option>
            </select>

            <button type="submit" name="guardar_preferencias">Guardar preferencias</button>
        </form>
    </div>

    <!-- Sección Notificaciones -->
    <div class="settings-section" id="notificaciones">
        <h2><i class="fas fa-bell"></i> Configuración de Notificaciones</h2>
        <form method="post" action="">
            <label><i class="fas fa-tags"></i>
                <input type="checkbox" name="promociones" checked> Promociones
            </label>
            <label><i class="fas fa-shopping-cart"></i>
                <input type="checkbox" name="carrito_abandonado"> Carrito abandonado
            </label>
            <label><i class="fas fa-check-circle"></i>
                <input type="checkbox" name="confirmaciones_compra" checked> Confirmaciones de compra
            </label>
            <label><i class="fas fa-bell"></i>
                <input type="checkbox" name="push"> Notificaciones push
            </label>

            <button type="submit" name="guardar_notificaciones">Guardar notificaciones</button>
        </form>
    </div>

</div>

<script>
// Cambiar pestañas
const tabs = document.querySelectorAll('.tab');
const sections = document.querySelectorAll('.settings-section');

tabs.forEach(tab => {
    tab.addEventListener('click', () => {
        tabs.forEach(t => t.classList.remove('active'));
        tab.classList.add('active');

        const target = tab.getAttribute('data-tab');
        sections.forEach(sec => sec.classList.remove('active'));
        document.getElementById(target).classList.add('active');
    });
});
</script>
