<?php

declare(strict_types=1);

namespace App\Providers;

use App\ServiceProvider;

/**
 * Ultra basic native PHP mailer.
 *
 * This is to demostrate the mailing purpose only. For production, please use a
 * proper SMTP mail client.
 *
 * Note: Whether the PHP native mailer work or not depends on the PHP settings
 * of the server.
 */
final class Mailer extends ServiceProvider
{
    public function send(string $to, string $subject, string $message): bool
    {
        return mail($to, $subject, $message, [
            'Content-Type' => 'text/plain; charset=utf-8',
            'From' => 'no-reply@example.com',
            'Reply-To' => 'no-reply@example.com',
            'X-Mailer' => 'PHP/'.phpversion(),
        ]);
    }
}
