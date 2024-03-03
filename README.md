
<div align="center">
  <h1 align="center">Laravel Email Sentry</h1>
  <p align="center">
    An Awesome Email Monitoring and Management Package
    </p>
    <img src="info/screenshoot.png">
 <hr/>
</div>

### Description
*Laravel Email Sentry*  This Laravel package provides a robust solution for monitoring and managing email events within your application. It offers valuable features to enhance control and visibility over email sending and delivery processes.

**Key Features:**
- Seamless integration with Laravel applications
- Insights into email delivery and recipient engagement
- Intuitive configuration options
- Optimize your emails performance based on insights gained from *Laravel Email Sentry*.
- Email Event Monitoring: Logs email sending and sent events for comprehensive record-keeping and debugging purposes.
-  User-Centric Record Retrieval: Retrieves email sentry records associated with specific users.
- Pagination: Enables efficient navigation and retrieval of email records in paginated views.
- Filtering: Allows you to filter email records based on various criteria, such as sender, recipient, CC, BCC, and other attributes.
- Pruning: Provides a mechanism to remove older email sentry records, helping to manage storage space.

### Installation 
To install *Laravel Email Sentry* using Composer, run the following command in your Laravel project directory:

```bash
composer require ahmedwassef/laravel-email-sentry
```

```bash
# Publish the Configuration file
php artisan EmailSentry:publish
```


After installing  *Laravel Email Sentry* , you should also run the migrate command in order to create the table needed to store Data

```bash
php artisan migrate
```

## Configuration
You can configure Email Sentry by modifying the config/email-sentry.php configuration file. The configuration allows you to enable or disable email monitoring .

```php
// Publish the Configuration file
 
return [
    'enabled' => true,
 ];

```




### Usage
To start using Laravel Email Sentry, you need to instantiate the EmailSentry class and call its methods as per your requirements.

```php
// import and use Facade
use MailSentry;
```

```php

// Retrieve by user ID
$emails = MailSentry::getEmailsByUserId($userId);

// Paginate records
$emails = MailSentry::getEmailsPaginated($perPage);

// Filter records
$filters = ['from' => 'sender@example.com'];
$emails = MailSentry::filterEmails($filters, $perPage);

// Search by sender, recipient, etc.
$emails = MailSentry::getEmailsFrom($email, $name, $perPage); // ... similar methods for to, cc, bcc


```
### Compatibility
- Laravel 8.x and above


### Support:
For any inquiries or assistance, reach out  at ahmedwassef2015@gmail.com.

### License
*Laravel Email Sentry* is licensed under the [MIT License](https://opensource.org/licenses/MIT).

<p align="right">(<a href="#top">back to top</a>)</p>