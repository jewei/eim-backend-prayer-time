# EIM Prayer Time (backend)

A POC backend application to demostrate prayer time generation using PHP.

The only dependency on external PHP library is PHP Composer for autoloading.

The dev dependencies are for debugging, code checking and formating.

## Highlights

1. All OOP codes passed PHPStan max level checking.
2. This "build your own framework" was fun but make sure it's not going to production.
3. With the YAGNI principle, it should do one thing but do it well and do it right.
4. Minumum is the best.

## Setup

Requirements: PHP 8, Composer.

```shell
# Install PHP dependencies.
composer install

# Create a seeded database.
php console migrate --fast

# Create an empty database and populate with data.
php console migrate
```

## Mail

To receive email, apply an account from https://mailtrap.io. Then copy the
provided username and password to fill in `.env`.

## Future Development

As this is only a POC. In order to scale, here's the recommendation:

1. Use the Laravel Framework to access to their rich eco system.
2. Have a proper admin dashboard.
3. Implement push message via Firebase to initiate to play the voice over.
4. Point 3 should be able to support multiple devices from a user.
5. Expand to prayer zones outside Malaysia.
