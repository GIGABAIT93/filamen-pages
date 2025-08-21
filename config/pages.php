<?php

return [
    // Group label for pages in the Filament admin navigation. Set to
    // `null` to display pages without a group.
    'admin_navigation_group' => null,

    // Position of the pages group within the admin navigation menu.
    'admin_navigation_order' => 5,

    // Icon for the pages group in the admin navigation menu.
    'admin_navigation_icon' => 'heroicon-o-document-text',


    // Filament panel identifiers that should register the client-side
    // plugin. Uncomment and list your panel IDs below.
    'clients_panels_ids' => [
//        'client',
    ],

    // The Eloquent model representing application users.
    'user_model' => \App\Models\User::class,
];