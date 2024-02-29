<?php

namespace Ahmedwassef\LaravelEmailSentry;

use Ahmedwassef\LaravelEmailSentry\Overseers\EmailSendingOverseer;
use Ahmedwassef\LaravelEmailSentry\Overseers\EmailSentOverseer;
use Ahmedwassef\LaravelEmailSentry\Services\EmailSentryService;

class EmailSentry
{

    protected $emailSentryService;

    public function __construct(EmailSentryService $emailSentryService)
    {
        $this->emailSentryService = $emailSentryService;
    }




    /**
     * Determine if Email Sentry is Observing.
     *
     * @return bool
     */
    public  function isMonitoring()
    {
        return config('email-sentry.enabled') ;
    }

    /**
     * Monitor email events if enabled in the configuration.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    public  function monitor($app)
    {
        // Check if email monitoring is enabled in the configuration
        if (!self::isMonitoring()) {
            return; // If not enabled, exit the method
        }

        // Register overseers to monitor email events
        static::registerOverseers($app);
    }

    /**
     * Register overseers for email sending and sent events.
     *
     * @param  \Illuminate\Foundation\Application  $app
     * @return void
     */
    protected  function registerOverseers($app)
    {
        // Create an instance of EmailSendingOverseer for monitoring email sending events
        $sendingOverseer = new EmailSendingOverseer();
        $sendingOverseer->register($app);

        // Create an instance of EmailSentOverseer for monitoring email sent events
        $sentOverseer = new EmailSentOverseer();
        $sentOverseer->register($app);
    }


    public function find($id)
    {
        return $this->emailSentryService->find($id);
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
    public function getEmailsByUserId(int $userId, int $perPage = 15)
    {
        return $this->emailSentryService->getByUserId($userId, $perPage);
    }

    /**
     * Paginate email sentry records.
     *
     * This method paginates the email sentry records with a specified number of records per page.
     *
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getEmailsPaginated(int $perPage = 15)
    {
        return $this->emailSentryService->paginate($perPage);
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
    public function filterEmails(array $filters, int $perPage = 15)
    {
        return $this->emailSentryService->filter($filters, $perPage);
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
    public function getEmailsFrom(string $email, string $name = null, int $perPage = 15)
    {
        return $this->emailSentryService->getByFrom($email, $name, $perPage);
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
    public function getEmailsTo(string $email, string $name = null, int $perPage = 15)
    {
        return $this->emailSentryService->getByTo($email, $name, $perPage);
    }

    /**
     * Retrieve email sentry records by the CC email address.
     *
     * This method retrieves email sentry records where the provided email address is present in the 'cc' field.
     * Optionally, you can specify a name associated with the CC email address.
     *
     * @param string $email The CC email address.
     * @param string|null $name The name associated with the CC email address (optional).
     * @param int $perPage The number of records per page (default: 15).
     * @return LengthAwarePaginator The paginated records.
     */
    public function getEmailsCc(string $email, string $name = null, int $perPage = 15)
    {
        return $this->emailSentryService->getByCc($email, $name, $perPage);
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
    public function getEmailsBcc(string $email, string $name = null, int $perPage = 15)
    {
        return $this->emailSentryService->getByBcc($email, $name, $perPage);
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
    public function pruneEmailsOlderThan(\DateTimeInterface $before): int
    {
        return $this->emailSentryService->prune($before);
    }

}
