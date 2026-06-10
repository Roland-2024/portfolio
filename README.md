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
php artisan optimize
```

Set the production URL and hosting credentials in `.env`. Never commit that
file. Configure the hosting document root to the `public` directory and ensure
`storage` and `bootstrap/cache` are writable by PHP.

The portfolio currently uses file-based sessions and cache, so a database is
not required until database-backed features are added.
