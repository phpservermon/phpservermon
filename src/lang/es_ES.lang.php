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
 * @author      Mauro Vietri <mauro.vietri@outlook.com>
 * @author      Federico Vera <fede@riddler.com.ar>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Español - Spanish',
    'locale' => array(
        '0' => 'es_ES.UTF-8',
        '1' => 'es_ES',
        '2' => 'spanish',
        '3' => 'esp',
    ),
    'locale_tag' => 'es',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Instalar',
        'action' => 'Acción',
        'save' => 'Guardar',
        'edit' => 'Modificar',
        'delete' => 'Eliminar',
        'view' => 'Ver',
        'date' => 'Fecha',
        'message' => 'Mensaje',
        'yes' => 'Si',
        'no' => 'No',
        'insert' => 'Insertar',
        'add_new' => 'Agregar nuevo',
        'update_available' => 'Hay una nueva versión ({version}) disponible en <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Volver arriba',
        'go_back' => 'Volver',
        'ok' => 'Bueno',
        'bad' => 'Malo',
        'cancel' => 'Cancelar',
        'none' => 'None',
        'activate' => 'Activar',
        'short_day_format' => '%e de %B',
        'long_day_format' => '%e de %B de %Y',
        'yesterday_format' => 'Ayer a las %k:%M',
        'other_day_format' => '%A a las %k:%M',
        'never' => 'Nunca',
        'hours_ago' => 'Hace %d horas',
        'an_hour_ago' => 'Hace aproximadamente una hora',
        'minutes_ago' => 'Hace %d minutos',
        'a_minute_ago' => 'Hace aproximadamente un minuto',
        'seconds_ago' => 'Hace %d segundos',
        'a_second_ago' => 'Hace aproximadamente un segundo',
        'year' => 'año',
        'years' => 'años',
        'month' => 'mes',
        'months' => 'meses',
        'day' => 'día',
        'days' => 'días',
        'hour' => 'hora',
        'hours' => 'horas',
        'minute' => 'minuto',
        'minutes' => 'minutos',
        'second' => 'segundo',
        'seconds' => 'segundos',
        'current' => 'actual',
        'settings' => 'Configuración',
        'search' => 'Buscar',
    ),
    'menu' => array(
        'config' => 'Configurar',
        'server' => 'Servidores',
        'server_log' => 'Registro',
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
        'level_description' => '<b>Administradores</b> tienen acceso completo: pueden administrar servidores, usuarios
 y editar la configuración global.<br>Los <b>usuarios</b> sólo pueden ver y ejecutar
 el programa de actualización para los servidores que se han asignado a los mismos.',
        'mobile' => 'Móvil',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover es un servicio que hace que sea fácil de obtener notificaciones en tiempo
 real. Vea <a href="https://pushover.net/" target="_blank"> su página web </a> para
 más información.',
        'pushover_key' => 'Clave Pushover',
        'pushover_device' => 'Dispositivo Pushover',
        'pushover_device_description' => 'Nombre del dispositivo para enviar el mensaje. Dejar en blanco para enviarlo
 a todos los dispositivos.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> is a chat app that
 makes it easy to get real-time notifications. Visit the <a
 href="http://docs.phpservermonitor.org/" target="_blank">documentation</a> for more
 info and an install guide.',
        'telegram_chat_id' => 'Telegram chat id',
        'telegram_chat_id_description' => 'El mensaje será enviado al chat correspondiente.',
        'telegram_get_chat_id' => 'Haga click aquí para obtener su chat id',
        'activate_telegram' => 'Activar las notificaciones de Telegram',
        'activate_telegram_description' => 'Permitir a Telegram enviar notificaciones al chat id especificado. Sin
 este permiso, Telegram no podrá enviarle mensajes.',
        'telegram_bot_username_found' => '¡El bot fue encontrado!<br><a href="%s" target="_blank"
 rel="noopener"><button class="btn btn-primary">Próximo paso</button></a>
 <br>Esto abrirá un chat con el bot. Necesita presionar start o escribir
 /start.',
        'telegram_bot_username_error_token' => '401 - No autorizado. Por favor asegúrese que el Token es válido.',
        'telegram_bot_error' => 'Ocurrió un error activando las notificaciones de Telegram: %s',
        'delete_title' => 'Eliminar usuario',
        'delete_message' => 'Realmente desea eliminar el usuario \'%1\'?',
        'deleted' => 'Usuario eliminado.',
        'updated' => 'Usuario actualizado.',
        'inserted' => 'Usuario ingresado.',
        'profile' => 'Perfil',
        'profile_updated' => 'Su perfil ha sido actualizado.',
        'error_user_name_bad_length' => 'Los nombres de usuario deben tener entre 2 y 64 caracteres.',
        'error_user_name_invalid' => 'El nombre de usuario sólo puede contener caracteres alfabéticos (a-z, A-Z),
 números (0-9), puntos (.) y guiones bajos (_).',
        'error_user_name_exists' => 'El nombre de usuario dado ya existe en la base de datos.',
        'error_user_email_bad_length' => 'Direcciones de correo electrónico deben estar entre 5 y 255 caracteres.',
        'error_user_email_invalid' => 'La dirección de correo electrónico no es válida.',
        'error_user_level_invalid' => 'El nivel de usuario dado es inválido.',
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
        'telegram' => 'Telegram',
        'no_logs' => 'No hay registros',
        'clear' => 'Borrar registros',
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
        'authentication_settings' => 'Configuración de autenticación',
        'optional' => 'Opcional',
        'website_username' => 'Nombre de usuario',
        'website_username_description' => 'Nombre de usuario para acceder al sitio. (Solo se soporta la autenticación
 de Apache.)',
        'website_password' => 'Contraseña',
        'website_password_description' => 'Contraseña para acceder al sitio. La contraseña se almacenará encriptada
 en la base de datos.',
        'fieldset_monitoring' => 'Monitoreo',
        'fieldset_permissions' => 'Permisos',
        'permissions' => 'El servidor será visible para los siguientes usuarios',
        'port' => 'Puerto',
        'custom_port' => 'Puerto personalizado',
        'popular_ports' => 'Puertos comunes',
        'request_method' => 'Método',
        'custom_request_method' => 'Método personalizado',
        'popular_request_methods' => 'Método común',
        'post_field' => 'Post field',
        'post_field_description' => 'Los datos que serán enviado utilizando el método especificado.',
        'please_select' => 'Por favor seleccionar',
        'type' => 'Tipo',
        'type_website' => 'Sitio Web',
        'type_service' => 'Servicio',
        'type_ping' => 'Ping',
        'pattern' => 'Patrón/texto de búsqueda',
        'pattern_description' => 'Si el patrón no se encuentra en el sitio, se marcará al servidor como en
 línea/fuera de línea. Se permiten expresiones regulares.',
        'pattern_online' => 'El patrón indica si el servidor está:',
        'pattern_online_description' => 'En línea: Si el patrón encuentra en el sitio, se marcará al servidor como
 en línea. Fuera de línea: Si el patrón no se encutra en el sitio, se
 marcará al servidor como furea de línea.',
        'redirect_check' => 'Redirigir a otra dirección es:',
        'redirect_check_description' => 'Redirigir normalmente es una mala señal.',
        'allow_http_status' => 'Permitir revisar el código de estado HTTP',
        'allow_http_status_description' => 'Marcar el sitio como en línea. Los estados HTTP menores que 400 son
 marcados como en línea por defecto. Separar con |.',
        'header_name' => 'Nombre del encabezado',
        'header_value' => 'Valor del encabezado',
        'header_name_description' => 'Respetar mayúsculas y minúsculas.',
        'header_value_description' => 'Se permiten expresiones regulares.',
        'last_check' => 'Último control',
        'last_online' => 'Última vez en línea',
        'last_offline' => 'Última vez fuera de línea',
        'last_output' => 'Última salida',
        'last_error' => 'Último error',
        'last_error_output' => 'Último error',
        'output' => 'Salida',
        'monitoring' => 'Monitoreado',
        'no_monitoring' => 'No monitoreando',
        'email' => 'Email',
        'send_email' => 'Enviar correo electrónico',
        'sms' => 'SMS',
        'send_sms' => 'Eviar SMS',
        'pushover' => 'Pushover',
        'send_pushover' => 'Enviar notificación por Pushover',
        'telegram' => 'Telegram',
        'send_telegram' => 'Enviar notificación por Telegram',
        'users' => 'Usuarios',
        'delete_title' => 'Eliminar servidor',
        'delete_message' => '¿Seguro que desea eliminar el servidor \'%1\'?',
        'deleted' => 'Servidor eliminado.',
        'updated' => 'Servidor actualizado.',
        'inserted' => 'Servidor ingresado.',
        'latency' => 'Latencia',
        'latency_max' => 'Latencia (máximo)',
        'latency_min' => 'Latencia (mínimo)',
        'latency_avg' => 'Latencia (promedio)',
        'online' => 'en línea',
        'offline' => 'fuera de línea',
        'uptime' => 'Activo',
        'year' => 'Año',
        'month' => 'Mes',
        'week' => 'Semana',
        'day' => 'Día',
        'hour' => 'Hora',
        'warning_threshold' => 'Umbral de advertencia',
        'warning_threshold_description' => 'Número de controles fallidos necesarios antes de que se marque como fuera
 de línea.',
        'chart_last_week' => 'Última semana',
        'chart_history' => 'Historial',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%m/%d %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Las notificaciones por SMS están desactivadas.',
        'warning_notifications_disabled_email' => 'Las notificaciones por correo electrónico están desactivados.',
        'warning_notifications_disabled_pushover' => 'Las notificaciones Pushover están desactivadas.',
        'warning_notifications_disabled_telegram' => 'Las notificaciones Telegram están desactivadas.',
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
        'show_update' => '¿Comprobar actualizaciones?',
        'password_encrypt_key' => 'Clave cripográfica',
        'password_encrypt_key_note' => 'Esta es la clave utilizada para encriptar las contraseñas de acceso a los
 servidores. ¡Si la contraseña cambia las credenciales serán inválidas!',
        'proxy' => 'Activar Proxy',
        'proxy_url' => 'URL del proxy',
        'proxy_user' => 'Usuario',
        'proxy_password' => 'Contraseña',
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
        'sms_gateway_username' => 'Usuario',
        'sms_gateway_password' => 'Contraseña',
        'sms_from' => 'Número origen del SMS',
        'pushover_status' => '¿Habilitar el envío de mensajes Pushover?',
        'pushover_description' => 'Pushover es un servicio que hace que sea fácil de obtener notificaciones en tiempo
 real. Vea <a href="https://pushover.net/" target="_blank"> su página web </a> para
 más información.',
        'pushover_clone_app' => 'Haga clic aquí para crear tu aplicación Pushover',
        'pushover_api_token' => 'Token API de Pushover',
        'pushover_api_token_description' => 'Antes de poder utilizar Pushover, necesita <a href="%1$s" target="_blank"
 rel="noopener"> registrar </a> su aplicación en la página web e
 ingresar el token API.',
        'telegram_status' => '¿Habilitar el envío de mensajes de Telegram?',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> es una aplicación de
 mensajería instantánea que permite recibir notificaciones en tiempo real. Visite
 la <a href="http://docs.phpservermonitor.org/" target="_blank">documentación</a>
 para una guía mas detallada.',
        'telegram_api_token' => 'Token API de Telegram',
        'telegram_api_token_description' => 'Antes de utilizar Telegram, necesita un Token de API. Visite la <a
 href="http://docs.phpservermonitor.org/"
 target="_blank">documentación</a> para más información.',
        'alert_type' => '¿Cuándo desea recibir notificaciones?',
        'alert_type_description' => '<b>Al cambiar el estado:</b> p.ej. en línea -> fuera de línea o fuera de línea
 -> en línea.<br><br /><b>Fuera de Línea:</b> Recibirá una notificación cuando
 el servidor esté fuera de línea.Se envia un sólo mensaje cuando se detecte la
 caída por primera vez.<br><br><b>Siempre:</b> Se le enviará una notificación
 cada vez que se ejecuta el script aunqué el servicio puede haber estado fuera de
 línea por varias horas.',
        'alert_type_status' => 'Cambio de estado',
        'alert_type_offline' => 'Fuera de Línea',
        'alert_type_always' => 'Siempre',
        'combine_notifications' => 'Combinar notificaciones',
        'combine_notifications_description' => 'Reduce la cantidad de notificaciones combinando los mensajes en una
 sola notificación. (Esto no afecta a las notificaciones por SMS.)',
        'alert_proxy' => 'Incluso si está activo, los proxy no se utilizarán para los servicios.',
        'alert_proxy_url' => 'Formato: host:puerto',
        'log_status' => 'Registro de estados',
        'log_status_description' => 'Al setear TRUE (marcar) se registrarán todos los estados.',
        'log_email' => 'Guardar emails enviados en el registro',
        'log_sms' => 'Guardar SMS enviados en el registro',
        'log_pushover' => 'Guardar notificaciones Pushover enviadas en el registro',
        'log_telegram' => 'Guardar notificaciones Telegram enviadas en el registro',
        'updated' => 'Configuración guardada.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'Configuración de Correo Electrónico',
        'settings_sms' => 'Configuración de Mensajes de Texto',
        'settings_pushover' => 'Configuración de Pushover',
        'settings_telegram' => 'Configuración de Telegram',
        'settings_notification' => 'Configuración de las notificaciones',
        'settings_log' => 'Configuración de registros',
        'settings_proxy' => 'Configuración del proxy',
        'auto_refresh' => 'Auto-actualizar',
        'auto_refresh_description' => 'Auto-actualizar la página de servidores.<br><span class="small">Tiempo en
 segundos, si se utiliza 0 la página no se actualizará.</span>',
        'test' => 'Prueba',
        'test_email' => 'Un correo electrónico será enviado a la dirección especificada en su perfil de usuario.',
        'test_sms' => 'Un SMS se enviará al número de teléfono especificado en su perfil de usuario.',
        'test_pushover' => 'Una notificación Pushover será enviada a la clave de usuario / dispositivo especificado
 en su perfil de usuario.',
        'test_telegram' => 'Una notificación de Telegram será enviada al chat id especificado en su perfil de
 usuario.',
        'send' => 'Enviar',
        'test_subject' => 'Prueba',
        'test_message' => 'Mensaje de prueba',
        'email_sent' => 'Correo enviado',
        'email_error' => 'Error al enviar el correo',
        'sms_sent' => 'SMS enviado',
        'sms_error' => 'Error al enviar el SMS: %s',
        'sms_error_nomobile' => 'Imposible enviar el SMS: no se encontró un número de teléfono válido en su
 perfil.',
        'pushover_sent' => 'Notificación de Pushover enviada',
        'pushover_error' => 'Ocurrió un error enviado la notificación de Pushover: %s',
        'pushover_error_noapp' => 'No se puede enviar una notificación de prueba: no existe un token API de Pushover
 en la configuración global.',
        'pushover_error_nokey' => 'No se puede enviar una notificación de prueba: no existe ninguna clave de Pushover
 en su perfil.',
        'telegram_sent' => 'Notificación de Telegram enviada',
        'telegram_error' => 'Ocurrió un error enviado la notificación de Telegram: %s',
        'telegram_error_notoken' => 'Imposible enviar la notificación: No se encontró un Token de API en la
 configuración global.',
        'telegram_error_noid' => 'Imposible enviar la notificación: No se encontró un chat id en su perfil.',
        'log_retention_period' => 'Período de retención del registro',
        'log_retention_period_description' => 'Número de días que se conservan registros de las notificaciones y los
 archivos de tiempo de actividad del servidor. Introduzca 0 para
 desactivar la limpieza de los registros.',
        'log_retention_days' => 'días',
    ),
    'notifications' => array(
        'off_sms' => 'Servidor \'%LABEL%\' está fuera de línea: ip=%IP%, puerto=%PORT%. error=%ERROR%',
        'off_email_subject' => 'Importante: Servidor \'%LABEL%\' está fuera de línea',
        'off_email_body' => 'Imposible conectar al servidor:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Puerto:
 %PORT%<br/>Error: %ERROR%<br/>Fecha: %DATE%',
        'off_pushover_title' => 'Servidor \'%LABEL%\' está fuera de línea',
        'off_pushover_message' => 'No posible conectar al servidor:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Puerto: %PORT%<br/>Error: %ERROR%<br/>Fecha: %DATE%',
        'off_telegram_message' => 'No posible conectar al servidor:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Puerto: %PORT%<br/>Error: %ERROR%<br/>Fecha: %DATE%',
        'on_sms' => 'Servidor \'%LABEL%\' ya está de nuevo funcionando en línea: ip=%IP%, puerto=%PORT%, la
 duración de la caída fue de %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'Importante: Servidor \'%LABEL%\' ya está de nuevo en línea',
        'on_email_body' => 'Servidor \'%LABEL%\' ya está funcionando en línea de nuevo, la duración de la caída
 fue de %LAST_OFFLINE_DURATION%:<br/><br/>Servidor: %LABEL%<br/>IP: %IP%<br/>Puerto:
 %PORT%<br/>Fecha: %DATE%',
        'on_pushover_title' => 'Servidor \'%LABEL%\' ya está de nuevo en línea',
        'on_pushover_message' => 'Servidor \'%LABEL%\' ya está funcionando en línea de nuevo, la duración de la
 caída fue de %LAST_OFFLINE_DURATION%:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Puerto: %PORT%<br/>Fecha: %DATE%',
        'on_telegram_message' => 'Servidor \'%LABEL%\' ya está funcionando en línea de nuevo, la duración de la
 caída fue de %LAST_OFFLINE_DURATION%:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Puerto: %PORT%<br/>Fecha: %DATE%',
        'combi_off_email_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Puerto: %PORT%</li><li>Error:
 %ERROR%</li><li>Fecha: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Puerto:
 %PORT%</li><li>Error: %ERROR%</li><li>Fecha: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- Servidor: %LABEL%<br>- IP: %IP%<br>- Puerto: %PORT%<br>- Error:
 %ERROR%<br>- Fecha: %DATE%<br><br>',
        'combi_on_email_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Puerto:
 %PORT%</li><li>Duración de la caída: %LAST_OFFLINE_DURATION%</li><li>Fecha:
 %DATE%</li></ul>',
        'combi_on_pushover_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Puerto:
 %PORT%</li><li>Duración de la caída: %LAST_OFFLINE_DURATION%</li><li>Fecha:
 %DATE%</li></ul>',
        'combi_on_telegram_message' => '- Servidor: %LABEL%<br>- IP: %IP%<br>- Puerto: %PORT%<br>- Duración de la
 caída: %LAST_OFFLINE_DURATION%<br>- Fecha: %DATE%<br><br>',
        'combi_email_subject' => 'IMPORTANTE: %UP% servidores están en línea, %DOWN% servidores están ahora fuera
 de línea',
        'combi_pushover_subject' => '%UP% servidores están en línea, %DOWN% servidores están ahora fuera de línea',
        'combi_email_message' => '<b>Los siguentes servidores están fuera de línea:</b><br>%DOWN_SERVERS%<br><b>Los
 siguientes servidores están en línea:</b><br>%UP_SERVERS%',
        'combi_pushover_message' => '<b>Los siguentes servidores están fuera de
 línea:</b><br>%DOWN_SERVERS%<br><b>Los siguientes servidores están en
 línea:</b><br>%UP_SERVERS%',
        'combi_telegram_message' => '<b>Los siguentes servidores están fuera de
 línea:</b><br>%DOWN_SERVERS%<br><b>Los siguientes servidores están en
 línea:</b><br>%UP_SERVERS%',
    ),
    'login' => array(
        'welcome_usermenu' => '%user_name%',
        'title_sign_in' => 'Por favor, inicie sesión',
        'title_forgot' => '¿Olvidaste tu contraseña?',
        'title_reset' => 'Restablecer su contraseña',
        'submit' => 'Enviar',
        'remember_me' => 'Recordarme',
        'login' => 'Iniciar sesión',
        'logout' => 'Salir',
        'username' => 'Nombre de usuario',
        'password' => 'Contraseña',
        'password_repeat' => 'Repita la contraseña',
        'password_forgot' => '¿Has olvidado tu contraseña?',
        'password_reset' => 'Perdí mi contraseña',
        'password_reset_email_subject' => 'Restablecer la contraseña para PHP Server Monitor',
        'password_reset_email_body' => 'Utilice el siguiente enlace para restablecer tu contraseña. Tenga en cuenta
 que expira de 1 hora.<br><br>%link%',
        'error_user_incorrect' => 'El nombre de usuario proporcionado no se pudo encontrar.',
        'error_login_incorrect' => 'La información es incorrecta.',
        'error_login_passwords_nomatch' => 'Las contraseñas proporcionadas no coinciden.',
        'error_reset_invalid_link' => 'El vínculo de cambio que ya ha proporcionado no es válido.',
        'success_password_forgot' => 'Un correo electrónico ha sido enviado a usted con información de cómo
 restablecer su contraseña.',
        'success_password_reset' => 'Su contraseña ha sido restablecida correctamente. Por favor, inicia sesión.',
    ),
    'error' => array(
        '401_unauthorized' => 'No Autorizado',
        '401_unauthorized_description' => 'Usted no tiene los privilegios para ver esta página.',
    ),
);
