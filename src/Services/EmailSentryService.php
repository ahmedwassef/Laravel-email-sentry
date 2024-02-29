<?php

namespace Ahmedwassef\LaravelEmailSentry\Services;

use Ahmedwassef\LaravelEmailSentry\Models\EmailSentry;
use Illuminate\Pagination\LengthAwarePaginator;

class EmailSentryService
{
    protected $model;

    protected $chunkSize = 1000;

    public function __construct(EmailSentry $emailSentry)
    {
        $this->model = $emailSentry;
    }

    public function getChunkSize(): int
    {
        return $this->chunkSize;
    }

    /**
     * Prune email sentry records older than the specified date.
     *
     * This method deletes email sentry records that were created before the given date.
     * It repeatedly deletes records in chunks until no more records are deleted.
     *
     * @param \DateTimeInterface $before The date before which records should be pruned.
     * @return int The total number of records deleted.
     */
    public function prune(\DateTimeInterface $before)
    {
        $query = $this->model->where('created_at', '<', $before); // Create a query to retrieve records created before the specified date.
        $totalDeleted = 0; // Initialize a counter for total deleted records.

        do {
            $deleted = $query->take($this->chunkSize)->delete(); // Delete records in chunks.
            $totalDeleted += $deleted; // Update the total deleted count.
        } while ($deleted !== 0); // Repeat deletion until no more records are deleted.

        return $totalDeleted; // Return the total number of records deleted.
    }

    public function find($id)
    {
        return $this->model->find($id); // Paginate the email sentry records and return the result.
    }

    /**
     * Paginate email sentry records.
     *
     * This method paginates the email sentry records with a specified number of records per page.
     *
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function paginate(int $perPage = 15)
    {
        return $this->model->paginate($perPage); // Paginate the email sentry records and return the result.
    }


    /**
     * Filter email sentry records based on the provided filters.
     *
     * This method filters email sentry records based on the given filters array.
     * It constructs a query dynamically based on the filters and then paginates the results.
     *
     * @param array $filters An associative array where keys represent column names and values represent filter values.
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function filter(array $filters, int $perPage = 15)
    {
        $query = $this->model->newQuery(); // Start with a fresh query instance.

        foreach ($filters as $column => $value) {
            if ($value !== null) {
                if (in_array($column, ['from', 'to', 'cc', 'bcc'])) {
                    $query->whereJsonContains($column, $value); // Apply whereJsonContains for JSON columns.
                } else {
                    $query->where($column, $value); // Apply regular where clause.
                }
            }
        }

        return $query->paginate($perPage); // Paginate the results and return.
    }

    /**
     * Retrieve email sentry records by the sender's email address.
     *
     * This method retrieves email sentry records where the provided email address is present in the 'from' field.
     * Optionally, you can specify a name associated with the sender's email address.
     *
     * @param string $email The sender's email address.
     * @param string|null $name The sender's name (optional).
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getByFrom(string $email, string $name = null, int $perPage = 15)
    {
        $from = [$email => $name]; // Construct an associative array with email as key and name as value.
        return $this->model->whereJsonContains('from', $from)->paginate($perPage); // Retrieve records where 'from' field contains the constructed array.
    }

    /**
     * Retrieve email sentry records by the recipient's email address.
     *
     * This method retrieves email sentry records where the provided email address is present in the 'to' field.
     * Optionally, you can specify a name associated with the recipient's email address.
     *
     * @param string $email The recipient's email address.
     * @param string|null $name The recipient's name (optional).
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getByTo(string $email, string $name = null, int $perPage = 15)
    {
        $to = [$email => $name]; // Construct an associative array with email as key and name as value.
        return $this->model->whereJsonContains('to', $to)->paginate($perPage); // Retrieve records where 'to' field contains the constructed array.
    }


    /**
     * Retrieve email sentry records by the CC email address.
     *
     * This method retrieves email sentry records where the provided email address is present in the 'cc' field.
     * Optionally, you can specify a name associated with the email address.
     *
     * @param string $email The CC email address.
     * @param string|null $name The name associated with the CC email address (optional).
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getByCc(string $email, string $name = null, int $perPage = 15)
    {
        $cc = [$email => $name]; // Construct an associative array with email as key and name as value.
        return $this->model->whereJsonContains('cc', $cc)->paginate($perPage); // Retrieve records where 'cc' field contains the constructed array.
    }

    /**
     * Retrieve email sentry records by the BCC email address.
     *
     * This method retrieves email sentry records where the provided email address is present in the 'bcc' field.
     * Optionally, you can specify a name associated with the BCC email address.
     *
     * @param string $email The BCC email address.
     * @param string|null $name The name associated with the BCC email address (optional).
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getByBcc(string $email, string $name = null, int $perPage = 15)
    {
        $bcc = [$email => $name]; // Construct an associative array with email as key and name as value.
        return $this->model->whereJsonContains('bcc', $bcc)->paginate($perPage); // Retrieve records where 'bcc' field contains the constructed array.
    }

    /**
     * Retrieve email sentry records by the user ID.
     *
     * This method retrieves email sentry records associated with the specified user ID.
     *
     * @param int $userId The user ID.
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getByUserId(int $userId, int $perPage = 15)
    {
        return $this->model->where('user_id', $userId)->paginate($perPage); // Retrieve records where 'user_id' matches the provided user ID.
    }

}
