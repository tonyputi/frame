<?php

return [
    /*
     |--------------------------------------------------------------------------
     | Frame Route Middleware
     |--------------------------------------------------------------------------
     |
     | Here you may specify which middleware Frame will assign to the routes
     | that it registers with the application. When necessary, you may modify
     | these middleware; however, this default value is usually sufficient.
     |
     */

    'middleware' => env('FRAME_MIDDLEWARE', ['proxy']),

    /*
     |--------------------------------------------------------------------------
     | Frame Domain
     |--------------------------------------------------------------------------
     |
     | Here you may specify on which domain Frame will assign to the routes
     | that it registers with the application.
     |
     */

    'domain' => env('FRAME_DOMAIN', 'io.videoslots.com'),

    /*
     |--------------------------------------------------------------------------
     | Frame Prefix
     |--------------------------------------------------------------------------
     |
     | Here you may specify on which prefix Frame will assign to the routes
     | that it registers with the application.
     |
     */

    'prefix' => env('FRAME_PREFIX', null),
];
