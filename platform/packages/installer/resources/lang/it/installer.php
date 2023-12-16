<?php

return [

    'title' => 'Installazione',
    'next' => 'Passo Successivo',
    'back' => 'Precedente',
    'finish' => 'Installa',
    'installation' => 'Installazione',
    'forms' => [
        'errorTitle' => 'Si sono verificati i seguenti errori:',
    ],

    'welcome' => [
        'templateTitle' => 'Benvenuto',
        'title' => 'Benvenuto',
        'message' => 'Prima di iniziare, abbiamo bisogno di alcune informazioni sul database. Dovrai conoscere i seguenti elementi prima di procedere.',
        'next' => 'Andiamo',
    ],

    'requirements' => [
        'templateTitle' => 'Passo 1 | Requisiti del Server',
        'title' => 'Requisiti del Server',
        'next' => 'Verifica Permessi',
    ],


    'permissions' => [
        'templateTitle' => 'Passo 2 | Permessi',
        'title' => 'Permessi',
        'next' => 'Configura l\'Ambiente',
    ],

    'environment' => [
        'wizard' => [
            'templateTitle' => 'Impostazioni dell\'Ambiente',
            'title' => 'Impostazioni dell\'Ambiente',
            'form' => [
                'name_required' => 'È richiesto un nome per l\'ambiente.',
                'app_name_label' => 'Titolo del Sito',
                'app_name_placeholder' => 'Titolo del Sito',
                'app_url_label' => 'URL',
                'app_url_placeholder' => 'URL',
                'db_connection_label' => 'Connessione al Database',
                'db_connection_label_mysql' => 'MySQL',
                'db_connection_label_sqlite' => 'SQLite',
                'db_connection_label_pgsql' => 'PostgreSQL',
                'db_host_label' => 'Host del Database',
                'db_host_placeholder' => 'Host del Database',
                'db_port_label' => 'Porta del Database',
                'db_port_placeholder' => 'Porta del Database',
                'db_name_label' => 'Nome del Database',
                'db_name_placeholder' => 'Nome del Database',
                'db_username_label' => 'Nome Utente del Database',
                'db_username_placeholder' => 'Nome Utente del Database',
                'db_password_label' => 'Password del Database',
                'db_password_placeholder' => 'Password del Database',
                'buttons' => [
                    'install' => 'Installa',
                ],
                'db_host_helper' => 'Se utilizzi Laravel Sail, cambia semplicemente DB_HOST in DB_HOST=mysql. In alcuni hosting, DB_HOST può essere localhost invece di 127.0.0.1',
                'db_connections' => [
                    'mysql' => 'MySQL',
                    'sqlite' => 'SQLite',
                    'pgsql' => 'PostgreSQL',
                ],
            ],
        ],
        'success' => 'Le impostazioni del file .env sono state salvate.',
        'errors' => 'Impossibile salvare il file .env. Si prega di crearlo manualmente.',
    ],

    'install' => 'Installa',

    'final' => [
        'title' => 'Installazione Completata',
        'templateTitle' => 'Installazione Completata',
        'finished' => 'L\'applicazione è stata installata con successo.',
        'exit' => 'Clicca qui per uscire',
    ],
    'create_account' => 'Crea account',
    'first_name' => 'Nome',
    'last_name' => 'Cognome',
    'username' => 'Nome Utente',
    'email' => 'Email',
    'password' => 'Password',
    'password_confirmation' => 'Conferma Password',
    'create' => 'Crea',
    'install_success' => 'Installato con successo!',
];


