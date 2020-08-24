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
 * @author      Marco Gargani <http://www.marcogargani.it>
 * @copyright   Copyright (c) 2008-2017 Pepijn Over <pep@mailbox.org>
 * @license     http://www.gnu.org/licenses/gpl.txt GNU GPL v3
 * @version     Release: @package_version@
 * @link        http://www.phpservermonitor.org/
 **/

$sm_lang = array(
    'name' => 'Italiano - Italian',
    'locale' => array(
        '0' => 'it_IT.UTF-8',
        '1' => 'it_IT',
        '2' => 'italian',
        '3' => 'ita',
    ),
    'locale_tag' => 'it',
    'locale_dir' => 'ltr',
    'system' => array(
        'title' => 'Server Monitor',
        'install' => 'Installa',
        'action' => 'Azione',
        'save' => 'Salva',
        'edit' => 'Modifica',
        'delete' => 'Elimina',
        'date' => 'Data',
        'message' => 'Messaggio',
        'yes' => 'Sì',
        'no' => 'No',
        'insert' => 'Inserisci',
        'add_new' => 'Aggiungi Nuovo',
        'update_available' => 'Una nuova versione ({version}) è disponibile su <a
 href="https://github.com/phpservermon/phpservermon/releases/latest" target="_blank"
 rel="noopener">http://www.phpservermonitor.org</a>.',
        'back_to_top' => 'Torna su',
        'go_back' => 'Indietro',
        'ok' => 'OK',
        'cancel' => 'Annulla',
        'short_day_format' => '%e %B',
        'long_day_format' => '%e %B %Y',
        'yesterday_format' => 'Ieri alle %H:%M',
        'other_day_format' => '%A alle %H:%M',
        'never' => 'Mai',
        'hours_ago' => '%d ore fa',
        'an_hour_ago' => 'circa un ora fa',
        'minutes_ago' => '%d minuti fa',
        'a_minute_ago' => 'circa un minuto fa',
        'seconds_ago' => '%d secondi fa',
        'a_second_ago' => 'un secondo fa',
        'seconds' => 'secondi',
    ),
    'menu' => array(
        'config' => 'Configurazione',
        'server' => 'Servers',
        'server_log' => 'Log',
        'server_status' => 'Stato',
        'server_update' => 'Aggiorna',
        'user' => 'Utenti',
        'help' => 'Aiuto',
    ),
    'users' => array(
        'user' => 'Utente',
        'name' => 'Nome',
        'user_name' => 'Nome utente',
        'password' => 'Password',
        'password_repeat' => 'Ripeti password',
        'password_leave_blank' => 'Lascia vuoto per non modificare',
        'level' => 'Livello',
        'level_10' => 'Amministratore',
        'level_20' => 'Utente',
        'level_description' => 'Gli <b>Amministratori</b> hanno pieno accesso: possono gestire server, utenti e
 modificare la configurazione globale.<br>Gli <b>Utenti</b> possono solo visualizzare
 ed eseguire l\'aggiornamento per i server a cui sono assegnati.',
        'mobile' => 'Cellulare',
        'email' => 'Email',
        'pushover' => 'Pushover',
        'pushover_description' => 'Pushover è un servizio che rende semplice ottenere notifiche in tempo reale. Vedi
 <a href="https://pushover.net/">il loro sito web</a> per maggiori informazioni.',
        'pushover_key' => 'Pushover Key',
        'pushover_device' => 'Dispositivo Pushover',
        'pushover_device_description' => 'Nome del dispositivo a cui inviare il messaggio. Lascia vuoto per inviarlo a
 tutti i dispositivi.',
        'delete_title' => 'Elimina Utente',
        'delete_message' => 'Sei sicuro di voler eliminare l\'utente \'%1\'?',
        'deleted' => 'Utente eliminato.',
        'updated' => 'Utente aggiornato.',
        'inserted' => 'Utente aggiunto.',
        'profile' => 'Profilo',
        'profile_updated' => 'Il tuo profilo è stato aggiornato.',
        'error_user_name_bad_length' => 'Il nome utente deve essere composto da almeno 2 caratteri (massimo 64).',
        'error_user_name_invalid' => 'Lo username può contenere solo caratteri alfabetici (a-z, A-Z), numeri (0-9),
 il punto (.) ed la sottolineatura (_).',
        'error_user_name_exists' => 'Nome utente già in uso.',
        'error_user_email_bad_length' => 'L\'indirizzo Email deve essere composto da 5 a 255 caratteri.',
        'error_user_email_invalid' => 'Indirizzo Email non valido.',
        'error_user_level_invalid' => 'Livello utente non valido.',
        'error_user_no_match' => 'L\'utente non è stato trovato nel database.',
        'error_user_password_invalid' => 'La password inserita non è valida.',
        'error_user_password_no_match' => 'Le password inserite non corrispondono.',
    ),
    'log' => array(
        'title' => 'Righe log',
        'type' => 'Tipo',
        'status' => 'Stato',
        'email' => 'Email',
        'sms' => 'SMS',
        'pushover' => 'Pushover',
        'no_logs' => 'Nessun log',
        'clear' => 'Pulisci il registro',
        'delete_title' => 'Elimina log',
        'delete_message' => 'Sei sicuro di voler eliminare <b>tutti</b> i registri?',
    ),
    'servers' => array(
        'server' => 'Server',
        'status' => 'Stato',
        'label' => 'Nome',
        'domain' => 'Dominio/IP',
        'timeout' => 'Timeout',
        'timeout_description' => 'Numero di secondi da attendere per la risposta del server.',
        'port' => 'Porta',
        'type' => 'Tipo',
        'type_website' => 'Sito web',
        'type_service' => 'Servizio',
        'pattern' => 'Cerca stringa/pattern',
        'pattern_description' => 'Se questo pattern non è trovato nel sito web, il server verrà contrassegnato come
 fuori linea. Le espressioni regolari sono consentite.',
        'last_check' => 'Ultimo Controllo',
        'last_online' => 'Ultima volta Online',
        'last_offline' => 'Ultima volta offline',
        'monitoring' => 'Monitoraggio',
        'no_monitoring' => 'Non monitorato',
        'email' => 'Email',
        'send_email' => 'Invia Email',
        'sms' => 'SMS',
        'send_sms' => 'Invia SMS',
        'pushover' => 'Pushover',
        'users' => 'Utenti',
        'delete_title' => 'Elimina Server',
        'delete_message' => 'Sei sicuro di voler  eliminare il server \'%1\'?',
        'deleted' => 'Server eliminato.',
        'updated' => 'Server aggiornato.',
        'inserted' => 'Server aggiunto.',
        'latency' => 'Tempo di risposta',
        'latency_max' => 'Tempo di risposta (massimo)',
        'latency_min' => 'Tempo di risposta (minimo)',
        'latency_avg' => 'Tempo di risposta (medio)',
        'uptime' => 'Uptime',
        'year' => 'Anno',
        'month' => 'Mese',
        'week' => 'Settimana',
        'day' => 'Giorno',
        'hour' => 'Ora',
        'warning_threshold' => 'Soglia di allarme',
        'warning_threshold_description' => 'Numero richiesto di verifiche fallite prima di ritenerlo fuori linea.',
        'chart_last_week' => 'Ultima settimana',
        'chart_history' => 'Cronologia',
        'chart_day_format' => '%d-%m-%Y',
        'chart_long_date_format' => '%d-%m-%Y %H:%M:%S',
        'chart_short_date_format' => '%d/%m %H:%M',
        'chart_short_time_format' => '%H:%M',
        'warning_notifications_disabled_sms' => 'Le notifiche SMS sono disabilitate.',
        'warning_notifications_disabled_email' => 'Le notifiche Email sono disabilitate.',
        'warning_notifications_disabled_pushover' => 'Le notifiche Pushover sono disabilitate.',
        'error_server_no_match' => 'Server non trovato.',
        'error_server_label_bad_length' => 'L\'etichetta deve contenere da 1 a 255 caratteri.',
        'error_server_ip_bad_length' => 'Il dominio / IP deve contenere da 1 a 255 caratteri.',
        'error_server_ip_bad_service' => 'L\'indirizzo IP non è valido.',
        'error_server_ip_bad_website' => 'L\'indirizzo URL del sito web non è valido.',
        'error_server_type_invalid' => 'Tipologia di server selezionata non valida.',
        'error_server_warning_threshold_invalid' => 'La soglia d\'allarme deve essere un numero intero valido,
 superiore a zero.',
    ),
    'config' => array(
        'general' => 'Generale',
        'language' => 'Linguaggio',
        'show_update' => 'Controllare per nuovi aggiornamenti?',
        'email_status' => 'Permetti invio email',
        'email_from_email' => 'Indirizzo Email mittente',
        'email_from_name' => 'Nome Email mittente',
        'email_smtp' => 'Abilita SMTP',
        'email_smtp_host' => 'Server SMTP',
        'email_smtp_port' => 'Porta SMTP',
        'email_smtp_security' => 'Sicurezza SMTP',
        'email_smtp_security_none' => 'Nessuna',
        'email_smtp_username' => 'Nome utente SMTP',
        'email_smtp_password' => 'Password SMTP',
        'email_smtp_noauth' => 'Lasciare vuoto per nessuna autentificazione',
        'sms_status' => 'Permetti invio SMS',
        'sms_gateway' => 'Gateway da usare per inviare SMS',
        'sms_gateway_username' => 'Nome Utente Gateway',
        'sms_gateway_password' => 'Password Gateway',
        'sms_from' => 'Numero di telefono del mittente',
        'pushover_status' => 'Permetti invio messaggi da Pushover',
        'pushover_description' => 'Pushover è un servizio che rende semplice ottenere notifiche in tempo reale. Vedi
 <a href="https://pushover.net/">il loro sito web</a> per maggiori informazioni.',
        'pushover_clone_app' => 'Clicca qui per creare la tua Pushover app',
        'pushover_api_token' => 'Pushover App API Token',
        'pushover_api_token_description' => 'Prima di poter usare Pushover, devi <a href="%1$s" target="_blank"
 rel="noopener">registrare un\'App</a> nel loro sito web ed inserire la
 \'App API Token\' qui.',
        'alert_type' => 'Seleziona quando vuoi essere notificato',
        'alert_type_description' => '<b>Cambio di Stato:</b> Riceverai una notifica solo quando un server cambierà
 stato. Quindi da online -> offline oppure da offline -> online.<br><br /><b>Fuori
 linea:</b> Riceverai una notifica solo quando un server andrà offline *SOLO LA
 PRIMA VOLTA*. Per esempio, Se il tuo cronjob è impostato per controllare ogni 15
 min e il tuo server andrà offline dalle 2AM alle 6AM. Riceverai una sola
 notifica alle 2AM e nient\'altro.<br><br><b>Sempre:</b> Riceverai una notifica
 ogni volta che lo script troverà un server down anche se è stato offline per
 ore.',
        'alert_type_status' => 'Cambio di Stato',
        'alert_type_offline' => 'Fuori linea',
        'alert_type_always' => 'Sempre',
        'log_status' => 'Stato Log',
        'log_status_description' => 'Se lo Stato Log è impostato su VERO, il monitor registrerà nel log gli eventi
 appena le notifiche verranno inviate.',
        'log_email' => 'Registra email inviate dal sistema.',
        'log_sms' => 'Registra SMS inviati dal sistema.',
        'log_pushover' => 'Registra messaggi Pushover inviati dal sistema',
        'updated' => 'La configurazione è stato aggiornata.',
        'tab_email' => 'Email',
        'tab_sms' => 'SMS',
        'tab_pushover' => 'Pushover',
        'settings_email' => 'Impostazioni Email',
        'settings_sms' => 'Impostazioni SMS',
        'settings_pushover' => 'Impostazioni Pushover',
        'settings_notification' => 'Impostazioni Notifiche',
        'settings_log' => 'Impostazioni Log',
        'auto_refresh' => 'Auto-Aggiornamento',
        'auto_refresh_description' => 'Auto-Aggiornamento pagina servers.<br><span class="small">Tempo in secondi, se
 impostato a 0 la pagina non si aggiornerà.</span>',
        'test' => 'Test',
        'test_email' => 'Un Email verrà inviata all\'indirizzo specificato nel tuo profilo.',
        'test_sms' => 'Un SMS verrà inviato al numero di telefono specificato nel tuo profilo.',
        'test_pushover' => 'Una notifica Pushover verrà inviata al dispositivo specificato nel tuo profilo.',
        'send' => 'Invia',
        'test_subject' => 'Test',
        'test_message' => 'Messaggio di test',
        'email_sent' => 'Email inviata',
        'email_error' => 'Errore in invio Email',
        'sms_sent' => 'SMS inviato',
        'sms_error' => 'Errore in invio SMS. %s',
        'sms_error_nomobile' => 'Impossibile inviare SMS: nessun numero di telefono valido inserito nel tuo profilo.',
        'pushover_sent' => 'Notifica Pushover inviata',
        'pushover_error' => 'Riscontrato un errore durante l\'invio della notifica Pushover: %s',
        'pushover_error_noapp' => 'Impossibile inviare la notifica: nessun \'Pushover App API Token\' inserito nella
 configurazione globale.',
        'pushover_error_nokey' => 'Impossibile inviare la notifica: nessuna \'Pushover Key\' inserita nel tuo profilo.',
        'log_retention_period' => 'Periodo conservazione Log',
        'log_retention_period_description' => 'Numero di giorni per la conservazione dei log delle notifiche e
 risultati monitoraggio. Inserire 0 (zero) per disabilitare la
 cancellazione dei log.',
        'log_retention_days' => 'giorni',
    ),
    'notifications' => array(
        'off_sms' => 'Server \'%LABEL%\' INATTIVO: ip=%IP%, porta=%PORT%. Errore=%ERROR%',
        'off_email_subject' => 'IMPORTANTE: Il Server \'%LABEL%\' è INATTIVO',
        'off_email_body' => 'Impossibile connettersi al seguente server:<br><br>Server: %LABEL%<br>IP: %IP%<br>Porta:
 %PORT%<br>Errore: %ERROR%<br>Data: %DATE%',
        'off_pushover_title' => 'Server \'%LABEL%\' INATTIVO',
        'off_pushover_message' => 'Impossibile connettersi al seguente server:<br><br>Server: %LABEL%<br>IP:
 %IP%<br>Porta: %PORT%<br>Errore: %ERROR%<br>Data: %DATE%',
        'on_sms' => 'Server \'%LABEL%\' ATTIVO: ip=%IP%, porta=%PORT%, it was down for %LAST_OFFLINE_DURATION%',
        'on_email_subject' => 'IMPORTANTE: Server \'%LABEL%\' è ATTIVO',
        'on_email_body' => 'Server \'%LABEL%\' è di nuovo attivo, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Porta: %PORT%<br>Data:
 %DATE%',
        'on_pushover_title' => 'Server \'%LABEL%\' ATTIVO',
        'on_pushover_message' => 'Server \'%LABEL%\' è di nuovo attivo, it was down for
 %LAST_OFFLINE_DURATION%:<br><br>Server: %LABEL%<br>IP: %IP%<br>Porta:
 %PORT%<br>Data: %DATE%',
    ),
    'login' => array(
        'welcome_usermenu' => 'Benvenuto, %user_name%',
        'title_sign_in' => 'Registrati',
        'title_forgot' => 'Password dimenticata?',
        'title_reset' => 'Reimposta la tua password',
        'submit' => 'Invia',
        'remember_me' => 'Ricordami',
        'login' => 'Accedi',
        'logout' => 'Uscita',
        'username' => 'Nome utente',
        'password' => 'Password',
        'password_repeat' => 'Ripeti password',
        'password_forgot' => 'Password dimenticata?',
        'password_reset' => 'Reimposta password',
        'password_reset_email_subject' => 'Reimpossta la tua password per PHP Server Monitor',
        'password_reset_email_body' => 'Usa il seguente link per reimpostare la tua password. Ricordati che scade tra
 un ora.<br><br>%link%',
        'error_user_incorrect' => 'Il nome utente inserito non è staot trovato.',
        'error_login_incorrect' => 'Le informazioni sono errate.',
        'error_login_passwords_nomatch' => 'Le password inserite non sono valide.',
        'error_reset_invalid_link' => 'Il link di reimpostazione password non è valido.',
        'success_password_forgot' => 'Ti è stata inviata un\'Email con le istruzioni da seguire per reimpostare la
 tua password.',
        'success_password_reset' => 'La tua password è stata correttamente reimpostata. Ora puoi effettuare
 l\'accesso.',
    ),
    'error' => array(
        '401_unauthorized' => 'Non autorizzato',
        '401_unauthorized_description' => 'Non hai i permessi necessari per visualizzare questa pagina.',
    ),
);
