<?php

return [

    /*
    |--------------------------------------------------------------------------
    | View Storage Paths
    |--------------------------------------------------------------------------
    |
    | Menentukan lokasi folder template view. Mendukung 'resources/views'
    | dan 'resources/view' agar kompatibel penuh.
    |
    */

    'paths' => [
        resource_path('views'),
        resource_path('view'),
    ],

    /*
    |--------------------------------------------------------------------------
    | Compiled View Path
    |--------------------------------------------------------------------------
    */

    'compiled' => env(
        'VIEW_COMPILED_PATH',
        realpath(storage_path('framework/views'))
    ),

];
