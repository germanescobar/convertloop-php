# ConvertLoop PHP API Client

A PHP client of the ConvertLoop REST API. You can sign up for a ConvertLoop account at  http://convertloop.co.

## Installation

### Requirements

PHP 5.3.3 and later.

### Composer

To install this library using Composer run the following command:

```
composer require convertloop/convertloop-php
```

To use it, use Composer's autoload:

```
require_once('vendor/autoload.php');
```

## Getting Started

First, you need to create an instance of `ConvertLoop\ConvertLoop` class passing your `app_id` and `api_key`:

```php
$convertloop = new \ConvertLoop\ConvertLoop("app_id", "api_key", "v1");
```

You are now ready to start calling the API methods:

### Creating or updating a person

You need to pass at least one of the following: `pid`, `user_id` or `email` to identify a user. Use `pid` when you are updating a guest of your site (you can obtain this value from the cookie `dp_pid`). Use `user_id` to match the `id` of the user in your application.

```php
$person = array(
    "email" => "german.escobar@convertloop.co",
    "first_name" => "German",
    "last_name" => "Escobar",
    "plan" => "free"
);
$convertloop->people()->createOrUpdate($person);
```

Any key different to `pid`, `user_id`, `email`, `first_seen_at`, `last_seen_at`, `add_tags`, and `remove_tags` will be treated as a **custom attribute** of the person.

You can add or remove tags using the `add_tags` and `remove_tags` keys:

```php
$person = array(
    "email" => "german.escobar@convertloop.co",
    "addTags" => array("Learn Something"),
    "removeTags" => array("Lead")
);
$convertloop->people()->createOrUpdate($person);
```

### Tracking an event

You can track an event for any person:

```php
$person = array("email" => "german.escobar@convertloop.co");
$event = array(
    "name" => "Billed",
    "person" => $person,
    "metadata" => array("credits" => 1000),
    "ocurred_at" => time()
);
$convertloop->eventLogs()->send($event);
```

If you don't specify the `ocurred_at` key, the current time will be used. You can use the `person` key to add **custom attributes** and **tags** to that person.
