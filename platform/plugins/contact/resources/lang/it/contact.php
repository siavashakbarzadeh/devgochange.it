<?php

return [
    'menu' => 'Contatti',
    'edit' => 'Visualizza contatto',
    'tables' => [
        'phone' => 'Telefono',
        'email' => 'Email',
        'full_name' => 'Nome completo',
        'time' => 'Orario',
        'address' => 'Indirizzo',
        'subject' => 'Oggetto',
        'content' => 'Contenuto',
    ],
    'contact_information' => 'Informazioni di contatto',
    'replies' => 'Risposte',
    'email' => [
        'header' => 'Email',
        'title' => 'Nuovo contatto dal tuo sito',
    ],
    'form' => [
        'name' => [
            'required' => 'Il nome è richiesto',
        ],
        'email' => [
            'required' => 'L\'email è richiesta',
            'email' => 'L\'indirizzo email non è valido',
        ],
        'content' => [
            'required' => 'Il contenuto è richiesto',
        ],
    ],
    'contact_sent_from' => 'Queste informazioni di contatto sono state inviate da',
    'sender' => 'Mittente',
    'sender_email' => 'Email',
    'sender_address' => 'Indirizzo',
    'sender_phone' => 'Telefono',
    'message_content' => 'Contenuto del messaggio',
    'sent_from' => 'Email inviata da',
    'form_name' => 'Nome',
    'form_email' => 'Email',
    'form_address' => 'Indirizzo',
    'form_subject' => 'Oggetto',
    'form_phone' => 'Telefono',
    'form_message' => 'Messaggio',
    'required_field' => 'Il campo con (<span style="color: red">*</span>) è obbligatorio.',
    'send_btn' => 'Invia messaggio',
    'new_msg_notice' => 'Hai <span class="bold">:count</span> Nuovi Messaggi',
    'view_all' => 'Visualizza tutto',
    'statuses' => [
        'read' => 'Letto',
        'unread' => 'Non letto',
    ],
    'phone' => 'Telefono',
    'address' => 'Indirizzo',
    'message' => 'Messaggio',
    'settings' => [
        'email' => [
            'title' => 'Contatto',
            'description' => 'Configurazione email di contatto',
            'templates' => [
                'notice_title' => 'Invia notifica all\'amministratore',
                'notice_description' => 'Modello di email per inviare notifiche all\'amministratore quando il sistema riceve un nuovo contatto',
            ],
        ],
        'title' => 'Contatto',
        'description' => 'Impostazioni per il plugin di contatto',
        'blacklist_keywords' => 'Parole chiave nella blacklist',
        'blacklist_keywords_placeholder' => 'parole chiave...',
        'blacklist_keywords_helper' => 'Metti nella blacklist le richieste di contatto se contengono queste parole chiave nel campo contenuto (separate da virgola).',
        'blacklist_email_domains' => 'Domini email nella blacklist',
        'blacklist_email_domains_placeholder' => 'dominio...',
        'blacklist_email_domains_helper' => 'Metti nella blacklist le richieste di contatto se il dominio email è nei domini nella blacklist (separate da virgola).',
        'enable_math_captcha' => 'Abilitare captcha matematico?',
    ],
    'no_reply' => 'Ancora nessuna risposta!',
    'reply' => 'Rispondi',
    'send' => 'Invia',
    'shortcode_name' => 'Modulo di contatto',
    'shortcode_description' => 'Aggiungi un modulo di contatto',
    'shortcode_content_description' => 'Aggiungere lo shortcode [contact-form][/contact-form] all\'editor?',
    'message_sent_success' => 'Messaggio inviato con successo!',
];
