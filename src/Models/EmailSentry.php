<?php

namespace Ahmedwassef\LaravelEmailSentry\Models;
use Illuminate\Database\Eloquent\Model;
class EmailSentry extends Model {

    protected  $table = 'email_sentry';

    /**
     * @var string[]
     */
    protected $fillable = [
        'email_id',
        'sent_at',
        'from'  ,
        'replyTo'  ,
        'to'  ,
        'cc'  ,
        'bcc' ,
        'attachments'  ,
        'user_id'  ,
        'subject'  ,
        'html'   ,
        'raw' ,
    ];

    protected $casts = [
        'from' => 'array',
        'replyTo' => 'array',
        'to' => 'array',
        'cc' => 'array',
        'bcc' => 'array',
        'attachments' => 'array',
    ];


}
