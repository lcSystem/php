<?php
// config/paths.php

// Base del proyecto ---------------------------------------------------------------------------------------------------------------------------------------
define('BASE_URL', '/plantilla');

define('BASE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/plantilla');
// directorios Assets --------------------------------------------------------------------------------------------------------------------------------------
define('ASSETS_URL', BASE_URL . '/assets');                      define('CONFIG', BASE_URL . '/config');
define('CSS_URL', ASSETS_URL . '/css');                          define('WEBFONT_URL', ASSETS_URL . '/webfont');
define('JS_URL', ASSETS_URL . '/js');                            define('IMG_URL', ASSETS_URL . '/img');
define('IMG_UPLOADS_URL', IMG_URL . '/uploads');                 

// directorios de estructura -------------------------------------------------------------------------------------------------------------------------------
define('VIEWS_PATH', BASE_PATH . '/views');				 define('VIEWS_URL', BASE_URL . '/views');
define('CONTROLLER_PATH', BASE_PATH . '/controller');    define('CONTROLLER_URL', BASE_URL . '/controller');
define('MODELS_PATH', BASE_PATH . '/models');            define('MODELS_URL', BASE_URL . '/models');
define('HELPER_PATH', BASE_PATH . '/helpers');            define('HELPER_URL', BASE_URL . '/helpers');
define('CP_COMPONENTS_PATH', BASE_PATH . '/components');  define('UT_UTILIDADES', BASE_PATH . '/utilidades');
define('CP_COMPONENTS', BASE_URL . '/components');        define('UT_UTILIDADES_URL', BASE_URL . '/utilidades');

// Views ---------------------------------------------------------------------------------------------------------------------------------------------------
define('DASHBOARD_URL', VIEWS_URL . '/dashboard.php');                            define('PERFIL_VIEW', VIEWS_PATH . '/perfil/perfil.php');
define('otr_VIEW', VIEWS_PATH . '/.php');                                         define('USERS_VIEW', VIEWS_PATH . '/users/users.php');
define('CITAS_VIEW', VIEWS_PATH . '/citas/citas.php');                            define('FORMULARIO_VIEW', VIEWS_PATH . '/formulario/formulario.php');
define('CONFIG_VIEW', VIEWS_PATH . '/config/config.php');                         define('DASHBOARD_PATH', VIEWS_PATH . '/dashboard.php');
define('SERVICIOS_VIEW', VIEWS_PATH . '/servicios/servicios.php');

// Archivos específicos (opcional) -------------------------------------------------------------------------------------------------------------------------
 define('LOGIN_PAGE', BASE_URL . '/login.php');                                    define('WELCOME_PAGE', BASE_URL . '/welcome.php');
 define('CP_TABLE', CP_COMPONENTS_PATH . '/tableComponent.php');                  define('CP_MODALS', CP_COMPONENTS . '/modalComponent.js');
 define('UT_UTILIDADES_JS', UT_UTILIDADES_URL . '/utilidadesJS.js');              define('UT_UTILIDADES_PHP', UT_UTILIDADES . '/utilidadesPHP.php');
 define('HP_DOMPETICION', HELPER_URL . '/DomPeticionHelper.js');
// Controllers ---------------------------------------------------------------------------------------------------------------------------------------------
define('SERVICIO_CONTROLLER_URL', CONTROLLER_URL . '/servicios/serviciosController.php');  define('CITAS_CONTROLLER', CONTROLLER_PATH . '/citas/citasController.php');
define('LOGOUT_CONTROLLER', CONTROLLER_URL . '/logout.php');                           define('REGISTRO_CONTROLLER', CONTROLLER_PATH . '/usuario/registroController.php');
                                                                                       define('USER_CONTROLLER', CONTROLLER_PATH . '/usuario/userController.php');  
define('PERFIL_CONTROLLER_URL', CONTROLLER_URL . '/perfil/perfilController.php');      define('PERFIL_CONTROLLER', CONTROLLER_PATH . '/perfil/perfilController.php');
define('USER_CONTROLLER_URL', CONTROLLER_URL . '/usuario/userController.php');         define('LOGIN_CONTROLLER', CONTROLLER_PATH . '/loginController.php');
define('CITAS_CONTROLLER_URL', CONTROLLER_URL . '/citas/citasController.php');      define('SERVICIO_CONTROLLER', CONTROLLER_PATH . '/servicios/serviciosController.php');
// models --------------------------------------------------------------------------------------------------------------------------------------------------

define('USER_MODEL', MODELS_PATH . '/userModel.php');   						   define('REGISTER_MODEL', MODELS_PATH . '/userRegisterModel.php');
define('CITAS_MODEL', MODELS_PATH . '/citas/citasModel.php');                      define('SERVICIOS_MODEL', MODELS_PATH . '/servicios/serviciosModel.php');

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
define('PERFIL_CSS', CSS_URL . '/perfil.css');                                  define('MODALEDIT_CSS', CSS_URL . '/modalComponent.css');
define('JQUERY_DATAT_CSS', CSS_URL . '/jquery.dataTables.min.css');             define('FLATPICKR_CSS', CSS_URL . '/flatpickr.min.css');
define('STYLEBUTTONS_CSS', CSS_URL . '/styleButtons.css');                      define('RESPONSIVEDT_CSS', CSS_URL . '/responsive.dataTables.min.css');

// JS --------------------------------------------------------------------------------------------------------------------------------------------
define('LOGIN_JS', JS_URL . '/login.js');                                       define('NOTIFY_JS', JS_URL . '/notifications.js');
define('BUNDLET_JS', JS_URL . '/bootstrap.bundle.min.js');                      define('DATATABLE_JS', JS_URL . '/dataTables.responsive.min.js');
define('JQUERY_JS', JS_URL . '/jquery-3.6.4.min.js');                           define('SWET_JS', JS_URL . '/sweetalert2@11.js');
define('ALERTA_JS', JS_URL . '/alertas.js');                                    define('ALERTFY_JS', JS_URL . '/alertify.min.js');
define('FLATPICKR_JS', JS_URL . '/flatpickr.js');                               define('JQUERY_DT_JS', JS_URL . '/jquery.dataTables.min.js');
                          define('T_MENU_JS', JS_URL . '/togel_menu.js');
define('CITA_JS', JS_URL . '/citas/citas.js');                                  define('SERVICIOS_JS', JS_URL . '/servicios/servicios.php'); 
 define('CONST_JS', HELPER_PATH . '/const_js/const_js.php'); 
// IMG --------------------------------------------------------------------------------------------------------------------------------------------
	
define('LOGOF_PNG', IMG_URL . '/logof.png');                                    define('MARTINEZ_PNG', IMG_URL . '/martinez.png');
																				define('ICONO_ICO', IMG_URL . '/favico.ico');					
//-------------------------------------------------------------------------------------------------------------------------------------------------