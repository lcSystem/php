<?php
// config/paths.php

// Base del proyecto (desde la raíz del servidor)
define('BASE_URL', '/plantilla');

// Assets
define('ASSETS_URL', BASE_URL . '/assets');
define('CSS_URL', ASSETS_URL . '/css');
define('JS_URL', ASSETS_URL . '/js');
define('IMG_URL', ASSETS_URL . '/img');
define('IMG_UPLOADS_URL', IMG_URL . '/uploads');
define('DASHBOARD_URL', BASE_URL . '/views/dashboard.php');


// Controllers
define('CONTROLLER_URL', BASE_URL . '/controller');
define('PERFIL_CONTROLLER', CONTROLLER_URL . '/perfil/perfilController.php');
define('LOGIN_CONTROLLER', CONTROLLER_URL . '/loginController.php');
define('LOGOUT_CONTROLLER', CONTROLLER_URL . '/logout.php');
define('REGISTRO_CONTROLLER', CONTROLLER_URL . '/registroController.php');
define('USER_CONTROLLER', CONTROLLER_URL . '/userController.php');

// Views (opcional, si quieres referenciarlas dinámicamente)
define('VIEWS_URL', BASE_URL . '/views');
define('PERFIL_VIEW', VIEWS_URL . '/perfil/perfil.php');
define('DASHBOARD_VIEW', VIEWS_URL . '/dashboard.php');
define('USERS_VIEW', VIEWS_URL . '/users/users.php');
define('APP_VIEW', VIEWS_URL . '/aplicaciones/app.php');
define('INDICADOR_VIEW', VIEWS_URL . '/indicador/indicador.php');

// Archivos específicos (opcional)
define('LOGIN_PAGE', BASE_URL . '/login.php');
define('WELCOME_PAGE', BASE_URL . '/welcome.php');

// Otros assets que quieras centralizar
// CSS
define('ALERTAS_CSS', CSS_URL . '/alertas.css');
define('ALERTIFY_CSS', CSS_URL . '/alertify.min.css');
define('BOOTSTRAP_CSS', CSS_URL . '/bootstrap.min.css');
define('UÑAS_CSS', CSS_URL . '/uñas.css');
define('NOTIFY_CSS', CSS_URL . '/Notification.css');

// JS
define('LOGIN_JS', JS_URL . '/login.js');
define('NOTIFY_JS', JS_URL . '/notifications.js');

// IMG

define('LOGOF_PNG', IMG_URL . '/logof.png');
define('MARTINEZ_PNG', IMG_URL . '/martinez.png');