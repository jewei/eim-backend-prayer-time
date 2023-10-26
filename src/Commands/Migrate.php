<?php

declare(strict_types=1);

namespace App\Commands;

use App\Command;

final class Migrate extends Command
{
    /**
     * @param  array<int, string>  $arguments
     */
    public function handle(array $arguments): void
    {
        in_array('--fast', $arguments)
            ? $this->fast()
            : $this->normal();
    }

    private function normal(): void
    {
        $this->app->db()->executeRaw(
            file_read(base_path('database/tables.sql'))
        );

        echo 'Migration succsess';
    }

    private function fast(): void
    {
        $this->app->db()->executeRaw(
            file_read(base_path('database/database.sql'))
        );

        echo 'Migration succsess (fast)';
    }
}
