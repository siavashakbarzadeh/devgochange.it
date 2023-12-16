<?php

return [
    'settings' => [
        'title' => 'Impostazioni di Accesso Sociale',
        'description' => 'Configura le opzioni di accesso sociale',
        'facebook' => [
            'title' => 'Impostazioni di accesso Facebook',
            'description' => 'Abilita/disabilita e configura le credenziali dell\'app per l\'accesso a Facebook',
            'app_id' => 'ID App',
            'app_secret' => 'Segreto App',
            'helper' => 'Si prega di visitare https://developers.facebook.com per creare una nuova app e aggiornare l\'ID App, il Segreto App. L\'URL di callback è :callback',
        ],
        'google' => [
            'title' => 'Impostazioni di accesso Google',
            'description' => 'Abilita/disabilita e configura le credenziali dell\'app per l\'accesso a Google',
            'app_id' => 'ID App',
            'app_secret' => 'Segreto App',
            'helper' => 'Si prega di visitare https://console.developers.google.com/apis/dashboard per creare una nuova app e aggiornare l\'ID App, il Segreto App. L\'URL di callback è :callback',
        ],
        'github' => [
            'title' => 'Impostazioni di accesso Github',
            'description' => 'Abilita/disabilita e configura le credenziali dell\'app per l\'accesso a Github',
            'app_id' => 'ID App',
            'app_secret' => 'Segreto App',
            'helper' => 'Si prega di visitare https://github.com/settings/developers per creare una nuova app e aggiornare l\'ID App, il Segreto App. L\'URL di callback è :callback',
        ],
        'linkedin' => [
            'title' => 'Impostazioni di accesso Linkedin',
            'description' => 'Abilita/disabilita e configura le credenziali dell\'app per l\'accesso a Linkedin',
            'app_id' => 'ID App',
            'app_secret' => 'Segreto App',
            'helper' => 'Si prega di visitare https://www.linkedin.com/developers/apps/new per creare una nuova app e aggiornare l\'ID App, il Segreto App. L\'URL di callback è :callback',
        ],
        'enable' => 'Abilita?',
    ],
    'menu' => 'Accesso Sociale',
];

