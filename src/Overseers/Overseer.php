<?php

namespace Ahmedwassef\LaravelEmailSentry\Overseers;

/**
 * Abstract class representing a Overseer for monitoring email activity.
 */
abstract class Overseer
{

    /**
     * Register the Overseer with the Laravel application.
     *
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    abstract public function register($app);
}
