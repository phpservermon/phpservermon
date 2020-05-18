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
 * @author      Pepijn Over <pep@mailbox.org>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: v3.4.1
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Català - Catalan',
    'locale' => array(
        '0' => 'ca_ES.UTF-8',
        '1' => 'ca_ES',
        '2' => 'catalan',
        '3' => 'catalan-es',
    ),
    'locale_tag' => 'ca',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Instal·lar',
        'action' => 'Acció',
        'save' => 'Desar',
        'edit' => 'Editar',
        'delete' => 'Esborrar',
        'date' => 'Data',
        'message' => 'Missatge',
        'yes' => 'Sí',
        'no' => 'No',
        'insert' => 'Inserir',
        'add_new' => 'Afegir nou',
        'update_available' => 'Hi ha disponible una nova versió ({version}) a <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">https://github.com/phpservermon</a>.',
        'back_to_top' => 'Tornar a dalt',
        'go_back' => 'Enrere',
        'ok' => 'OK',
        'bad' => 'dolent',
        'cancel' => 'Cancel·lar',
        'none' => 'Cap',
        'activate' => 'Activar',
        'short_day_format' => '%e %B',
        'long_day_format' => '%e %B %Y',
        'yesterday_format' => 'Ahir a les %k:%M',
        'other_day_format' => '%A a les %k:%M',
        'never' => 'Mai',
        'hours_ago' => 'fa %d hores',
        'an_hour_ago' => 'fa una hora',
        'minutes_ago' => 'fa %d minuts',
        'a_minute_ago' => 'fa un minut',
        'seconds_ago' => 'fa %d segons',
        'a_second_ago' => 'fa un segon',
        'year' => 'any',
        'years' => 'anys',
        'month' => 'mes',
        'months' => 'mesos',
        'day' => 'dia',
        'days' => 'dies',
        'hour' => 'hora',
        'hours' => 'hores',
        'minute' => 'minut',
        'minutes' => 'minuts',
        'second' => 'segon',
        'seconds' => 'segons',
    ),
    'menu' => array(
        'config' => 'Configuració',
        'server' => 'Servidors',
        'server_log' => 'Log',
        'server_status' => 'Estat',
        'server_update' => 'FER PING ARA',
        'user' => 'Usuaris',
        'help' => 'Ajuda',
    ),
    'users' => array(
        'user' => 'Usuari',
        'name' => 'Nom',
        'user_name' => 'Nom d\'usuari',
        'password' => 'Contrasenya',
        'password_repeat' => 'Repetir contrasenya',
        'password_leave_blank' => 'Deixar en blanc si no es vol canviar',
        'level' => 'Nivell',
        'level_10' => 'Administrador',
        'level_20' => 'Usuari',
        'level_description' => 'Els <b>administradors</b> tenen accés complet: poden administrar servidors, usuaris i
 editar la configuració general.<br/>Els <b>usuaris</b> només poden engegar
 actualitzacions dels servidors que els han estat assignats.',
        'mobile' => 'Mòbil',
        'email' => 'Correu',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover és un servei que fa fàcil obtenir notificacions en temps real. Veieu <a
 href="https://pushover.net/" target="_blank">la seva web</a> per a més
 informació.',
        'pushover_key' => 'Clau Pushover',
        'pushover_device' => 'Dispositiu Pushover',
        'pushover_device_description' => 'Nom del dispositiu al qual enviar els missatges. Deixau en blanc per enviar
 a tots els dispositius.',
        'telegram' => 'Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> és una app de
 missatgeria  que facilita el rebre notificacions en temps real. Consulteu la <a
 href="http://docs.phpservermonitor.org/" target="_blank">documentació</a> per a
 més informació i per saber com instal·lar-ho.',
        'telegram_chat_id' => 'Codi ID del xat a Telegram',
        'telegram_chat_id_description' => 'Els missatges seran enviats al xat de Telegram amb aquest ID.',
        'telegram_get_chat_id' => 'Premeu aquí per a obtenir el codi ID del vostre xat',
        'activate_telegram' => 'Activar notificacions de Telegram',
        'activate_telegram_description' => 'Permetre a Telegram enviar notificacions al xat amb aquest ID. Sense
 aquest permís, Telegram rebutjarà qualsevol missatge enviat des
 d\'aquesta aplicació.',
        'telegram_bot_username_found' => 'S\'ha trobat el bot!<br><a href="%s" target="_blank"><button class="btn
 btn-primary">Següent pas</button></a> <br>S\'obrirà un xat amb el bot. És
 necessari que premeu el botó START o escriviu el comandament /start com a
 missatge pel bot.',
        'telegram_bot_username_error_token' => '401 - No autoritzat. Assegureu-vos que el token de la API és vàlid.',
        'telegram_bot_error' => 'Ha succeït un error mentre s\'intentava activar les notificacions amb Telegram: %s',
        'delete_title' => 'Esborrar usuari',
        'delete_message' => 'Aquesta és una acció irreversible, n\'esteu segurs de voler esborrar l\'usuari \'%1\'?',
        'deleted' => 'Usuari esborrat.',
        'updated' => 'Usuari actualitzat.',
        'inserted' => 'Usuari afegit.',
        'profile' => 'Perfil',
        'profile_updated' => 'El vostre perfil ha estat actualitzat.',
        'error_user_name_bad_length' => 'El nom d\'usuari ha de tenir entre 2 i 64 caràcters.',
        'error_user_name_invalid' => 'El nom d\'usuari només pot tenir caràcters alfanumèrics (a-z, A-Z), digits
 (0-9) i guions baixos (_).',
        'error_user_name_exists' => 'Aquest nom d\'usuari ja existeix. Esculliu un altre.',
        'error_user_email_bad_length' => 'L\'adreça de correu ha de tenir entre 5 i 255 caràcters.',
        'error_user_email_invalid' => 'L\'adreça de correu no és correcta.',
        'error_user_level_invalid' => 'Aquest nivell d\'usuari no és vàlid.',
        'error_user_no_match' => 'No s\'ha trobat aquest usuari a la base de dades.',
        'error_user_password_invalid' => 'Aquesta contrasenya no és vàlida.',
        'error_user_password_no_match' => 'LEs contrasenyes no coincideixen.',
    ),
    'log' => array(
        'title' => 'Entrades del LOG',
        'type' => 'Tipus',
        'status' => 'Estat',
        'email' => 'Correu',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'telegram' => 'Telegram',
        'no_logs' => 'No generar LOGs',
        'clear' => 'Netejar LOG',
        'delete_title' => 'Esborrar LOG',
        'delete_message' => 'Voleu esborrar <b>tots</b> els LOGs?',
    ),
    'servers' => array(
        'server' => 'Servidor',
        'status' => 'Estat',
        'label' => 'Etiqueta',
        'domain' => 'Domini/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Nombre de segons que cal esperar a que el servidor respongui.',
        'authentication_settings' => 'Opcions d\'autenticació (opcional)',
        'website_username' => 'Nom d\'usuari',
        'website_username_description' => 'Nom d\'usuari per accedir al portal web (només està soportada
 l\'autenticació d\'Apache).',
        'website_password' => 'Contrasenya',
        'website_password_description' => 'Contrasenya per accedir al portal web. La contrasenya es desa encriptada a
 la base de dades.',
        'fieldset_monitoring' => 'Monitorització',
        'fieldset_permissions' => 'Permisos',
        'port' => 'Port',
        'custom_port' => 'Port personalitzat',
        'popular_ports' => 'Ports populars',
        'request_method' => 'Mètode de crida',
        'custom_request_method' => 'Mètode de crida personalitzat',
        'popular_request_methods' => 'Mètodes de crida habituals',
        'post_field' => 'Camp POST',
        'post_field_description' => 'Els camps de dades que seran enviats emprant el mètode de crida de dalt.
 Exemple: param1=val1&amp;param2=val2&...',
        'please_select' => 'Seleccioneu',
        'type' => 'Tipus',
        'type_website' => 'Website',
        'type_service' => 'Servei',
        'type_ping' => 'Ping',
        'pattern' => 'cercar cadena/patrò',
        'pattern_description' => 'Si aquest patró no es troba al lloc web, el servidor es marcarà fora de línia. Es
 permeten expressions regulars.',
        'pattern_online' => 'El patró indica que el website és',
        'pattern_online_description' => 'En línia: si aquest patró es pot trobar en la resposta del servidor, el
 servidor serà marcat com en línia. Fóra de línia: si aquest patró no es
 pot trobar en la resposta del servidor, aquest serà marcat fóra de línia.',
        'redirect_check' => 'El redireccionament cap a un altre domini és',
        'redirect_check_description' => 'El redireccionament cap a un altre domini habitualment és un mal senyal.',
        'allow_http_status' => 'Permetre codi d\'estat HTTP',
        'allow_http_status_description' => 'Marcar el website com en línia. Els codis d\'estat HTTP inferiors a 400
 són marcats com en línia per defecte. Empreu el símbol | per separar
 més d\'un estat. Exemple: 401|403.',
        'header_name_description' => 'Nom de la capçalera (sensible a majúscules)',
        'header_value_description' => 'Valor de la capçalera. Es permeten expressions regulars.',
        'last_check' => 'Darrera comprovació',
        'last_online' => 'Darrer cop en línia',
        'last_offline' => 'Darrer cop fóra de línia',
        'last_output' => 'Darrera sortida positiva',
        'last_error' => 'Darrer error',
        'last_error_output' => 'Darrera sortida amb error',
        'monitoring' => 'Monitorització',
        'no_monitoring' => 'Sense monitorització',
        'email' => 'Correu',
        'send_email' => 'Enviar correu',
        'sms' => 'SMS',
        'send_sms' => 'Enviar SMS',
        'pushover' => 'Pushover',
        'send_pushover' => 'Enviar notificació per Pushover',
        'telegram' => 'Telegram',
        'send_telegram' => 'Enviar notificació per Telegram',
        'users' => 'Usuaris',
        'delete_title' => 'Esborrar servidor',
        'delete_message' => 'Esteu segurs de que voleu esborrar el servidor \'%1\'?',
        'deleted' => 'Servidor esborrat.',
        'updated' => 'Servidor actualitzat.',
        'inserted' => 'Servidor afegit.',
        'latency' => 'Latència',
        'latency_max' => 'Latència (màxima)',
        'latency_min' => 'Latència (mínima)',
        'latency_avg' => 'Latència (mitjana)',
        'uptime' => 'Temps actiu',
        'year' => 'Any',
        'month' => 'Mes',
        'week' => 'Setmana',
        'day' => 'Dia',
        'hour' => 'Hora',
        'warning_threshold' => 'Llindar \'advertència',
        'warning_threshold_description' => 'Nombre de comprovacions fallides necessàries abans de considerar el
 servidor fóra de línia.',
        'chart_last_week' => 'Darrera setmana',
        'chart_history' => 'Historial',
        'chart_day_format' => '%Y-%m-%d',
        'chart_long_date_format' => '%Y-%m-%d %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Les notificacions per SMS estan deshabilitades.',
        'warning_notifications_disabled_email' => 'Les notificacions per correu estan deshabilitades.',
        'warning_notifications_disabled_pushover' => 'Les notificacions per Pushover estan deshabilitades.',
        'warning_notifications_disabled_telegram' => 'Les notificacions per Telegram estan deshabilitades.',
        'error_server_no_match' => 'No s\'ha trobat el servidor.',
        'error_server_label_bad_length' => 'L\'etiqueta ha de tenir entre 1 i 255 caràcters.',
        'error_server_ip_bad_length' => 'El nom de domini o IP ha de tenir entre 1 i 255 caràcters.',
        'error_server_ip_bad_service' => 'L\'adreça IP no és vàlida',
        'error_server_ip_bad_website' => 'L\'adreça URL del lloc web no és vàlida.',
        'error_server_type_invalid' => 'El tipus de servidor escollit no és vàlid.',
        'error_server_warning_threshold_invalid' => 'El llindar d\'advertència ha de ser un valor sencer positiu.',
    ),
    'config' => array(
        'general' => 'General',
        'language' => 'Idioma',
        'show_update' => 'Comprovar actualitzacions?',
        'password_encrypt_key' => 'La clau per xifrar contrasenyes',
        'password_encrypt_key_note' => 'Aquesta és la clau emprada per xifrar les contrasenyes que són
 emmagatzemades als servidors per accedir als llocs web. Si la clau canviés la
 contrasenya guardada no seria vàlida!',
        'proxy' => 'Habilitar proxy',
        'proxy_url' => 'URL del proxy',
        'proxy_user' => 'Usuari del proxy',
        'proxy_password' => 'Contrasenya del proxy',
        'email_status' => 'Permetre l\'enviament de correus',
        'email_from_email' => 'Adreça del remitent',
        'email_from_name' => 'Nom del remitent',
        'email_smtp' => 'Habilitar SMTP',
        'email_smtp_host' => 'Servidor SMTP',
        'email_smtp_port' => 'Port SMTP',
        'email_smtp_security' => 'Seguretat SMTP',
        'email_smtp_security_none' => 'Cap',
        'email_smtp_username' => 'Usuari SMTP',
        'email_smtp_password' => 'Contrasenya SMTP',
        'email_smtp_noauth' => 'Deixar en blanc si no cal autenticació',
        'sms_status' => 'Permetre l\'enviament de missatges de text',
        'sms_gateway' => 'Servei \'Gateway\' per l\'enviament de SMS',
        'sms_gateway_username' => 'Usuari del Gateway',
        'sms_gateway_password' => 'Contrasenya del Gateway',
        'sms_from' => 'Numero de telèfon de qui envia',
        'pushover_status' => 'Permetre l\'enviament de missatges per Pushover',
        'pushover_description' => 'Pushover és un servei que facilita la recepció de notificacions en temps real.
 Veieu <a href=\'https://pushover.net/\'>la serv web</a> per a més informació.',
        'pushover_clone_app' => 'premeu aquí per a crear la vostra app Pushover',
        'pushover_api_token' => 'Token de la API de la App Pushover',
        'pushover_api_token_description' => 'Abans de poder emprar Pushover necessiteu <a href="%1$s"
 target="_blank">registrar una app</a> al seu portal web i introduïr
 aquí el Token de la API.',
        'telegram_status' => 'Permetre l\'enviament de missatges per Telegram',
        'telegram_description' => '<a href="https://telegram.org/" target="_blank">Telegram</a> és una app de xat
 (mòbil i PC) que facilita la recepció de notificacions en temps real. Veieu la <a
 href="http://docs.phpservermonitor.org/" target="_blank">documentació</a> per
 saber més i saber com activar-ho.',
        'telegram_api_token' => 'Token de l\'API de Telegram',
        'telegram_api_token_description' => 'Abans de poder emprar Telegram necessiteu obtenir un token de l\'API.
 Consulteu la <a href="http://docs.phpservermonitor.org/"
 target="_blank">documentació</a> per saber més.',
        'alert_type' => 'Seleccioneu quan voleu ser notificats.',
        'alert_type_description' => '<b>Canvi d\'estat:</b> Rebreu una notificació quan un servidor tingui un canvi
 d\'estat. És a dir, passi d\'estar en línia a fora de línia o viceversa.<br
 /><br /><b>Fora de línia:</b> Rebreu una notificació només *EL PRIMER COP* que
 un servidor passa a estar fora de línia. Per exemple, la vostra aplicació
 s\'executa cada 15 minuts i el servidor esdevé fora de línia a la una de la
 matinada i es queda així fins les sis. llavors rebríeu només una notificació.
 No se us aviasarà quan torni a ser en línia.<br /><br><b>Sempre:</b> Rebreu una
 notificació *CADA COP* que l\'aplicació detecti que el servidor és fora de
 línia, fins que torni a estar en línia.',
        'alert_type_status' => 'Canvi \'estat',
        'alert_type_offline' => 'Fora de línia',
        'alert_type_always' => 'Sempre',
        'combine_notifications' => 'Combinar notificacions',
        'combine_notifications_description' => 'Redueix el nombre de notificacions en combinar-les en una de sola.
 (Això no afecta a les notificacions per SMS.)',
        'alert_proxy' => 'Encara que s\'habiliti, el proxy no és emprat mai per als serveis',
        'alert_proxy_url' => '<b>Format:</b> Servidor:Port',
        'log_status' => 'LOG d\'estat',
        'log_status_description' => 'Si el LOG d\'estat es configura a SÍ, l\'aplicació enregistrarà aquells events
 que disparin les notificacions.',
        'log_email' => 'Enregistrar els correus enviats per l\'aplicació',
        'log_sms' => 'Enregistrar els SMS enviats per l\'aplicació',
        'log_pushover' => 'Enregistrar els missatges enviats a Pushover per l\'aplicació',
        'log_telegram' => 'Enregistrar els missatges enviats a Telegram per l\'aplicació',
        'updated' => 'S\'ha actualitzat la configuració',
        'tab_email' => 'Correu',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'tab_telegram' => 'Telegram',
        'settings_email' => 'Preferències de correu',
        'settings_sms' => 'Preferències de SMS',
        'settings_pushover' => 'Preferències de Pushover',
        'settings_telegram' => 'Preferències de Telegram',
        'settings_notification' => 'Preferències de notificacions',
        'settings_log' => 'Preferències de LOG',
        'settings_proxy' => 'Preferències de Proxy',
        'auto_refresh' => 'Auto-recàrrega',
        'auto_refresh_description' => 'Recarregar automàticament la plana Servidors.<br/><span class="small">Temps en
 segons, si poseu ZERO la plana no s\'auto-recarregarà.</span>',
        'test' => 'Provar',
        'test_email' => 'S\'enviarà un correu a l\'adreça que teniu al vostre perfil d\'usuari.',
        'test_sms' => 'S\'enviarà un SMS al telèfon que teniu al vostre perfil d\'usuari.',
        'test_pushover' => 'S\'enviarà una notificació per Pushover a la clau d\'usuari/dispositiu que teniu al
 vostre perfil d\'usuari.',
        'test_telegram' => 'S\'enviarà una notificació per Telegram al xat amb l\'ID que teniu al vostre perfil
 d\'usuari.',
        'send' => 'Enviar',
        'test_subject' => 'Provar',
        'test_message' => 'Missatge de prova',
        'email_sent' => 'Correu enviat',
        'email_error' => 'Hi ha hagut un error provant d\'enviar el correu',
        'sms_sent' => 'Sms enviat',
        'sms_error' => 'Hi ha hagut un error provant d\'enviar el SMS',
        'sms_error_nomobile' => 'No ha estat posible enviar el SMS de prova: no s\'ha trobat un telèfon vàlid al
 vostre perfil d\'usuari.',
        'pushover_sent' => 'Notificació enviada per Pushover',
        'pushover_error' => 'Ha succeït un error provant d\'enviar la notificació Pushover: %s',
        'pushover_error_noapp' => 'No ha estat posible enviar la notificació de prova: no s\'ha trobat cap token
 d\'API d\'una App Pushover a la configuració general.',
        'pushover_error_nokey' => 'No ha estat posible enviar la notificació de prova: no s\'ha trobat cap clau
 Pushover al vostre perfil d\'usuari.',
        'telegram_sent' => 'Notificació enviada per Telegram',
        'telegram_error' => 'Ha succeït un error provant d\'enviar la notificació per Telegram: %s',
        'telegram_error_notoken' => 'No ha estat posible enviar la notificació de prova: no s\'ha trobat cap token
 d\'API de Telegram a la configuració general.',
        'telegram_error_noid' => 'No ha estat posible enviar la notificació de prova: no s\'ha trobat cap codi ID de
 xat al vostre perfil d\'usuari.',
        'log_retention_period' => 'Període de retenció al LOG',
        'log_retention_period_description' => 'Nombre de dies a conservar al LOG les notificacions i informació sobre
 l\'activitat dels servidors. Poseu 0 per evitar que el LOG es buidi
 mai.',
        'log_retention_days' => 'dies',
    ),
    'notifications' => array(
        'off_sms' => 'El servidor \'%LABEL%\' NO RESPON: IP=%IP%, Port=%PORT%. Error=%ERROR%',
        'off_email_subject' => 'IMPORTANT: El servidor \'%LABEL%\' NO RESPON',
        'off_email_body' => 'Ha fallat la connexió amb aquest servidor:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Port: %PORT%<br/>Error: %ERROR%<br/>Data: %DATE%',
        'off_pushover_title' => 'El servidor \'%LABEL%\' NO RESPON',
        'off_pushover_message' => 'Ha fallat la connexió amb aquest servidor:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Port: %PORT%<br/>Error: %ERROR%<br/>Data: %DATE%',
        'off_telegram_message' => 'Ha fallat la connexió amb aquest servidor:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Port: %PORT%<br/>Error: %ERROR%<br/>Data: %DATE%',
        'on_sms' => 'El servidor \'%LABEL%\' TORNA A FUNCIONAR: ip=%IP%, port=%PORT%, temps
 caigut=%LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'IMPORTANT: el servidor \'%LABEL%\' TORNA A FUNCIONAR',
        'on_email_body' => 'El servidor \'%LABEL%\' TORNA A FUNCIONAR:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Port: %PORT%<br/>Data: %DATE%<br/>Temps fóra de línia: %LAST_OFFLINE_DURATION%',
        'on_pushover_title' => 'El servidor \'%LABEL%\' TORNA A FUNCIONAR',
        'on_pushover_message' => 'El servidor \'%LABEL%\' TORNA A FUNCIONAR:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Port: %PORT%<br/>Data: %DATE%<br/>Temps fóra de línia:
 %LAST_OFFLINE_DURATION%',
        'on_telegram_message' => 'El servidor \'%LABEL%\' TORNA A FUNCIONAR:<br/><br/>Servidor: %LABEL%<br/>IP:
 %IP%<br/>Port: %PORT%<br/>Data: %DATE%<br/>Temps fóra de línia:
 %LAST_OFFLINE_DURATION%',
        'combi_off_email_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Error:
 %ERROR%</li><li>Data: %DATE%</li></ul>',
        'combi_off_pushover_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Port:
 %PORT%</li><li>Error: %ERROR%</li><li>Data: %DATE%</li></ul>',
        'combi_off_telegram_message' => '- Servidor: %LABEL%<br/>- IP: %IP%<br/>- Port: %PORT%<br/>- Error:
 %ERROR%<br/>- Data: %DATE%<br/><br/>',
        'combi_on_email_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Data:
 %DATE%</li><li>Temps fóra de línia: %LAST_OFFLINE_DURATION%</li></ul>',
        'combi_on_pushover_message' => '<ul><li>Servidor: %LABEL%</li><li>IP: %IP%</li><li>Port: %PORT%</li><li>Data:
 %DATE%</li><li>Temps fóra de línia: %LAST_OFFLINE_DURATION%</li></ul>',
        'combi_on_telegram_message' => '- Servidor: %LABEL%<br/>- IP: %IP%<br/>- Port: %PORT%<br/>- Data: %DATE%<br/>-
 Temps fóra de línia: %LAST_OFFLINE_DURATION%<br/><br/>',
        'combi_email_subject' => 'IMPORTANT: els servidors \'%UP%\' TORNEN A FUNCIONAR, els servidors \'%DOWN%\' NO
 RESPONEN',
        'combi_pushover_subject' => 'Els servidors \'%UP%\' TORNEN A FUNCIONAR, els servidors \'%DOWN%\' NO RESPONEN',
        'combi_email_message' => '<b>Aquests servidors NO RESPONEN:</b><br/>%DOWN_SERVERS%<br/><b>Aquests servidors
 TORNEN A FUNCIONAR:</b><br/>%UP_SERVERS%',
        'combi_pushover_message' => '<b>Aquests servidors NO RESPONEN:</b><br/>%DOWN_SERVERS%<br/><b>Aquests servidors
 TORNEN A FUNCIONAR:</b><br/>%UP_SERVERS%',
        'combi_telegram_message' => '<b>Aquests servidors NO RESPONEN:</b><br/>%DOWN_SERVERS%<br/><b>Aquests servidors
 TORNEN A FUNCIONAR:</b><br/>%UP_SERVERS%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Benvingut(a), %user_name%',
        'title_sign_in' => 'Credencials d\'accés',
        'title_forgot' => 'Heu oblidat la contrasenya?',
        'title_reset' => 'Restablir la contrasenya',
        'submit' => 'Enviar',
        'remember_me' => 'Recorda\'m',
        'login' => 'Accedir',
        'logout' => 'Tancar sessió',
        'username' => 'Usuari',
        'password' => 'Contrasenya',
        'password_repeat' => 'Repetir contrasenya',
        'password_forgot' => 'Heu oblidat la contrasenya?',
        'password_reset' => 'Restablir la contrasenya',
        'password_reset_email_subject' => 'Restablir la vostra contrasenya per accedir a PHP Server Monitor',
        'password_reset_email_body' => 'Empreu el següent enllaç per restablir la vostra contrasenya. Tingueu en
 compte que expira en 1 hora.<br/><br/>%link%',
        'error_user_incorrect' => 'No s\'ha trobat l\'usuari especificat.',
        'error_login_incorrect' => 'Aquestes credencials no són vàlides.',
        'error_login_passwords_nomatch' => 'Les dues contrasenyes no coincideixen.',
        'error_reset_invalid_link' => 'L\'enllaç per restablir la contrasenya no és vàlid.',
        'success_password_forgot' => 'Se us ha enviat un correu amb informació per restablir la vostra contrasenya.',
        'success_password_reset' => 'La vostra contrasenya s\'ha restablert amb èxit. Ja podeu entrar.',
    ),
    'error' => array(
        '401_unauthorized' => 'No-autoritzat',
        '401_unauthorized_description' => 'No teniu els privilegis per veure aquesta plana o potser la vostra sessió
 ha expirat.',
    ),
);
