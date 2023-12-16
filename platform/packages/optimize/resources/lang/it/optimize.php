<?php

return [
    'settings' => [
        'title' => 'Ottimizza la velocità della pagina',
        'description' => 'Minimizza  output HTML, incorpora CSS, rimuove i commenti...',
        'enable' => 'Abilita  ottimizzazione della velocità della pagina?',
    ],
    'collapse_white_space' => 'Riduci spazi vuoti',
    'collapse_white_space_description' => 'Questo filtro riduce i byte trasmessi in un file HTML rimuovendo gli spazi vuoti non necessari.',
    'elide_attributes' => 'Rimuovi attributi',
    'elide_attributes_description' => 'Questo filtro riduce la dimensione di trasferimento dei file HTML rimuovendo gli attributi dalle tag quando il valore specificato è uguale al valore predefinito per quell attributo. Ciò può risparmiare un modesto numero di byte e rendere il documento più compressibile mediante la normalizzazione delle tag interessate.',
    'inline_css' => 'CSS incorporato',
    'inline_css_description' => 'Questo filtro trasforma  attributo inline "style" delle tag in classi spostando il CSS nell intestazione.',
    'insert_dns_prefetch' => 'Inserisci prefetch DNS',
    'insert_dns_prefetch_description' => 'Questo filtro inserisce tag nell intestazione per abilitare il prefetching DNS del browser.',
    'remove_comments' => 'Rimuovi commenti',
    'remove_comments_description' => 'Questo filtro elimina i commenti HTML, JS e CSS. Il filtro riduce la dimensione di trasferimento dei file HTML rimuovendo i commenti. A seconda del file HTML, questo filtro può ridurre significativamente il numero di byte trasmessi sulla rete.',
    'remove_quotes' => 'Rimuovi virgolette',
    'remove_quotes_description' => 'Questo filtro elimina le virgolette non necessarie dagli attributi HTML. Sebbene richieste dalle varie specifiche HTML, i browser consentono la loro omissione quando il valore di un attributo è composto da un certo sottoinsieme di caratteri (alfanumerici e alcuni segni di punteggiatura).',
    'defer_javascript' => 'Rinviare javascript',
    'defer_javascript_description' => 'Rinvia  esecuzione di javascript nell HTML. Se necessario, annulla il rinvio in alcuni script, utilizza data-pagespeed-no-defer come attributo dello script per annullare il rinvio.',
];

