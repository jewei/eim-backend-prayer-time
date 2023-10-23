<?php

declare(strict_types=1);

namespace App\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class FastSeedDatabase extends Command
{
    protected $signature = 'app:fast-seed-database';

    protected $description = 'Create tables and seed data super fast';

    public function handle(): void
    {
        file_put_contents(database_path('database.sqlite'), '');

        $queries = file_get_contents('database/database.sql');

        if ($queries !== false) {
            DB::unprepared($queries);
        }
    }
}
