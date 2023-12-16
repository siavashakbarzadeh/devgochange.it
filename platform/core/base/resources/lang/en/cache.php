<?php

return [
    'cache_management' => 'Gestione della cache',
    'cache_commands' => 'Comandi per cancellare la cache',
    'commands' => [
        'clear_cms_cache' => [
            'title' => 'Cancella tutta la cache CMS',
            'description' => 'Cancella la cache CMS: cache del database, blocchi statici... Esegui questo comando quando non vedi i cambiamenti dopo aver aggiornato i dati.',
            'success_msg' => 'Cache pulita',
        ],
        'refresh_compiled_views' => [
            'title' => 'Aggiorna le viste compilate',
            'description' => 'Cancella le viste compilate per aggiornare le viste.',
            'success_msg' => 'Vista cache aggiornata',
        ],
        'clear_config_cache' => [
            'title' => 'Cancella la cache della configurazione',
            'description' => 'Potresti dover aggiornare la cache della configurazione quando modifichi qualcosa nell\'ambiente di produzione.',
            'success_msg' => 'Cache della configurazione pulita',
        ],
        'clear_route_cache' => [
            'title' => 'Cancella la cache delle rotte',
            'description' => 'Cancella la cache delle rotte.',
            'success_msg' => 'La cache delle rotte è stata pulita',
        ],
        'clear_log' => [
            'title' => 'Cancella log',
            'description' => 'Cancella i file di log del sistema',
            'success_msg' => 'Il log del sistema è stato pulito',
        ],
    ],
];

