<?php

/*
|--------------------------------------------------------------------------
| Nelo Dreams Foundation — public contact details
|--------------------------------------------------------------------------
| One place for the address, inbox and social pages the site links to, so a
| change here updates the header, footer, contact section and every page.
| Socials left as `null` are simply not rendered — no dead links.
*/

return [
    'email' => env('SITE_EMAIL', 'nelodreamsfoundationintl@gmail.com'),

    'location' => 'Enugu, Nigeria',

    'socials' => [
        'facebook' => 'https://www.facebook.com/share/1CXS1pQYgL/',
        'instagram' => null,
        'x-social' => null,
        'linkedin' => null,
        'youtube' => null,
    ],
];
