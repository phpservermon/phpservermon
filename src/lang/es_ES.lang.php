<?php
/**
 * PHP Server Monitor
 * Monitor your servers and websites.
 *
 * This file is part of PHP Server Monitor.
 * PHP Server Monitor is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * PHP Server Monitor is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with PHP Server Monitor.  If not, see <http://www.gnu.org/licenses/>.
 *
 * @package     phpservermon
 * @author      Klemens Häckel <http://clickdimension.wordpress.com/>
 * @author      Luis Rodriguez <luis@techreanimate.com>
 * @author 		Mauro Vietri <mauro.vietri@outlook.com>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
	'name' => 'Español - Spanish',
	'locale' => array('es_ES.UTF-8', 'es_ES', 'spanish', 'esp'),
	'locale_tag' => 'es',
	'locale_dir' => 'ltr',
	'system' => array(
		'title' => 'Server Monitor',
		'install' => 'Instalar',
		'action' => 'Acción',
		'save' => 'Guardar',
		'edit' => 'Modificar',
		'delete' => 'Eliminar',
		'date' => 'Fecha',
		'message' => 'Mensaje',
		'yes' => 'Si',
		'no' => 'No',
		'insert' => 'Insertar',
		'add_new' => 'Agregar nuevo',
		'update_available' => 'Hay una nueva versión ({version}) disponible en <a href="http://www.phpservermonitor.org" target="_blank">http://www.phpservermonitor.org</a>.',
		'back_to_top' => 'Volver arriba',
		'go_back' => 'Volver',
		'ok' => 'OK',
		'cancel' => 'Cancel',
		// date/time format according the strftime php function format parameter http://php.net/manual/function.strftime.php
		'short_day_format' => '%B %e',
		'long_day_format' => '%B %e, %Y',
		'yesterday_format' => 'Ayer a las %k:%M',
		'other_day_format' => '%A a las %k:%M',
		'never' => 'Nunca',
		'hours_ago' => 'Hace %d horas',
		'an_hour_ago' => 'Hace aproximadamente una hora',
		'minutes_ago' => 'Hace %d minutos',
		'a_minute_ago' => 'Hace aproximadamente un minuto',
		'seconds_ago' => 'Hace %d segundos',
		'a_second_ago' => 'Hace aproximadamente un segundo',
	),
	'menu' => array(
		'config' => 'Configurar',
		'server' => 'Servidores',
		'server_log' => 'Archivo',
		'server_status' => 'Estado',
		'server_update' => 'Actualizar',
		'user' => 'Usuarios',
		'help' => 'Ayuda',
	),
	'users' => array(
		'user' => 'Usuario',
		'name' => 'Nombre',
		'user_name' => 'Nombre de Usuario',
		'password' => 'Contraseña',
		'password_repeat' => 'Repetir Contraseña',
		'password_leave_blank' => 'Dejar en blanco para mantener sin cambios',
		'level' => 'Nivel',
		'level_10' => 'Administrador',
		'level_20' => 'Usuarios',
		'level_description' => '<b>Administradores</b> tienen acceso completo: pueden administrar servidores, usuarios y editar la configuración global.<br/>Los <b>usuarios</b> sólo pueden ver y ejecutar el programa de actualización para los servidores que se han asignado a los mismos.',
		'mobile' => 'Móvil',
		'email' => 'Email',
		'pushover' => 'Pushover',
		'pushover_description' => 'Pushover es un servicio que hace que sea fácil de obtener notificaciones en tiempo real. Vea <a href="https://pushover.net/"> su página web </a> para más información.',
		'pushover_key' => 'Clave Pushover',
		'pushover_device' => 'Dispositivo Pushover',
		'pushover_device_description' => 'Nombre del dispositivo para enviar el mensaje. Dejar en blanco para enviarlo a todos los dispositivos.',
		'delete_title' => 'Eliminar usuario',
		'delete_message' => '¿Seguro que desea eliminar el usuario \'%1\'?',
		'deleted' => 'Usuario eliminado.',
		'updated' => 'Usuario actualizado.',
		'inserted' => 'Usuario ingresado.',
		'profile' => 'Perfil',
		'profile_updated' => 'Su perfil ha sido actualizado.',
		'error_user_name_bad_length' => 'Los nombres de usuario deben tener entre 2 y 64 caracteres.',
		'error_user_name_invalid' => 'El nombre de usuario sólo puede contener caracteres alfabéticos (a-z, A-Z), números (0-9), puntos (.) y guiones bajos (_).',
		'error_user_name_exists' => 'El nombre de usuario dado ya existe en la base de datos.',
		'error_user_email_bad_length' => 'Direcciones de correo electrónico deben estar entre 5 y 255 caracteres.',
		'error_user_email_invalid' => 'La dirección de correo electrónico no es válida.',
		'error_user_level_invalid' => 'El nivel de usuario dado es válido.',
		'error_user_no_match' => 'El usuario no se pudo encontrar en la base de datos.',
		'error_user_password_invalid' => 'La contraseña introducida no es válida.',
		'error_user_password_no_match' => 'Las contraseñas introducidas no coinciden.',
	),
	'log' => array(
		'title' => 'Registro',
		'type' => 'Tipo',
		'status' => 'Estado',
		'email' => 'Email',
		'sms' => 'SMS',
		'pushover' => 'Pushover',
		'no_logs' => 'No hay journaux',
		'clear' => 'Borrar registro',
		'delete_title' => 'Eliminar registro',
		'delete_message' => '¿Estás seguro de que quieres eliminar <b>todos</b> los registros?',
	),
	'servers' => array(
		'server' => 'Servidores',
		'status' => 'Estado',
		'label' => 'Título',
		'domain' => 'Dominio/IP',
		'timeout' => 'Tiempo de espera',
		'timeout_description' => 'Número de segundos a esperar para que el servidor responda.',
		'port' => 'Puerto',
		'type' => 'Tipo',
		'type_website' => 'Sitio Web',
		'type_service' => 'Servicio',
		'pattern' => 'Cadena de búsqueda / patrón',
		'pattern_description' => 'Si este patrón no se encuentra en el sitio web, el servidor estará marcada como sin conexión. Se permiten expresiones regulares.',
		'last_check' => 'Última verificación',
		'last_online' => 'Última vez en línea',
		'monitoring' => 'Monitoreo',
		'no_monitoring' => 'Sin monitoreo',
		'email' => 'Email',
		'send_email' => 'Email',
		'sms' => 'SMS',
		'send_sms' => 'SMS',
		'pushover' => 'Pushover',
		'users' => 'Usuarios',
		'delete_title' => 'eliminar servidor',
		'delete_message' => '¿Seguro que desea eliminar el servidor \'%1\'?',
		'deleted' => 'Servidor eliminado.',
		'updated' => 'Servidor actualizado.',
		'inserted' => 'Servidor ingresado.',
		'latency' => 'Tiempo de respuesta',
		'latency_max' => 'Tiempo de respuesta (máxima)',
		'latency_min' => 'Tiempo de respuesta (mínima)',
		'latency_avg' => 'Tiempo de respuesta (promedio)',
		'uptime' => 'Activo',
		'year' => 'Año',
		'month' => 'Mes',
		'week' => 'Semana',
		'day' => 'Día',
		'hour' => 'Hora',
		'warning_threshold' => 'Umbral de advertencia',
		'warning_threshold_description' => 'Número de controles fallidos necesarios antes de que se marque como fuera de línea.',
		'chart_last_week' => 'La semana pasada',
		'chart_history' => 'Historia',
		// Charts date format according jqPlot date format  http://www.jqplot.com/docs/files/plugins/jqplot-dateAxisRenderer-js.html
		'chart_day_format' => '%Y-%m-%d',
		'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
		'chart_short_date_format' => '%m/%d %H:%M',
		'chart_short_time_format' => '%H:%M',
		'warning_notifications_disabled_sms' => 'Las notificaciones por SMS están desactivadas.',
		'warning_notifications_disabled_email' => 'Las notificaciones por correo electrónico están desactivados.',
		'warning_notifications_disabled_pushover' => 'Las notificaciones Pushover están desactivadas.',
		'error_server_no_match' => 'Servidor no encontrado.',
		'error_server_label_bad_length' => 'La etiqueta debe estar entre 1 y 255 caracteres.',
		'error_server_ip_bad_length' => 'El dominio / IP debe estar entre 1 y 255 caracteres.',
		'error_server_ip_bad_service' => 'La dirección IP no es válida.',
		'error_server_ip_bad_website' => 'El URL del Sitio Web no es válido.',
		'error_server_type_invalid' => 'El tipo de servidor seleccionado no es válido.',
		'error_server_warning_threshold_invalid' => 'El umbral de advertencia debe ser un entero válido mayor que 0.',
	),
	'config' => array(
		'general' => 'General',
		'language' => 'Idioma',
		'show_update' => '¿Comprobar actualizaciones semanalmente?',
		'email_status' => '¿Habilitar envio de email?',
		'email_from_email' => 'Dirección del Remitente',
		'email_from_name' => 'Nombre del Remitente',
		'email_smtp' => 'Habilitar SMTP',
		'email_smtp_host' => 'Servidor SMTP',
		'email_smtp_port' => 'Puerto SMTP',
		'email_smtp_security' => 'Seguridad SMTP',
		'email_smtp_security_none' => 'Ninguna',
		'email_smtp_username' => 'Usuario SMTP',
		'email_smtp_password' => 'Contraseña SMTP',
		'email_smtp_noauth' => 'Deja en blanco para ninguna autenticación',
		'sms_status' => '¿Habilitar envio de SMS?',
		'sms_gateway' => 'Proveedor de SMS',
		'sms_gateway_mosms' => 'Mosms',
		'sms_gateway_mollie' => 'Mollie',
		'sms_gateway_spryng' => 'Spryng',
		'sms_gateway_inetworx' => 'Inetworx',
		'sms_gateway_clickatell' => 'Clickatell',
        	'sms_gateway_textmarketer' => 'Textmarketer',
		'sms_gateway_smsglobal' => 'SMSGlobal',
		'sms_gateway_octopush' => 'Octopush',
		'sms_gateway_smsit' => 'Smsit',
		'sms_gateway_freevoipdeal' => 'FreeVoipDeal',
		'sms_gateway_username' => 'Usuario',
		'sms_gateway_password' => 'Contraseña',
		'sms_gateway_nexmo' => 'Nexmo',
		'sms_gateway_username' => 'Gateway username',
		'sms_gateway_password' => 'Gateway password',
		'sms_from' => 'Número origen del SMS',
		'pushover_status' => '¿Habilitar el envío de mensajes Pushover?',
		'pushover_description' => 'Pushover es un servicio que hace que sea fácil de obtener notificaciones en tiempo real. Vea <a href="https://pushover.net/"> su página web </a> para más información.',
		'pushover_clone_app' => 'Haga clic aquí para crear tu aplicación Pushover',
		'pushover_api_token' => 'Token API de Pushover',
		'pushover_api_token_description' => 'Antes de poder utilizar Pushover, necesita <a href="%1$s" target="_blank"> registrar </a> su aplicación en la página web e ingresar el token API.',
		'alert_type' => '¿Cuándo desea recibir notificaciones ?',
        'alert_type_description' => '<b>...  Al cambiar el estado:</b> '.
		    'p.ej. en línea -> fuera de línea o fuera de línea -> en línea.<br/>'.
		    '<br /><b>Fuera de Línea:</b> '.
		    'Recibirá una notificación cuando el servidor esté fuera de línea.'.
		    'Se envia un sólo mensaje cuando se detecte la caída por primera vez.<br/>'.
		    '<br><b>Siempre:</b> '.
		    'Se le enviará una notificación cada vez que se ejecuta el script '.
		    'aunqué el servicio puede haber estado fuera de línea por varias horas.',
		'alert_type_status' => 'Cambio de estado',
		'alert_type_offline' => 'Fuera de Línea',
		'alert_type_always' => 'Siempre',
		'log_status' => 'Log de Estados',
		'log_status_description' => 'Al setear TRUE (marcar) se registrarán todos los estados.',
		'log_email' => 'Registrar emails enviados en el Log',
		'log_sms' => 'Registrar sms enviados en el Log',
		'log_pushover' => 'Registrar notificaciones Pushover enviadas en el Log',
		'updated' => 'Configuración guardada.',
		'tab_email' => 'Email',
		'tab_sms' => 'SMS',
		'tab_pushover' => 'Pushover',
		'settings_email' => 'Email',
		'settings_sms' => 'Mensaje SMS',
		'settings_pushover' => 'Configuración de Pushover',
		'settings_notification' => 'Notificación',
		'settings_log' => 'Log',
		'auto_refresh' => 'Refrescar automáticamente la página de servidores',
		'auto_refresh_servers' =>
			'Refrescar automáticamente la página de servidores.<br/>'.
			'<span class="small">'.
			'Tiempo en segundos, indicar "0" para no actualizar.'.
			'</span>',
		'seconds' => 'segundos',
		'test' => 'Prueba',
		'test_email' => 'Un correo electrónico será enviado a la dirección especificada en su perfil de usuario.',
		'test_sms' => 'Un SMS se enviará al número de teléfono especificado en su perfil de usuario.',
		'test_pushover' => 'Una notificación Pushover será enviado a la clave de usuario / dispositivo especificado en su perfil de usuario.',
		'send' => 'Enviar',
		'test_subject' => 'Test',
		'test_message' => 'Mensaje de prueba',
		'email_sent' => 'Email enviado',
		'email_error' => 'Error al enviar el email',
		'sms_sent' => 'SMS enviado',
		'sms_error' => 'Error al enviar el SMS. %s',
		'sms_error_nomobile' => 'No se puede enviar SMS de prueba: no hay ningún número de teléfono válido en su perfil.',
		'pushover_sent' => 'Notificación Pushover enviada',
		'pushover_error' => 'Error al enviar la notificación Pushover: %s',
		'pushover_error_noapp' => 'No se puede enviar una notificación de prueba: no existe un token API de Pushover en la configuración global.',
		'pushover_error_nokey' => 'No se puede enviar una notificación de prueba: no existe ninguna clave de Pushover en su perfil.',
		'log_retention_period' => 'Período de retención del Log',
		'log_retention_period_description' => 'Número de días que se conservan registros de las notificaciones y los archivos de tiempo de actividad del servidor. Introduzca 0 para desactivar la limpieza de los registros.',
		'log_retention_days' => 'días',
	),
	// for newlines in the email messages use <br/>
	'notifications' => array(
		'off_sms' => 'Servidor \'%LABEL%\' está fuera de línea: ip=%IP%, puerto=%PORT%. error=%ERROR%',
		'off_email_subject' => 'Importante: Servidor \'%LABEL%\' está fuera de línea',
		'off_email_body' => "No posible conectar al servidor:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Puerto: %PORT%<br/>Error: %ERROR%<br/>Fecha: %DATE%",
		'off_pushover_title' => 'Servidor \'%LABEL%\' está fuera de línea',
		'off_pushover_message' => "No posible conectar al servidor:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Puerto: %PORT%<br/>Error: %ERROR%<br/>Fecha: %DATE%",
		'on_sms' => 'Servidor \'%LABEL%\' ya está de nuevo funcionando en línea: ip=%IP%, puerto=%PORT%',
		'on_email_subject' => 'Importante: Servidor \'%LABEL%\' ya está de nuevo en línea',
		'on_email_body' => "Servidor '%LABEL%' ya está funcionando en línea de nuevo:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Puerto: %PORT%<br/>Fecha: %DATE%",
		'on_pushover_title' => 'Servidor \'%LABEL%\' ya está de nuevo en línea',
		'on_pushover_message' => "Servidor '%LABEL%' ya está funcionando en línea de nuevo:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Puerto: %PORT%<br/>Fecha: %DATE%",
	),
	'login' => array(
		'welcome_usermenu' => 'Bienvenido, %user_name%',
		'title_sign_in' => 'Por favor, inicie sesión',
		'title_forgot' => '¿Olvidaste tu contraseña?',
		'title_reset' => 'Restablecer su contraseña',
		'submit' => 'Enviar',
		'remember_me' => 'Acuérdate de mí',
		'login' => 'Iniciar sesión',
		'logout' => 'Salir',
		'username' => 'Nombre de usuario',
		'password' => 'Contraseña',
		'password_repeat' => 'Repita la contraseña',
		'password_forgot' => '¿Has olvidado tu contraseña?',
		'password_reset' => 'Perdí mi contraseña',
		'password_reset_email_subject' => 'Restablecer la contraseña para PHP Server Monitor',
		'password_reset_email_body' => 'Utilice el siguiente enlace para restablecer tu contraseña. Tenga en cuenta que expira de 1 hora.<br/><br/>%link%',
		'error_user_incorrect' => 'El nombre de usuario proporcionado no se pudo encontrar.',
		'error_login_incorrect' => 'La información es incorrecta.',
		'error_login_passwords_nomatch' => 'Las contraseñas proporcionadas no coinciden.',
		'error_reset_invalid_link' => 'El vínculo de cambio que ya ha proporcionado no es válido.',
		'success_password_forgot' => 'Un correo electrónico ha sido enviado a usted con información de cómo restablecer su contraseña.',
		'success_password_reset' => 'Su contraseña ha sido restablecida correctamente. Por favor, inicia sesión.',
	),
	'error' => array(
		'401_unauthorized' => 'No Autorizado',
		'401_unauthorized_description' => 'Usted no tiene los privilegios para ver esta página.',
	),
);
