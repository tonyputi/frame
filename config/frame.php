<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Frame Stack
    |--------------------------------------------------------------------------
    |
    | This configuration value informs Frame which "stack" you will be
    | using for your application. In general, this value is set for you
    | during installation and will not need to be changed after that.
    |
    */

    'stack' => env('FRAME_STACK', 'proxy'),

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
