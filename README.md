# Roland Portfolio

Laravel portfolio website with a Windows XP-inspired desktop interface.

## Requirements

- PHP 8.2 or newer
- Composer
- Required Laravel PHP extensions

## Production Setup

```bash
composer install --no-dev --optimize-autoloader
cp .env.example .env
php artisan key:generate
php artisan storage:link
php artisan migrate --seed --force
php artisan optimize
```

Set the production URL and hosting credentials in `.env`. Never commit that
file. Configure the hosting document root to the `public` directory and ensure
`storage` and `bootstrap/cache` are writable by PHP.

Configure the MySQL database and mail server in `.env`. Set `ADMIN_EMAIL` and
`ADMIN_PASSWORD` before the first `php artisan db:seed` run; the values are used
only to create the first administrator when one does not already exist.

The public contact form stores messages in the dashboard and sends an email
notification. Demo portfolio content is inserted only when missing, so later
deployments and seed runs do not overwrite dashboard edits.
