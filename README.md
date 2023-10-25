# EIM Prayer Time (backend)

A POC backend application to demostrate prayer time generation using PHP.

The only dependency on external PHP library is PHP Composer for autoloading.

The dev dependencies are for debugging, code checking and formating.

## Setup

Requirements: PHP 8, Composer.

```shell
# Install PHP dependencies.
composer install

# Create environment file and create database.
composer setup

# Seed the database.
composer fast-refresh
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
