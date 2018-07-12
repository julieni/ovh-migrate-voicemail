# OVH migrate voicemail

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