<?php

// Define the namespace for the class
namespace Ahmedwassef\LaravelEmailSentry\Overseers;

// Import necessary classes
use Ahmedwassef\LaravelEmailSentry\Facades\EmailSentry;
use Illuminate\Mail\Events\MessageSending;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Part\AbstractPart;

// Define the class EmailSendingOverseer which extends Overseer class
class EmailSendingOverseer extends Overseer
{

    /**
     *  Register method to listen for email sending events
     * @param  \Illuminate\Contracts\Foundation\Application  $app
     * @return void
     */
    public function register($app)
    {
        // Register an event listener for MessageSending event
        $app['events']->listen(MessageSending::class, [$this, 'saveSendingEmail']);
    }

    /**
     * Method to record information about the email being sent
     * @param MessageSending $event
     * @return void
     */
    public function saveSendingEmail(MessageSending $event)
    {
        // Check if EmailSentry is monitoring
        if (!EmailSentry::isMonitoring()) {
            return; // If not, exit the method
        }

        // Get the body of the email
        $body = $event->message->getBody();

        // save various details of the email being sent
        $data =[
            'from' => $this->formatAddresses($event->message->getFrom()),
            'replyTo' => $this->formatAddresses($event->message->getReplyTo()),
            'to' => $this->formatAddresses($event->message->getTo()),
            'cc' => $this->formatAddresses($event->message->getCc()),
            'bcc' => $this->formatAddresses($event->message->getBcc()),
            'userId' => auth()->id() ?? NULL,
            'subject' => $event->message->getSubject(),
            'html' => $body instanceof AbstractPart ? ($event->message->getHtmlBody() ?? $event->message->getTextBody()) : $body,
        ];

        $data['email_id'] = md5(serialize($data));
        $data['raw'] =  $event->message->toString();
        \Ahmedwassef\LaravelEmailSentry\Models\EmailSentry::updateOrCreate(['email_id' => $data['email_id']], $data);

    }

    /**
     *  Method to format email addresses
     * @param array|null $addresses
     * @return array|null
     */
    protected function formatAddresses(?array $addresses)
    {
        // If addresses are null, return null
        if (is_null($addresses)) {
            return null;
        }

        // Format addresses
        return json_encode(collect($addresses)->flatMap(function ($address, $key) {
            if ($address instanceof Address) {
                return [$address->getAddress() => $address->getName()];
            }

            return [$key => $address];
        })->all(), JSON_PRETTY_PRINT);
    }
}
