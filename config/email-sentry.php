<?php

return [

    /*
    |--------------------------------------------------------------------------
    | EMAIL_SENTRY Switch
    |--------------------------------------------------------------------------
    |
    | This option controls whether the Laravel Email Sentry package is enabled.
    | When set to true, the package functionality is enabled, allowing you to
    | monitor and manage email activity within your Laravel application.
    |
    */

    'enabled' => env('EMAIL_SENTRY_ENABLED', true),

    /*
       |--------------------------------------------------------------------------
       | EMAIL SENTRY Path
       |--------------------------------------------------------------------------
       |
       | This option defines the base path under which the Laravel Email Sentry
       | dashboard routes will be registered. You can customize this path to
       | suit your application's URL structure and preferences.
       |
       */

    'path' => env('EMAIL_SENTRY_PATH', 'email-sentry'),

    /*

    /*
      |--------------------------------------------------------------------------
      | EMAIL SENTRY Middleware
      |--------------------------------------------------------------------------
      |
      | This option defines the middleware applied to the Laravel Email Sentry
      | dashboard routes. By default, the 'auth' middleware is applied, which
      | ensures that only authenticated users can access the Email Sentry dashboard.
      | You can customize this array to include additional middleware as needed.
      |
    */
    'middleware' => [
        'auth',
    ],
];