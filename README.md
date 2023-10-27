# EIM Prayer Time (backend)

This is a proof of concept (POC) backend application demonstrating prayer time generation using 100% PHP.

The only external dependency is PHP Composer for autoloading.

The development dependencies are for debugging, code checking, and formatting.

## Highlights

1. All object-oriented code has passed PHPStan max level checking.
2. Building your own framework can be fun, but it's not suitable for production use.
3. Adhering to the YAGNI (You Aren't Gonna Need It) principle, this application focuses on doing one thing well and correctly.
4. Emphasizing minimalism. Thurs SQLite is the databasa of choice.

## Setup

Requirements: PHP 8, Composer.

```shell
# Install PHP dependencies.
composer install

# Create a seeded database (prayer times might be outdated).
php console migrate --fast

# Create an empty database and populate it with sample data.
php console migrate
```

To keep prayer times data updated, create a daily cron job to fetch data for the seventh day.
```
# Run the script daily at 1AM.
0 1 * * * php /path/to/console fetch $(date +\%Y-\%m-\%d -d "7 days")
```

## Mail

To receive email, sign up for an account at https://mailtrap.io. Then, copy the provided username and password to fill in the `.env` file.

## Future Development

As this is only a proof of concept, for scalability, consider the following recommendations:

1. Use the Laravel Framework to access their rich ecosystem.
2. Develop a proper admin dashboard.
3. Implement push notifications via Firebase to play the call to prayer (Azan).
4. Ensure point 3 supports multiple devices for a single user.
5. Expand to cover prayer zones outside Malaysia.
