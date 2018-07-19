# OVH migrate voicemail

__Warning : OVH process does not migrate existing messages to the new voicemail, so there's a risk of data loss at the moment.__

Get dependencies with composer

```composer install```

Launch once to create API credentials

```php migrate.php```

Launch to migrate afer configured properly

```php migrate.php [limit]```

[limit] sets the maximum number of migrations to start. If not set, migrate all voicemails.

exemples :

```php migrate.php 3```

or

```php migrate.php```