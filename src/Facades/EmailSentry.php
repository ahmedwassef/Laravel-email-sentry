<?php

namespace Ahmedwassef\LaravelEmailSentry\Facades;
use Illuminate\Support\Facades\Facade;

class EmailSentry extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return 'EmailSentry';
    }

}
