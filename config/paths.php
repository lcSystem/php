<?php
// config/paths.php

// Base del proyecto ---------------------------------------------------------------------------------------------------------------------------------------
define('BASE_URL', '/plantilla');

// directorios Assets --------------------------------------------------------------------------------------------------------------------------------------
define('ASSETS_URL', BASE_URL . '/assets');
define('CONFIG', BASE_URL . '/config');
define('CSS_URL', ASSETS_URL . '/css');
define('WEBFONT_URL', ASSETS_URL . '/webfont');
define('JS_URL', ASSETS_URL . '/js');
define('IMG_URL', ASSETS_URL . '/img');
define('IMG_UPLOADS_URL', IMG_URL . '/uploads');
define('CP_COMPONENTS', BASE_URL . '/components');
define('CP_MODALS', CP_COMPONENTS . '/modalComponent.js');

// directorios de estructura -------------------------------------------------------------------------------------------------------------------------------
define('VIEWS_URL', BASE_URL . '/views');
define('CONTROLLER_URL', BASE_URL . '/controller');
define('MODELS_URL', BASE_URL . '/models');

// Views ---------------------------------------------------------------------------------------------------------------------------------------------------
define('DASHBOARD_URL', VIEWS_URL . '/dashboard.php');                            define('PERFIL_VIEW', VIEWS_URL . '/perfil/perfil.php');
define('DASHBOARD_VIEW', VIEWS_URL . '/dashboard.php');                           define('USERS_VIEW', VIEWS_URL . '/users/users.php');
define('APP_VIEW', VIEWS_URL . '/aplicaciones/app.php');                          define('INDICADOR_VIEW', VIEWS_URL . '/indicador/indicador.php');

// Archivos específicos (opcional) -------------------------------------------------------------------------------------------------------------------------
define('LOGIN_PAGE', BASE_URL . '/login.php');                                    define('WELCOME_PAGE', BASE_URL . '/welcome.php');


// Controllers ---------------------------------------------------------------------------------------------------------------------------------------------
define('PERFIL_CONTROLLER', CONTROLLER_URL . '/perfil/perfilController.php');    define('LOGIN_CONTROLLER', CONTROLLER_URL . '/loginController.php');
define('LOGOUT_CONTROLLER', CONTROLLER_URL . '/logout.php');                     define('REGISTRO_CONTROLLER', CONTROLLER_URL . '/registroController.php');
define('USER_CONTROLLER', CONTROLLER_URL . '/userController.php');

// models --------------------------------------------------------------------------------------------------------------------------------------------------

define('USER_MODEL', MODELS_URL . '/userModel.php');

// fonts ----------------------------------------------------------------------------------------------------------------------------------------
define('TTF_BRANDS', WEBFONT_URL . '/fa-brands-400.ttf');                       define('WOF_BRANDS', WEBFONT_URL . '/fa-brands-400.woff2');
define('TTF_REGULAR', WEBFONT_URL . '/fa-regular-400.ttf');                     define('WOF_REGULAR', WEBFONT_URL . '/fa-regular-400.woff2');
define('TTF_SOLID', WEBFONT_URL . '/fa-solid-900.ttf');                         define('WOF_SOLID', WEBFONT_URL . '/fa-solid-900.woff2');


// Otros assets que quieras centralizar
// CSS ------------------------------------------------------------------------------------------------------------------------------------------
define('ALERTAS_CSS', CSS_URL . '/alertas.css');                                define('ALERTIFY_CSS', CSS_URL . '/alertify.min.css');
define('BOOTSTRAP_CSS', CSS_URL . '/bootstrap.min.css');                        define('UÑAS_CSS', CSS_URL . '/uñas.css');
define('NOTIFY_CSS', CSS_URL . '/Notification.css');                            define('CSS2_CSS', CSS_URL . '/css2.css');
define('ALL_CSS', CSS_URL . '/all.min.css');                                    define('LOGIN_CSS', CSS_URL . '/login.css');
define('MODAL_LOG_CSS', CSS_URL . '/modal-log.css');                            define('STYLEUSER_CSS', CSS_URL . '/styleUser.css');
define('PERFIL_CSS', CSS_URL . '/perfil.css');                                  define('MODALEDIT_CSS', CSS_URL . '/modal_edit.css');
define('JQUERY_DATAT_CSS', CSS_URL . '/jquery.dataTables.min.css');             define('FLATPICKR_CSS', CSS_URL . '/flatpickr.min.css');
define('STYLEBUTTONS_CSS', CSS_URL . '/styleButtons.css');

// JS --------------------------------------------------------------------------------------------------------------------------------------------
define('LOGIN_JS', JS_URL . '/login.js');                                       define('NOTIFY_JS', JS_URL . '/notifications.js');
define('BUNDLET_JS', JS_URL . '/bootstrap.bundle.min.js');                      define('DATATABLE_JS', JS_URL . '/dataTables.responsive.min.js');
define('JQUERY_JS', JS_URL . '/jquery-3.6.4.min.js');                           define('SWET_JS', JS_URL . '/sweetalert2@11.js');
define('ALERTA_JS', JS_URL . '/alertas.js');                                    define('ALERTFY_JS', JS_URL . '/alertify.min.js');
define('FLATPICKR_JS', JS_URL . '/flatpickr.js');                               define('JQUERY_DT_JS', JS_URL . '/jquery.dataTables.min.js');
define('USEREGISTER_JS', JS_URL . '/userRegister.js');                          define('T_MENU_JS', JS_URL . '/togel_menu.js');
define('CITA_JS', JS_URL . '/citas/citas.js'); 
// IMG --------------------------------------------------------------------------------------------------------------------------------------------

define('LOGOF_PNG', IMG_URL . '/logof.png');                                    define('MARTINEZ_PNG', IMG_URL . '/martinez.png');
																																					
//-------------------------------------------------------------------------------------------------------------------------------------------------