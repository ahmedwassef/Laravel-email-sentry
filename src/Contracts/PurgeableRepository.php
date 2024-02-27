<?php

namespace Ahmedwassef\LaravelEmailSentry\Contracts;
use DateTimeInterface;

interface  PurgeableRepository
{

    /**
     * Purge  records older than the given date.
     *
     * @param  \DateTimeInterface  $before
     * @return int
     */
    public function purge(DateTimeInterface $before);
}